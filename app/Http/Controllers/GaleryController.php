<?php

namespace App\Http\Controllers;

use App\Models\galery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GaleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $galeries = galery::where('user_id',Auth::user()->id)->get();
        return view('index',['galeries'=>$galeries]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'judul' => 'required',
            'foto' => 'required',
            'deskripsi' => 'required',
        ]);

        $namafoto = Auth::user()->id.'-' .date('YmdHis').
        $request->foto->getClientOriginalName();
        $data = [
            'judul' => $request->judul,
            'foto' => $namafoto,
            'deskripsi' => $request->deskripsi,
            'tanggal' => now(),
            'user_id' =>Auth::user()->id,
        ];
        galery::create($data);
        $request->foto->move(public_path('img'),$namafoto);
        return redirect('galery');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\galery  $galery
     * @return \Illuminate\Http\Response
     */
    public function show(galery $galery)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\galery  $galery
     * @return \Illuminate\Http\Response
     */
    public function edit(galery $galery)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\galery  $galery
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, galery $galery)
    {
        //
        if ($request->hasFile('foto')) {
            $namafoto = Auth::user()->id.'-' .date('YmdHis').
            $request->foto->getClientOriginalName();
            $request->foto->move(public_path('img'),$namafoto);
            $galery->judul = $request->judul;
            $galery->foto = $namafoto;
            $galery->deskripsi = $request->deskripsi;
            $galery->tanggal = now();
            $galery->user_id = Auth::user()->id;
            $galery->save();
        }else{
            $galery->judul=$request->judul;
            $galery->foto=$galery->foto;
            $galery->deskripsi=$request->deskripsi;
            $galery->tanggal = now();
            $galery->user_id=Auth::user()->id;
            $galery->save();
        }

        return redirect('galery');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\galery  $galery
     * @return \Illuminate\Http\Response
     */
    public function destroy(galery $galery)
    {
        //
    }
}
