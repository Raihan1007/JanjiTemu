<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Petugas;

class PetugasController extends Controller
{
    public function index()
    {
        $petugas = Petugas::latest()->get();
        return view('admin.petugas.index', compact('petugas'));
    }

    public function create()
    {
        return view('admin.petugas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'layanan_id' => 'required|exists:layanan,id'
        ]);

        Petugas::create([
            'nama' => $request->nama,
            'layanan_id' => $request->layanan_id
        ]);

        return redirect()->route('petugas.index')
            ->with('success', 'Petugas berhasil ditambahkan');

        return response()->json([
        'success' => true,
        'data' => $petugas->load('layanan')
        ]);
    }

    public function edit($id)
    {
        $petugas = Petugas::findOrFail($id);
        return view('admin.petugas.edit', compact('petugas'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'layanan' => 'required|string'
        ]);

        $petugas = Petugas::findOrFail($id);

        $petugas->update([
            'nama' => $request->nama,
            'layanan_id' => $request->layanan_id
        ]);

        return redirect()->route('petugas.index')
            ->with('success', 'Petugas berhasil diupdate');
    }

    public function destroy($id)
    {
        $petugas = Petugas::findOrFail($id);
        $petugas->delete();

        return redirect()->route('petugas.index')
            ->with('success', 'Petugas berhasil dihapus');
    }
}