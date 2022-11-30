<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RekeningParentPendapatanRequest;
use App\Models\RekeningParentPendapatan;
use Exception;

class RekeningParentPendapatanController extends Controller
{
    public function __construct()
    {
        parent::__construct('rekening_parent_pendapatan');
    }

    public function index()
    {
        $data['rekeningParentPendapatans'] = RekeningParentPendapatan::orderBy('kode_parent')->paginate(10);
        return view('admin.rekening_parent_pendapatan.index', $data);
    }

    public function create()
    {
        return view('admin.rekening_parent_pendapatan.create');
    }

    public function store(RekeningParentPendapatanRequest $request)
    {
        try{
            $rekeningParentPendapatan = RekeningParentPendapatan::create($request->all());

            $notification = array(
                'message' => 'RekeningParentPendapatan saved successfully!',
                'alert-type' => 'success'
            );

            return redirect()->route('admin.rekening-parent-pendapatans.index')->with($notification);

        } catch (Exception $e) {
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );

            return redirect()->route('admin.rekening-parent-pendapatans.index')->with($notification);
        }
    }

    public function show(RekeningParentPendapatan $rekeningParentPendapatan)
    {
        //
    }

    public function edit(RekeningParentPendapatan $rekeningParentPendapatan)
    {
        $data['rekeningParentPendapatan'] = $rekeningParentPendapatan;
        return view('admin.rekening_parent_pendapatan.edit', $data);
    }

    public function update(RekeningParentPendapatanRequest $request, RekeningParentPendapatan $rekeningParentPendapatan)
    {
        try {
            $rekeningParentPendapatan = $rekeningParentPendapatan->update($request->all());

            $notification = array(
                'message' => 'RekeningParentPendapatan saved successfully!',
                'alert-type' => 'success'
            );

            return redirect()->route('admin.rekening-parent-pendapatans.index')->with($notification);
        } catch (Exception $e) {
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return redirect()->route('admin.rekening-parent-pendapatans.index')->with($notification);
        }
    }

    public function destroy(RekeningParentPendapatan $rekeningParentPendapatan)
    {
        try{
            RekeningParentPendapatan::find($rekeningParentPendapatan->id)->delete();

            $notification = array(
                'message' => 'RekeningParentPendapatan deleted successfully!',
                'alert-type' => 'success'
            );

            return redirect()->route('admin.rekening-parent-pendapatans.index')->with($notification);
        } catch (Exception $e) {
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return redirect()->route('admin.rekening-parent-pendapatans.index')->with($notification);
        }
    }
}
