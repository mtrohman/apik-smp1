<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RekeningPendapatanRequest;
use App\Models\RekeningPendapatan;
use App\Models\RekeningParentPendapatan;
use Exception;

class RekeningPendapatanController extends Controller
{
    public function __construct()
    {
        parent::__construct('rekening_pendapatan');
    }

    public function index()
    {
        $data['rekeningPendapatans'] = RekeningPendapatan::orderBy('parent_id')->orderBy('kode_rekening')->paginate(10);
        return view('admin.rekening_pendapatan.index', $data);
    }

    public function create()
    {
        $parent = RekeningParentPendapatan::all();
        return view('admin.rekening_pendapatan.create', compact('parent'));
    }

    public function store(RekeningPendapatanRequest $request)
    {
        try{
            $rekeningPendapatan = RekeningPendapatan::create($request->all());

            $notification = array(
                'message' => 'Rekening Pendapatan saved successfully!',
                'alert-type' => 'success'
            );

            return redirect()->route('admin.rekening-pendapatans.index')->with($notification);

        } catch (Exception $e) {
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );

            return redirect()->route('admin.rekening-pendapatans.index')->with($notification);
        }
    }

    public function show(RekeningPendapatan $rekeningPendapatan)
    {
        //
    }

    public function edit(RekeningPendapatan $rekeningPendapatan)
    {
        $parent = RekeningParentPendapatan::all();
        return view('admin.rekening_pendapatan.edit', compact('parent', 'rekeningPendapatan'));
    }

    public function update(RekeningPendapatanRequest $request, RekeningPendapatan $rekeningPendapatan)
    {
        try {
            $rekeningPendapatan = $rekeningPendapatan->update($request->all());

            $notification = array(
                'message' => 'Rekening Pendapatan saved successfully!',
                'alert-type' => 'success'
            );

            return redirect()->route('admin.rekening-pendapatans.index')->with($notification);
        } catch (Exception $e) {
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return redirect()->route('admin.rekening-pendapatans.index')->with($notification);
        }
    }

    public function destroy(RekeningPendapatan $rekeningPendapatan)
    {
        try{
            RekeningPendapatan::find($rekeningPendapatan->id)->delete();

            $notification = array(
                'message' => 'Rekening Pendapatan deleted successfully!',
                'alert-type' => 'success'
            );

            return redirect()->route('admin.rekening-pendapatans.index')->with($notification);
        } catch (Exception $e) {
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return redirect()->route('admin.rekening-pendapatans.index')->with($notification);
        }
    }
}
