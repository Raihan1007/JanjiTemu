<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Petugas;
use App\Models\Layanan;
use App\Models\Rating;
use Illuminate\Support\Str;
use Carbon\Carbon;

class BookingController extends Controller
{
    // tampil halaman booking (form)
    
    public function create()
    {
        $layanans = Layanan::all();
        return view('booking', compact('layanans'));
    }
    
    // ambil slot yang sudah dibooking
    public function show(Booking $booking)
    {
        return response()->json(
            $booking->load('layanan', 'petugas')
        );
    }

    // simpan booking
    public function store(Request $request)
    {
        
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email',
            'nomor_hp' => 'required',
            'instansi' => 'required|string|max:255',
            'layanan_id' => 'required|exists:layanans,id',
            'tanggal' => 'required|date',
            'jam' => 'required'
        ]);

        // cek bentrok
        $exists = Booking::where('layanan_id', $request->layanan_id)
            ->where('tanggal', $request->tanggal)
            ->where('jam', $request->jam)
            ->exists();

        if ($exists) {
            return back()->withErrors([
                'jam' => 'Jadwal sudah dibooking, pilih jam lain'
            ])->withInput();
        }

        $kodeRef ='JT-' . date('Ymd') . '-' . strtoupper(Str::random(4));

        //  simpan ke DB
        $booking = Booking::create([
            'kode_referensi' => $kodeRef,

            'nama' => $request->nama,
            'email' => $request->email,
            'nomor_hp' => $request->nomor_hp,
            'instansi' => $request->instansi,
            'layanan_id' => $request->layanan_id,
            'tanggal' => $request->tanggal,
            'jam' => $request->jam,
            'status' => 'pending'
            
        ]);

        return redirect()->route('booking.confirmation', $booking->id);
    }

    // dashboard admin
    public function index()
    {
        $bookings = Booking::with('layanan','petugas')->latest()->get();
        return view('admin.dashboard', compact('bookings'));
    }

    public function confirm(Request $request, $id)
    {

    request()->validate([
        'petugas_id' => 'required'
    ]);
        $booking = Booking::findOrFail($id);

        $booking->status = 'confirmed';
        $booking->petugas_id = $request->petugas_id;
        $booking->link_meet = $request->link_meet;
        $booking->save();

        $phone = preg_replace('/^0/', '62', $booking->nomor_hp);

        // 🔥 PESAN WA
        $message =
 "Hallo {$booking->nama},

Booking kamu telah DIKONFIRMASI ✅

📌 Kode Referensi: {$booking->kode_referensi}
📅 Tanggal: {$booking->tanggal}
⏰ Jam: {$booking->jam}
👨‍💼 Petugas: ". ($booking->petugas->nama ?? '-');

        // kalau online
        if ($booking->link_meet) {
            $message .= "\n\n🔗 Link Meeting:\n{$booking->link_meet}";
        }

        $this->sendWhatsapp($phone, $message);

        return back();
    }

    public function cancel($id)
    {
        $booking = Booking::findOrFail($id);

        $booking->status = 'cancelled';
        $booking->save();

        $phone = preg_replace('/^0/', '62', $booking->nomor_hp);

        $message =
"Hallo {$booking->nama},

Mohon maaf, booking kamu dibatalkan ❌

📅 {$booking->tanggal}
⏰ {$booking->jam}";

        $this->sendWhatsapp($phone, $message);

        return back();
    }


        // HALAMAN PETUGAS
        public function petugasIndex()
            {
                $petugas = Petugas::with('layanan')->get();
                $layanans = Layanan::all();

                return view('admin.petugas', compact('petugas', 'layanans'));
            }
        // HALAMAN RATING
        public function ratingForm()
            {
                $petugas = Petugas::all();

                $layanans = Layanan::all();

                return view('rating', compact(
                    'petugas',
                    'layanans'
                ));
            }

        public function storeRating(Request $request)
        {
            $request->validate([
                'nama' => 'required',
                'nik' => 'required',
                'petugas_id' => 'required',
                'layanan_id' => 'required',
                'rating' => 'required|numeric|min:1|max:5'
            ]);

            Rating::create([

                'nama' => $request->nama,
                'nik' => $request->nik,

                'petugas_id' => $request->petugas_id,
                'layanan_id' => $request->layanan_id,

                'rating' => $request->rating

            ]);

            return back()->with(
                'success',
                'Terima kasih atas penilaian Anda'
            );
        }

        // simpan petugas
        public function storePetugas(Request $request)
        {
            $request->validate([
                'nama' => 'required',
                'layanan_id' => 'required'
            ]);

            Petugas::create([
                'nama' => $request->nama,
                'layanan_id' => $request->layanan_id
            ]);

            return back()->with('success', 'Petugas berhasil ditambahkan');
        }

        public function petugasShow($id)
        {
            $petugas = Petugas::findOrFail($id);
            return response()->json($petugas);
        }

        public function petugasUpdate(Request $request, $id) {
            $p = Petugas::findOrFail($id);
            $p->update($request->only('nama', 'layanan_id'));
            return response()->json(['success' => true]);
        }

        public function petugasDelete($id) {
            Petugas::destroy($id);
            return back();
        }

        private function sendWhatsapp($target, $message)
        {
            $token = env('FONNTE_TOKEN');

            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_URL => 'https://api.fonnte.com/send',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => [
                    'target' => $target,
                    'message' => $message,
                ],
                CURLOPT_HTTPHEADER => [
                    "Authorization: $token"
                ],
            ]);

            curl_exec($curl);
            curl_close($curl);
        }

    public function mulai($id)
    {
        $booking = Booking::findOrFail($id);
        $booking-> mulai = now()->format('H:i:s');
        $booking->save();
        return back();
    }

    public function selesai($id)
    {
        $booking = Booking::findOrFail($id);
        $booking-> selesai = now()->format('H:i:s');
        $booking->save();
        return back();
    }

    
}