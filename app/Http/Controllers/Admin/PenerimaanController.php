<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PenerimaanRequest;
use App\Models\Penerimaan;
use App\Models\RkaPendapatan;
use App\Models\RekeningPendapatan;
use App\Models\Saldo;
use App\Models\SaldoAwal;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PenerimaanController extends Controller
{
    public function __construct()
    {
        parent::__construct('penerimaan');
    }

    public function index()
    {
        $data['penerimaans'] = Penerimaan::paginate(10);
        return view('admin.penerimaan.index', $data);
    }

    public function create(Request $request)
    {
        $rkaPendapatan = RkaPendapatan::ta($request->cookie('ta'))
                                    ->orderBy(RekeningPendapatan::select('kode_rekening')
                                        ->whereColumn('rekening_pendapatans.id', 'rka_pendapatans.rekening_id')
                                    )->get();
        return view('admin.penerimaan.create', compact('rkaPendapatan'));
    }

    public function store(PenerimaanRequest $request)
    {
        // return $request;
        try{
            $ta = $request->ta;
            $rkaPendapatan = RkaPendapatan::findOrFail($request->rka_pendapatan_id);
            
            DB::beginTransaction();
            // Step 1
            // Buat Penerimaan
            try {
                $penerimaan = Penerimaan::create($request->all());

            } catch (Exception $e) {
                DB::rollback();
                return redirect()->back()
                ->withErrors(['msg' => $e->getMessage()]);
            }

            // Step 2
            // Buat Saldo atau Update Saldo
            try {
                $saldo = Saldo::firstOrNew(
                    [
                        'ta' => $ta
                    ]
                );
                $saldo->saldo_tunai += $penerimaan->nominal;
                $saldo->save();

            } catch (Exception $e) {
                DB::rollback();
                return redirect()->back()
                ->withErrors(['msg' => $e->getMessage()]);
            }

            // Step 3
            // Buat SaldoAwal atau Update SaldoAwal
            try {
                try {
                    $saldoawal = SaldoAwal::where(
                        [
                            'ta' => $ta,
                            'periode' => $penerimaan->tanggal->addMonth()->startOfMonth()
                        ]
                    )->firstOrFail();
                    $saldoawal->saldo_tunai += $penerimaan->nominal;
                    $saldoawal->save();

                } catch (Exception $e) {
                    $saldoawal = new SaldoAwal; 
                    $saldoawal->ta = $ta;
                    $saldoawal->periode = $penerimaan->tanggal->addMonth()->startOfMonth();
                    $saldoawal->saldo_tunai = $saldo->saldo_tunai;
                    $saldoawal->save();
                }

            } catch (Exception $e) {
                DB::rollback();
                return redirect()->back()
                ->withErrors(['msg' => $e->getMessage()]);
            }

            // Step 4
            // Update RKA
            try {
                $bulan = $penerimaan->tanggal->format('n');
                $realisasi_bulan = 'realisasi_'.$bulan;
                $rkaPendapatan->$realisasi_bulan += $penerimaan->nominal;
                $rkaPendapatan->save();

            } catch (\Exception $e) {
                DB::rollback();
                return redirect()->back()
                ->withErrors(['msg' => $e->getMessage()]);
            
            }

            DB::commit();
            // return $rkaPendapatan;

            $notification = array(
                'message' => 'Penerimaan saved successfully!',
                'alert-type' => 'success'
            );

            return redirect()->route('admin.penerimaans.index')->with($notification);

        } catch (Exception $e) {
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'danger'
            );

            return redirect()->route('admin.penerimaans.index')->with($notification);
        }
    }

    public function show(Penerimaan $penerimaan)
    {
        //
    }

    public function edit(Penerimaan $penerimaan)
    {
        $data['penerimaan'] = $penerimaan;
        return view('admin.penerimaan.edit', $data);
    }

    public function update(PenerimaanRequest $request, Penerimaan $penerimaan)
    {
        // return $request;
        try{
            $ta = $request->ta;
            $rkaPendapatan = RkaPendapatan::findOrFail($request->rka_pendapatan_id);
            $nominal_lama = $penerimaan->nominal;
            $nominal_baru = $request->nominal;
            $selisih = $nominal_baru - $nominal_lama;

            DB::beginTransaction();

            // Step 1: Update Penerimaan
            try {
                $penerimaan->nominal += $selisih;
                $penerimaan->keterangan = $request->keterangan;
                $penerimaan->save();

            } catch (Exception $e) {
                DB::rollback();
                return redirect()->back()
                ->withErrors(['msg' => 'Error (PE-1): '.$e->getMessage()]);
            }

            // Step 2: Update Saldo
            try {
                $saldo = Saldo::where(
                    [
                        'ta' => $ta
                    ]
                )->first();
                $saldo->saldo_tunai += $selisih;
                $saldo->save();

            } catch (Exception $e) {
                DB::rollback();
                return redirect()->back()
                ->withErrors(['msg' => 'Error (PE-2): '.$e->getMessage()]);
            }

            // Step 3: Update Saldo Awal
            try { 
                $saldoawal = SaldoAwal::where(
                    [
                        'ta' => $ta,
                        'periode' => $penerimaan->tanggal->addMonth()->startOfMonth()
                    ]
                )->first();
                $saldoawal->saldo_tunai += $selisih;                
                $saldoawal->save();

            } catch (Exception $e) {
                DB::rollback();
                return redirect()->back()
                ->withErrors(['msg' => 'Error (PE-3): '.$e->getMessage()]);
            }

            // Step 4: Update RKA
            try {
                $bulan = $penerimaan->tanggal->format('n');
                $realisasi_bulan = 'realisasi_'.$bulan;
                $rkaPendapatan->$realisasi_bulan += $selisih;
                $rkaPendapatan->save();

            } catch (Exception $e) {
                DB::rollback();
                return redirect()->back()
                ->withErrors(['msg' => 'Error (PE-4): '.$e->getMessage()]);
            }

            DB::commit();
            // $penerimaan = $penerimaan->update($request->all());

            $notification = array(
                'message' => 'Penerimaan saved successfully!',
                'alert-type' => 'success'
            );

            return redirect()->route('admin.penerimaans.index')->with($notification);

        } catch (Exception $e) {
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return redirect()->route('admin.penerimaans.index')->with($notification);
        }
    }

    public function destroy(Request $request, Penerimaan $penerimaan)
    {
        try{
            $ta =$request->cookie('ta');
            $nominal = $penerimaan->nominal;
            $tanggal = $penerimaan->tanggal;
            $periode = $penerimaan->tanggal->addMonth()->startOfMonth();
            $rkaPendapatan = Penerimaan::find($penerimaan->id)->rkaPendapatan;
            // return $periode;
            // Penerimaan::find($penerimaan->id)->delete();
            $saldo = Saldo::where(
                [
                    'ta' => $ta,
                ]
            )->first();
            if ($nominal > $saldo->saldo_tunai) {
                $notification = array(
                    'message' => 'Saldo tidak mencukupi!',
                    'alert-type' => 'danger'
                );
                return redirect()->route('admin.penerimaans.index')->with($notification);
            }

            DB::beginTransaction();

            // Step 1: Hapus Penerimaan
            try {
                Penerimaan::find($penerimaan->id)->delete();

            } catch (Exception $e) {
                DB::rollback();
                return redirect()->back()
                ->withErrors(['msg'=> 'Error! (PD-1) '.$e->getMessage()]);
            }

            // Step 2: Update Saldo
            try {
                $saldo->saldo_tunai -=  $nominal;
                $saldo->save();

            } catch (Exception $e) {
                DB::rollback();
                return redirect()->back()
                ->withErrors(['msg'=> 'Error! (PD-2) '.$e->getMessage()]);
            }

            // Step 3: Update Saldo Awal
            try {
                $saldoawal = SaldoAwal::where(
                    [
                        'ta' => $ta,
                        'periode' => $periode
                    ]
                )->first();
                $saldoawal->saldo_tunai -= $nominal;
                $saldoawal->save();

            } catch (Exception $e) {
                DB::rollback();
                return redirect()->back()
                ->withErrors(['msg'=> 'Error! (PD-3) '.$e->getMessage()]);
            }

            // Step 4: Update RKA
            try {
                $bulan = $tanggal->format('n');
                $realisasi_bulan = 'realisasi_'.$bulan;
                $rkaPendapatan->$realisasi_bulan -= $nominal;
                $rkaPendapatan->save();

            } catch (Exception $e) {
                DB::rollback();
                return redirect()->back()
                ->withErrors(['msg'=> 'Error! (PD-4) '.$e->getMessage()]);
            }

            DB::commit();

            $notification = array(
                'message' => 'Penerimaan deleted successfully!',
                'alert-type' => 'success'
            );

            return redirect()->route('admin.penerimaans.index')->with($notification);
        } catch (Exception $e) {
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return redirect()->route('admin.penerimaans.index')->with($notification);
        }
    }
}
