<?php

namespace App\Http\Controllers;

use App\Models\Sesi;
use Illuminate\Http\Request;

class SesiController extends Controller
{
    public function index()
    {
        $sesis = Sesi::paginate(10);
        return view('admin.sesi.index', compact('sesis'));
    }

    public function create()
    {
        return view('admin.sesi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_sesi' => 'required|string|max:255',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'kuota' => 'required|integer|min:1',
        ]);

        Sesi::create($request->all());
        return redirect()->route('admin.sesi.index')->with('success', 'Sesi berhasil ditambahkan.');
    }

    public function edit(Sesi $sesi)
    {
        return view('admin.sesi.edit', compact('sesi'));
    }

    public function update(Request $request, Sesi $sesi)
    {
        $request->validate([
            'nama_sesi' => 'required|string|max:255',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'kuota' => 'required|integer|min:1',
        ]);

        $sesi->update($request->all());
        return redirect()->route('admin.sesi.index')->with('success', 'Sesi berhasil diupdate.');
    }

    public function destroy(Sesi $sesi)
    {
        $sesi->delete();
        return redirect()->route('admin.sesi.index')->with('success', 'Sesi berhasil dihapus.');
    }
}
