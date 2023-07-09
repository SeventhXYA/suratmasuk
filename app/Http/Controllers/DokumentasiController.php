<?php

namespace App\Http\Controllers;

use App\Dokumentasi;
use App\RencanaKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class DokumentasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $rencanakerja = RencanaKerja::find($id);
        return view('ajudan.rencanakerja.adddokumentasi', [
            "title" => "Ubah Kategori dan Status"
        ], compact('rencanakerja'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated_data = $request->validate([
            'foto' => 'image',
            //id_suratmasuk dimasukan ke validasi untuk syarat mengisi foreignkey id_rencanakerja
            //yang ada pada tabel surat masuk
            'id_rencanakerja' => 'required',
        ]);

        //Validasi pertama untuk menyimpan rencana kerja kedalam tabel rencana kerja
        $filename = 'uploads/dokumentasi/' . Auth::user()->username . time() . '.jpg';

        $image = Image::make($request->file('foto')->getRealPath());

        $image->fit(800, 600);
        $image->encode('jpg', 90);
        $image->stream();
        Storage::disk('local')->put('public/' . $filename, $image, 'public');

        $validated_data['foto'] = 'storage/' . $filename;
        $dokumentasi = new Dokumentasi($validated_data);
        $dokumentasi->save();

        //Validasi kedua untuk mengisi foreignkey id_rencanakerja pada tabel surat masuk
        //isinya sesuai dengan id dari rencana kerja yang telah dibuat sebelumnya
        $rencanaKerja = RencanaKerja::find($validated_data['id_rencanakerja']);
        $rencanaKerja->dokumentasi()->associate($dokumentasi);
        $rencanaKerja->save();

        return redirect('ajudan/rencanakerja/datarencanakerja')->with('success', 'Dokumentasi berhasil ditambahkan!');
    }

    public function edit(Dokumentasi $dokumentasi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Dokumentasi  $dokumentasi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Dokumentasi $dokumentasi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Dokumentasi  $dokumentasi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dokumentasi $dokumentasi)
    {
        //
    }
}
