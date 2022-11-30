<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\RkaPengeluaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\RkaPengeluaranResource;

class RkaPengeluaranController extends Controller
{
    public function __construct()
    {
        parent::__construct('rka_pengeluaran', 1);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rkaPengeluarans = RkaPengeluaran::latest()->paginate(10);
        return RkaPengeluaranResource::collection($rkaPengeluarans);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'title' => 'required',
        ]);

        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error']);
        }

        $rkaPengeluaran = RkaPengeluaran::create($data);
        return new RkaPengeluaranResource($rkaPengeluaran);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RkaPengeluaran  $rkaPengeluaran
     * @return \Illuminate\Http\Response
     */
    public function show(RkaPengeluaran $rkaPengeluaran)
    {
        return new RkaPengeluaranResource($rkaPengeluaran);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RkaPengeluaran  $rkaPengeluaran
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RkaPengeluaran $rkaPengeluaran)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'title' => 'required',
        ]);

        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error']);
        }

        $rkaPengeluaran->update($request->all());
        return new RkaPengeluaranResource($rkaPengeluaran);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RkaPengeluaran  $rkaPengeluaran
     * @return \Illuminate\Http\Response
     */
    public function destroy(RkaPengeluaran $rkaPengeluaran)
    {
        $rkaPengeluaran->delete();
        return new RkaPengeluaranResource($rkaPengeluaran);
    }

    /**
     * Search for a name
     *
     * @param  str  $name
     * @return \Illuminate\Http\Response
     */
    public function search($title)
    {
        $rkaPengeluarans = RkaPengeluaran::where('title', 'like', '%'.$title.'%')->get();
        return RkaPengeluaranResource::collection($rkaPengeluarans);
    }
}