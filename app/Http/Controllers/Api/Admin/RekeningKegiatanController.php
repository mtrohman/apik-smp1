<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\RekeningKegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\RekeningKegiatanResource;

class RekeningKegiatanController extends Controller
{
    public function __construct()
    {
        parent::__construct('rekening_kegiatan', 1);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rekeningKegiatans = RekeningKegiatan::latest()->paginate(10);
        return RekeningKegiatanResource::collection($rekeningKegiatans);
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

        $rekeningKegiatan = RekeningKegiatan::create($data);
        return new RekeningKegiatanResource($rekeningKegiatan);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RekeningKegiatan  $rekeningKegiatan
     * @return \Illuminate\Http\Response
     */
    public function show(RekeningKegiatan $rekeningKegiatan)
    {
        return new RekeningKegiatanResource($rekeningKegiatan);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RekeningKegiatan  $rekeningKegiatan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RekeningKegiatan $rekeningKegiatan)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'title' => 'required',
        ]);

        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error']);
        }

        $rekeningKegiatan->update($request->all());
        return new RekeningKegiatanResource($rekeningKegiatan);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RekeningKegiatan  $rekeningKegiatan
     * @return \Illuminate\Http\Response
     */
    public function destroy(RekeningKegiatan $rekeningKegiatan)
    {
        $rekeningKegiatan->delete();
        return new RekeningKegiatanResource($rekeningKegiatan);
    }

    /**
     * Search for a name
     *
     * @param  str  $name
     * @return \Illuminate\Http\Response
     */
    public function search($title)
    {
        $rekeningKegiatans = RekeningKegiatan::where('title', 'like', '%'.$title.'%')->get();
        return RekeningKegiatanResource::collection($rekeningKegiatans);
    }
}