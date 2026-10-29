<?php

namespace App\Http\Controllers;

use App\Models\Lapangan;
use Illuminate\Http\Request;

class LapanganController extends Controller
{
    public function index()
    {
        // Mengurutkan berdasarkan primary key id_lapangan
        $lapangans = Lapangan::orderBy('id_lapangan', 'desc')->get();
        return view('lapangan.index', compact('lapangans'));
    }

    public function create()
    {
        return view('lapangan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lapangan' => 'required|string|max:255',
            'jenis_permukaan' => 'required|string|max:255',
            'ukuran' => 'required|string|max:255',
            'status_lapangan' => 'required|string|max:50',
        ]);

        Lapangan::create($request->all());

        return redirect()->route('lapangan.index')
            ->with('success', 'Data lapangan berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $lapangan = Lapangan::where('id_lapangan', $id)->firstOrFail();
        return view('lapangan.edit', compact('lapangan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_lapangan' => 'required|string|max:255',
            'jenis_permukaan' => 'required|string|max:255',
            'ukuran' => 'required|string|max:255',
            'status_lapangan' => 'required|string|max:50',
        ]);

        $lapangan = Lapangan::where('id_lapangan', $id)->firstOrFail();
        $lapangan->update($request->all());

        return redirect()->route('lapangan.index')
            ->with('success', 'Data lapangan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $lapangan = Lapangan::where('id_lapangan', $id)->firstOrFail();
        $lapangan->delete();

        return redirect()->route('lapangan.index')
            ->with('success', 'Data lapangan berhasil dihapus!');
    }
}