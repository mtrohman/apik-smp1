<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RekeningPengeluaranRequest;
use App\Models\RekeningPengeluaran;
use App\Models\RekeningParentPengeluaran;
use Exception;

class RekeningPengeluaranController extends Controller
{
    public function __construct()
    {
        parent::__construct('rekening_pengeluaran');
    }

    public function index()
    {
        $data['rekeningPengeluarans'] = RekeningPengeluaran::orderBy('parent_id')->orderBy('kode_rekening')->paginate(10);
        return view('admin.rekening_pengeluaran.index', $data);
    }

    public function create()
    {
        $parent = RekeningParentPengeluaran::all();
        return view('admin.rekening_pengeluaran.create', compact('parent'));
    }

    public function store(RekeningPengeluaranRequest $request)
    {
        try{
            $rekeningPengeluaran = RekeningPengeluaran::create($request->all());

            $notification = array(
                'message' => 'Rekening Pengeluaran saved successfully!',
                'alert-type' => 'success'
            );

            return redirect()->route('admin.rekening-pengeluarans.index')->with($notification);

        } catch (Exception $e) {
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );

            return redirect()->route('admin.rekening-pengeluarans.index')->with($notification);
        }
    }

    public function show(RekeningPengeluaran $rekeningPengeluaran)
    {
        //
    }

    public function edit(RekeningPengeluaran $rekeningPengeluaran)
    {
        $parent = RekeningParentPengeluaran::all();
        return view('admin.rekening_pengeluaran.edit', compact('parent', 'rekeningPengeluaran'));
    }

    public function update(RekeningPengeluaranRequest $request, RekeningPengeluaran $rekeningPengeluaran)
    {
        try {
            $rekeningPengeluaran = $rekeningPengeluaran->update($request->all());

            $notification = array(
                'message' => 'Rekening Pengeluaran saved successfully!',
                'alert-type' => 'success'
            );

            return redirect()->route('admin.rekening-pengeluarans.index')->with($notification);
        } catch (Exception $e) {
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return redirect()->route('admin.rekening-pengeluarans.index')->with($notification);
        }
    }

    public function destroy(RekeningPengeluaran $rekeningPengeluaran)
    {
        try{
            RekeningPengeluaran::find($rekeningPengeluaran->id)->delete();

            $notification = array(
                'message' => 'Rekening Pengeluaran deleted successfully!',
                'alert-type' => 'success'
            );

            return redirect()->route('admin.rekening-pengeluarans.index')->with($notification);
        } catch (Exception $e) {
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return redirect()->route('admin.rekening-pengeluarans.index')->with($notification);
        }
    }
}
