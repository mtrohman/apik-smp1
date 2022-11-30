<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RekeningParentPengeluaranRequest;
use App\Models\RekeningParentPengeluaran;
use Exception;

class RekeningParentPengeluaranController extends Controller
{
    public function __construct()
    {
        parent::__construct('parent_pengeluaran');
    }

    public function index()
    {
        $data['rekeningParentPengeluarans'] = RekeningParentPengeluaran::orderBy('kode_parent')->paginate(10);
        return view('admin.rekening_parent_pengeluaran.index', $data);
    }

    public function create()
    {
        
        return view('admin.rekening_parent_pengeluaran.create');
    }

    public function store(RekeningParentPengeluaranRequest $request)
    {
        try{
            $rekeningParentPengeluaran = RekeningParentPengeluaran::create($request->all());

            $notification = array(
                'message' => 'Rekening Parent Pengeluaran saved successfully!',
                'alert-type' => 'success'
            );

            return redirect()->route('admin.rekening-parent-pengeluarans.index')->with($notification);

        } catch (Exception $e) {
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );

            return redirect()->route('admin.rekening-parent-pengeluarans.index')->with($notification);
        }
    }

    public function show(RekeningParentPengeluaran $rekeningParentPengeluaran)
    {
        //
    }

    public function edit(RekeningParentPengeluaran $rekeningParentPengeluaran)
    {
        $data['rekeningParentPengeluaran'] = $rekeningParentPengeluaran;
        return view('admin.rekening_parent_pengeluaran.edit', $data);
    }

    public function update(RekeningParentPengeluaranRequest $request, RekeningParentPengeluaran $rekeningParentPengeluaran)
    {
        try {
            $rekeningParentPengeluaran = $rekeningParentPengeluaran->update($request->all());

            $notification = array(
                'message' => 'Rekening Parent Pengeluaran saved successfully!',
                'alert-type' => 'success'
            );

            return redirect()->route('admin.rekening-parent-pengeluarans.index')->with($notification);
        } catch (Exception $e) {
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return redirect()->route('admin.rekening-parent-pengeluarans.index')->with($notification);
        }
    }

    public function destroy(RekeningParentPengeluaran $rekeningParentPengeluaran)
    {
        try{
            RekeningParentPengeluaran::find($rekeningParentPengeluaran->id)->delete();

            $notification = array(
                'message' => 'Rekening Parent Pengeluaran deleted successfully!',
                'alert-type' => 'success'
            );

            return redirect()->route('admin.rekening-parent-pengeluarans.index')->with($notification);
        } catch (Exception $e) {
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return redirect()->route('admin.rekening-parent-pengeluarans.index')->with($notification);
        }
    }
}
