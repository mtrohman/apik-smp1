<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\RekeningPengeluaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\RekeningPengeluaranResource;

class RekeningPengeluaranController extends Controller
{
    public function __construct()
    {
        parent::__construct('rekening_pengeluaran', 1);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rekeningPengeluarans = RekeningPengeluaran::latest()->paginate(10);
        return RekeningPengeluaranResource::collection($rekeningPengeluarans);
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

        $rekeningPengeluaran = RekeningPengeluaran::create($data);
        return new RekeningPengeluaranResource($rekeningPengeluaran);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RekeningPengeluaran  $rekeningPengeluaran
     * @return \Illuminate\Http\Response
     */
    public function show(RekeningPengeluaran $rekeningPengeluaran)
    {
        return new RekeningPengeluaranResource($rekeningPengeluaran);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RekeningPengeluaran  $rekeningPengeluaran
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RekeningPengeluaran $rekeningPengeluaran)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'title' => 'required',
        ]);

        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error']);
        }

        $rekeningPengeluaran->update($request->all());
        return new RekeningPengeluaranResource($rekeningPengeluaran);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RekeningPengeluaran  $rekeningPengeluaran
     * @return \Illuminate\Http\Response
     */
    public function destroy(RekeningPengeluaran $rekeningPengeluaran)
    {
        $rekeningPengeluaran->delete();
        return new RekeningPengeluaranResource($rekeningPengeluaran);
    }

    /**
     * Search for a name
     *
     * @param  str  $name
     * @return \Illuminate\Http\Response
     */
    public function search($title)
    {
        $rekeningPengeluarans = RekeningPengeluaran::where('title', 'like', '%'.$title.'%')->get();
        return RekeningPengeluaranResource::collection($rekeningPengeluarans);
    }
}