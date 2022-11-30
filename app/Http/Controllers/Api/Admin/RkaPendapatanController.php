<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\RkaPendapatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\RkaPendapatanResource;

class RkaPendapatanController extends Controller
{
    public function __construct()
    {
        parent::__construct('rka_pendapatan', 1);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rkaPendapatans = RkaPendapatan::latest()->paginate(10);
        return RkaPendapatanResource::collection($rkaPendapatans);
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

        $rkaPendapatan = RkaPendapatan::create($data);
        return new RkaPendapatanResource($rkaPendapatan);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RkaPendapatan  $rkaPendapatan
     * @return \Illuminate\Http\Response
     */
    public function show(RkaPendapatan $rkaPendapatan)
    {
        return new RkaPendapatanResource($rkaPendapatan);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RkaPendapatan  $rkaPendapatan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RkaPendapatan $rkaPendapatan)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'title' => 'required',
        ]);

        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error']);
        }

        $rkaPendapatan->update($request->all());
        return new RkaPendapatanResource($rkaPendapatan);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RkaPendapatan  $rkaPendapatan
     * @return \Illuminate\Http\Response
     */
    public function destroy(RkaPendapatan $rkaPendapatan)
    {
        $rkaPendapatan->delete();
        return new RkaPendapatanResource($rkaPendapatan);
    }

    /**
     * Search for a name
     *
     * @param  str  $name
     * @return \Illuminate\Http\Response
     */
    public function search($title)
    {
        $rkaPendapatans = RkaPendapatan::where('title', 'like', '%'.$title.'%')->get();
        return RkaPendapatanResource::collection($rkaPendapatans);
    }
}