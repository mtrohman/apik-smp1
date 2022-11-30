<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RkaPengeluaranRequest;
use App\Models\RekeningKegiatan;
use App\Models\RekeningPengeluaran;
use App\Models\RkaPengeluaran;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;


class RkaPengeluaranController extends Controller
{
    public function __construct()
    {
        parent::__construct('rka_pengeluaran');
    }

    public function index(Request $request)
    {
        $data['rkaPengeluarans'] = RkaPengeluaran::ta($request->cookie('ta'))
                                    ->orderBy(RekeningKegiatan::select('kode_kegiatan')
                                        ->whereColumn('rekening_kegiatans.id', 'rka_pengeluarans.kegiatan_id')
                                    )->paginate(10);
        return view('admin.rka_pengeluaran.index', $data);
    }

    public function create()
    {
        $parent = RekeningPengeluaran::orderBy('kode_rekening')->get();
        return view('admin.rka_pengeluaran.create', compact('parent'));
    }

    public function store(RkaPengeluaranRequest $request)
    {
        // return $request->all();
        try{
            // $rkaPengeluaran = RkaPengeluaran::create($request->all());
            $rkaPengeluaran = new RkaPengeluaran();
            $rkaPengeluaran->ta = $request->ta;
            $rkaPengeluaran->kegiatan_id = $request->kegiatan_id;
            $rkaPengeluaran->nominal = $request->nominal;
            
            
            $sumberdana = [
                'apbd' => $request->apbd,
                'bos' => $request->bos,
                'spm' => $request->spm
            ];

            $alokasi = [
                'triwulan_1' => $request->triwulan_1,
                'triwulan_2' => $request->triwulan_2,
                'triwulan_3' => $request->triwulan_3,
                'triwulan_4' => $request->triwulan_4
            ];

            $rkaPengeluaran->sumber_dana = $sumberdana;
            $rkaPengeluaran->alokasi = $alokasi;

            $rkaPengeluaran->save();

            $notification = array(
                'message' => 'Rka Pengeluaran saved successfully!',
                'alert-type' => 'success'
            );

            return redirect()->route('admin.rka-pengeluarans.index')->with($notification);

        } catch (Exception $e) {
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );

            return redirect()->route('admin.rka-pengeluarans.index')->with($notification);
        }
    }

    public function show(RkaPengeluaran $rkaPengeluaran)
    {
        //
    }

    public function edit(RkaPengeluaran $rkaPengeluaran)
    {
        $data['rkaPengeluaran'] = $rkaPengeluaran;
        return view('admin.rka_pengeluaran.edit', $data);
    }

    public function update(RkaPengeluaranRequest $request, RkaPengeluaran $rkaPengeluaran)
    {
        try {
            $rkaPengeluaran->update($request->all());

            $sumberdana = [
                'apbd' => $request->apbd,
                'bos' => $request->bos,
                'spm' => $request->spm
            ];

            $alokasi = [
                'triwulan_1' => $request->triwulan_1,
                'triwulan_2' => $request->triwulan_2,
                'triwulan_3' => $request->triwulan_3,
                'triwulan_4' => $request->triwulan_4
            ];

            $rkaPengeluaran->sumber_dana = $sumberdana;
            $rkaPengeluaran->alokasi = $alokasi;

            $rkaPengeluaran->save();

            $notification = array(
                'message' => 'Rka Pengeluaran saved successfully!',
                'alert-type' => 'success'
            );

            return redirect()->route('admin.rka-pengeluarans.index')->with($notification);
        } catch (Exception $e) {
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return redirect()->route('admin.rka-pengeluarans.index')->with($notification);
        }
    }

    public function destroy(RkaPengeluaran $rkaPengeluaran)
    {
        try{
            RkaPengeluaran::find($rkaPengeluaran->id)->delete();

            $notification = array(
                'message' => 'Rka Pengeluaran deleted successfully!',
                'alert-type' => 'success'
            );

            return redirect()->route('admin.rka-pengeluarans.index')->with($notification);
        } catch (Exception $e) {
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return redirect()->route('admin.rka-pengeluarans.index')->with($notification);
        }
    }
}
