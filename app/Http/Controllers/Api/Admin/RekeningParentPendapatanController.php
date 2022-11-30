<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\RekeningParentPendapatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\RekeningParentPendapatanResource;

class RekeningParentPendapatanController extends Controller
{
    public function __construct()
    {
        parent::__construct('rekening_parent_pendapatan', 1);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rekeningParentPendapatans = RekeningParentPendapatan::latest()->paginate(10);
        return RekeningParentPendapatanResource::collection($rekeningParentPendapatans);
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

        $rekeningParentPendapatan = RekeningParentPendapatan::create($data);
        return new RekeningParentPendapatanResource($rekeningParentPendapatan);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RekeningParentPendapatan  $rekeningParentPendapatan
     * @return \Illuminate\Http\Response
     */
    public function show(RekeningParentPendapatan $rekeningParentPendapatan)
    {
        return new RekeningParentPendapatanResource($rekeningParentPendapatan);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RekeningParentPendapatan  $rekeningParentPendapatan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RekeningParentPendapatan $rekeningParentPendapatan)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'title' => 'required',
        ]);

        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error']);
        }

        $rekeningParentPendapatan->update($request->all());
        return new RekeningParentPendapatanResource($rekeningParentPendapatan);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RekeningParentPendapatan  $rekeningParentPendapatan
     * @return \Illuminate\Http\Response
     */
    public function destroy(RekeningParentPendapatan $rekeningParentPendapatan)
    {
        $rekeningParentPendapatan->delete();
        return new RekeningParentPendapatanResource($rekeningParentPendapatan);
    }

    /**
     * Search for a name
     *
     * @param  str  $name
     * @return \Illuminate\Http\Response
     */
    public function search($title)
    {
        $rekeningParentPendapatans = RekeningParentPendapatan::where('title', 'like', '%'.$title.'%')->get();
        return RekeningParentPendapatanResource::collection($rekeningParentPendapatans);
    }
}