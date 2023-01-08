<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RkaPendapatanRequest;
use App\Models\RkaPendapatan;
use App\Models\RekeningPendapatan;
use Exception;
use Illuminate\Http\Request;

class RkaPendapatanController extends Controller
{
    public function __construct()
    {
        parent::__construct('rka_pendapatan');
    }

    public function index(Request $request)
    {
        $data['rkaPendapatans'] = RkaPendapatan::ta($request->cookie('ta'))
                                    ->orderBy(RekeningPendapatan::select('kode_rekening')
                                        ->whereColumn('rekening_pendapatans.id', 'rka_pendapatans.rekening_id')
                                    )
                                    ->paginate(10);
        return view('admin.rka_pendapatan.index', $data);
    }

    public function create()
    {
        $parent = RekeningPendapatan::orderBy('kode_rekening')->get();
        return view('admin.rka_pendapatan.create', compact('parent'));
    }

    public function store(RkaPendapatanRequest $request)
    {
        // return $request;
        try{
            // $rkaPendapatan = RkaPendapatan::create($request->all());
            $rkaPendapatan = new RkaPendapatan();
            $rkaPendapatan->ta = $request->ta;
            $rkaPendapatan->rekening_id = $request->rekening_id;
            $rkaPendapatan->nominal = $request->nominal;

            $alokasi = [
                'triwulan_1' => $request->triwulan_1,
                'triwulan_2' => $request->triwulan_2,
                'triwulan_3' => $request->triwulan_3,
                'triwulan_4' => $request->triwulan_4
            ];

            $rkaPendapatan->alokasi = $alokasi;
            $rkaPendapatan->save();

            $notification = array(
                'message' => 'Rka Pendapatan saved successfully!',
                'alert-type' => 'success'
            );

            return redirect()->route('admin.rka-pendapatans.index')->with($notification);

        } catch (Exception $e) {
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );

            return redirect()->route('admin.rka-pendapatans.index')->with($notification);
        }
    }

    public function show(RkaPendapatan $rkaPendapatan)
    {
        //
    }

    public function edit(RkaPendapatan $rkaPendapatan)
    {
        $data['parent'] = RekeningPendapatan::orderBy('kode_rekening')->get();
        $data['rkaPendapatan'] = $rkaPendapatan;
        return view('admin.rka_pendapatan.edit', $data);
    }

    public function update(RkaPendapatanRequest $request, RkaPendapatan $rkaPendapatan)
    {
        // return $request;
        try {
            $rkaPendapatan = $rkaPendapatan->update($request->all());

            $notification = array(
                'message' => 'Rka Pendapatan saved successfully!',
                'alert-type' => 'success'
            );

            return redirect()->route('admin.rka-pendapatans.index')->with($notification);
        } catch (Exception $e) {
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return redirect()->route('admin.rka-pendapatans.index')->with($notification);
        }
    }

    public function destroy(RkaPendapatan $rkaPendapatan)
    {
        try{
            RkaPendapatan::find($rkaPendapatan->id)->delete();

            $notification = array(
                'message' => 'Rka Pendapatan deleted successfully!',
                'alert-type' => 'success'
            );

            return redirect()->route('admin.rka-pendapatans.index')->with($notification);
        } catch (Exception $e) {
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return redirect()->route('admin.rka-pendapatans.index')->with($notification);
        }
    }
}
