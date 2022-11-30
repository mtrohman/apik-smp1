<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\RekeningParentPengeluaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\RekeningParentPengeluaranResource;

class RekeningParentPengeluaranController extends Controller
{
    public function __construct()
    {
        parent::__construct('rekening_parent_pengeluaran', 1);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rekeningParentPengeluarans = RekeningParentPengeluaran::latest()->paginate(10);
        return RekeningParentPengeluaranResource::collection($rekeningParentPengeluarans);
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

        $rekeningParentPengeluaran = RekeningParentPengeluaran::create($data);
        return new RekeningParentPengeluaranResource($rekeningParentPengeluaran);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RekeningParentPengeluaran  $rekeningParentPengeluaran
     * @return \Illuminate\Http\Response
     */
    public function show(RekeningParentPengeluaran $rekeningParentPengeluaran)
    {
        return new RekeningParentPengeluaranResource($rekeningParentPengeluaran);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RekeningParentPengeluaran  $rekeningParentPengeluaran
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RekeningParentPengeluaran $rekeningParentPengeluaran)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'title' => 'required',
        ]);

        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error']);
        }

        $rekeningParentPengeluaran->update($request->all());
        return new RekeningParentPengeluaranResource($rekeningParentPengeluaran);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RekeningParentPengeluaran  $rekeningParentPengeluaran
     * @return \Illuminate\Http\Response
     */
    public function destroy(RekeningParentPengeluaran $rekeningParentPengeluaran)
    {
        $rekeningParentPengeluaran->delete();
        return new RekeningParentPengeluaranResource($rekeningParentPengeluaran);
    }

    /**
     * Search for a name
     *
     * @param  str  $name
     * @return \Illuminate\Http\Response
     */
    public function search($title)
    {
        $rekeningParentPengeluarans = RekeningParentPengeluaran::where('title', 'like', '%'.$title.'%')->get();
        return RekeningParentPengeluaranResource::collection($rekeningParentPengeluarans);
    }
}