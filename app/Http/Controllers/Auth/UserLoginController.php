<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserLoginController extends Controller
{
    public function login(Request $request)
{
    $validated = $request->validate([
        'nama' => 'required|string|max:255',
        'tanggal_lahir' => 'required|date',
        'nik' => 'required|string|size:16',
    ]);

    try {
        $user = User::where('nik', $validated['nik'])->first();

        if (!$user) {
            // 🔥 user baru
            $user = User::create([
                'nama' => $validated['nama'],
                'nik' => $validated['nik'],
                'tanggal_lahir' => $validated['tanggal_lahir'],
            ]);
        } else {
           // 🔥 NORMALISASI TANGGAL
            $inputTanggal = Carbon::parse($validated['tanggal_lahir'])->format('Y-m-d');
            $dbTanggal = Carbon::parse($user->tanggal_lahir)->format('Y-m-d');

            // 🔥 VALIDASI
            if (
                strtolower(trim($user->nama)) !== strtolower(trim($validated['nama'])) ||
                $dbTanggal !== $inputTanggal
            ) {
                return back()->withErrors([
                    'login' => 'Data tidak sesuai dengan yang sudah terdaftar'
                ]);
            }
        }

        Auth::guard('web')->login($user);

        return redirect()->route('landing');

    } catch (\Exception $e) {
        return back()->withInput()->withErrors([
            'login' => 'Gagal login'
        ]);
    }
}
}