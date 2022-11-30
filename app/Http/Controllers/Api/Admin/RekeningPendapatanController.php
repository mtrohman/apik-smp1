<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\RekeningPendapatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\RekeningPendapatanResource;

class RekeningPendapatanController extends Controller
{
    public function __construct()
    {
        parent::__construct('rekening_pendapatan', 1);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rekeningPendapatans = RekeningPendapatan::latest()->paginate(10);
        return RekeningPendapatanResource::collection($rekeningPendapatans);
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

        $rekeningPendapatan = RekeningPendapatan::create($data);
        return new RekeningPendapatanResource($rekeningPendapatan);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RekeningPendapatan  $rekeningPendapatan
     * @return \Illuminate\Http\Response
     */
    public function show(RekeningPendapatan $rekeningPendapatan)
    {
        return new RekeningPendapatanResource($rekeningPendapatan);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RekeningPendapatan  $rekeningPendapatan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RekeningPendapatan $rekeningPendapatan)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'title' => 'required',
        ]);

        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error']);
        }

        $rekeningPendapatan->update($request->all());
        return new RekeningPendapatanResource($rekeningPendapatan);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RekeningPendapatan  $rekeningPendapatan
     * @return \Illuminate\Http\Response
     */
    public function destroy(RekeningPendapatan $rekeningPendapatan)
    {
        $rekeningPendapatan->delete();
        return new RekeningPendapatanResource($rekeningPendapatan);
    }

    /**
     * Search for a name
     *
     * @param  str  $name
     * @return \Illuminate\Http\Response
     */
    public function search($title)
    {
        $rekeningPendapatans = RekeningPendapatan::where('title', 'like', '%'.$title.'%')->get();
        return RekeningPendapatanResource::collection($rekeningPendapatans);
    }
}