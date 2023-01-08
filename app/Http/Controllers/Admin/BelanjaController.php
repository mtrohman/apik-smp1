<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BelanjaRequest;
use App\Models\Belanja;
use App\Models\RekeningPengeluaran;
use App\Models\RkaPengeluaran;
use App\Models\Saldo;
use App\Models\SaldoAwal;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class BelanjaController extends Controller
{
    public function __construct()
    {
        parent::__construct('belanja');
    }

    public function index(Request $request)
    {
        $data['belanjas'] = Belanja::ta($request->cookie('ta'))->paginate(10);
        return view('admin.belanja.index', $data);
    }

    public function create()
    {
        $parent = RekeningPengeluaran::orderBy('kode_rekening')->get();
        return view('admin.belanja.create', compact('parent'));
    }

    public function store(BelanjaRequest $request)
    {
        /*$json = '{"apbd":{}}';
        $json = json_decode($json, true);
        $json['apbd']['realisasi_1'] = $json['apbd']['realisasi_1'] ?? 0;
        return $request;*/

        try{
            $ta = $request->ta;
            $sumber_dana = strtolower($request->sumber_dana);
            $rkaPengeluaran = RkaPengeluaran::findOrFail($request->rka_pengeluaran_id);
            // return $rkaPengeluaran;
            
            DB::beginTransaction();
            // Step 1
            // Buat Belanja
            try {
                $belanja = Belanja::create($request->all());

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
                $saldo->saldo_tunai -= $belanja->nominal;
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
                            'periode' => $belanja->tanggal->addMonth()->startOfMonth()
                        ]
                    )->firstOrFail();
                    $saldoawal->saldo_tunai -= $belanja->nominal;
                    $saldoawal->save();

                } catch (Exception $e) {
                    $saldoawal = new SaldoAwal; 
                    $saldoawal->ta = $ta;
                    $saldoawal->periode = $belanja->tanggal->addMonth()->startOfMonth();
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
                $bulan = $belanja->tanggal->format('n');
                $bulan = ($bulan > 6) ? $bulan -= 6 : $bulan += 6;
                $realisasi_bulan = 'realisasi_'.$bulan;
                $realisasi_sumber_dana = $rkaPengeluaran->realisasi_sumber_dana;
                $realisasi_sumber_dana[$sumber_dana][$realisasi_bulan] = $realisasi_sumber_dana[$sumber_dana][$realisasi_bulan] ?? 0;
                $realisasi_sumber_dana[$sumber_dana][$realisasi_bulan] += $belanja->nominal;

                $rkaPengeluaran->$realisasi_bulan += $belanja->nominal;
                $rkaPengeluaran->realisasi_sumber_dana = $realisasi_sumber_dana;
                $rkaPengeluaran->save();

            } catch (\Exception $e) {
                DB::rollback();
                return redirect()->back()
                ->withErrors(['msg' => $e->getMessage()]);
            
            }

            DB::commit();

            // $belanja = Belanja::create($request->all());

            $notification = array(
                'message' => 'Belanja saved successfully!',
                'alert-type' => 'success'
            );

            return redirect()->route('admin.belanjas.index')->with($notification);

        } catch (Exception $e) {
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'danger'
            );

            return redirect()->route('admin.belanjas.index')->with($notification);
        }
    }

    public function show(Belanja $belanja)
    {
        //
    }

    public function edit(Belanja $belanja)
    {
        $data['belanja'] = $belanja;
        return view('admin.belanja.edit', $data);
    }

    public function update(BelanjaRequest $request, Belanja $belanja)
    {
        try {
            $ta = $request->ta;
            $sumber_dana = strtolower($belanja->sumber_dana);
            $rkaPengeluaran = RkaPengeluaran::findOrFail($request->rka_pengeluaran_id);
            $nominal_lama = $belanja->nominal;
            $nominal_baru = $request->nominal;
            $selisih = $nominal_baru - $nominal_lama;

            DB::beginTransaction();

            // Step 1: Update belanja
            try {
                $belanja->nominal += $selisih;
                $belanja->keterangan = $request->keterangan;
                $belanja->save();

            } catch (Exception $e) {
                DB::rollback();
                return redirect()->back()
                ->withErrors(['msg' => 'Error (BE-1): '.$e->getMessage()]);
            }

            // Step 2: Update Saldo
            try {
                $saldo = Saldo::where(
                    [
                        'ta' => $ta
                    ]
                )->first();
                $saldo->saldo_tunai -= $selisih;
                $saldo->save();

            } catch (Exception $e) {
                DB::rollback();
                return redirect()->back()
                ->withErrors(['msg' => 'Error (BE-2): '.$e->getMessage()]);
            }

            // Step 3: Update Saldo Awal
            try { 
                $saldoawal = SaldoAwal::where(
                    [
                        'ta' => $ta,
                        'periode' => $belanja->tanggal->addMonth()->startOfMonth()
                    ]
                )->first();
                $saldoawal->saldo_tunai -= $selisih;                
                $saldoawal->save();

            } catch (Exception $e) {
                DB::rollback();
                return redirect()->back()
                ->withErrors(['msg' => 'Error (BE-3): '.$e->getMessage()]);
            }

            // Step 4: Update RKA
            try {
                $bulan = $belanja->tanggal->format('n');
                $bulan = ($bulan > 6) ? $bulan -= 6 : $bulan += 6;
                $realisasi_bulan = 'realisasi_'.$bulan;
                $realisasi_sumber_dana = $rkaPengeluaran->realisasi_sumber_dana;
                $realisasi_sumber_dana[$sumber_dana][$realisasi_bulan] = $realisasi_sumber_dana[$sumber_dana][$realisasi_bulan] ?? 0;
                $realisasi_sumber_dana[$sumber_dana][$realisasi_bulan] += $selisih;

                $rkaPengeluaran->$realisasi_bulan += $selisih;
                $rkaPengeluaran->realisasi_sumber_dana = $realisasi_sumber_dana;
                $rkaPengeluaran->save();

            } catch (Exception $e) {
                DB::rollback();
                return redirect()->back()
                ->withErrors(['msg' => 'Error (BE-4): '.$e->getMessage()]);
            }

            DB::commit();

            // $belanja = $belanja->update($request->all());

            $notification = array(
                'message' => 'Belanja saved successfully!',
                'alert-type' => 'success'
            );

            return redirect()->route('admin.belanjas.index')->with($notification);

        } catch (Exception $e) {
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return redirect()->route('admin.belanjas.index')->with($notification);
        }
    }

    public function destroy(Request $request, Belanja $belanja)
    {
        try{
            $ta =$request->cookie('ta');
            $sumber_dana = strtolower($belanja->sumber_dana);
            $nominal = $belanja->nominal;
            $tanggal = $belanja->tanggal;
            $periode = $belanja->tanggal->addMonth()->startOfMonth();
            $rkaPengeluaran = Belanja::find($belanja->id)->rkaPengeluaran;

            DB::beginTransaction();

            // Step 1: Hapus Belanja
            try {
                Belanja::find($belanja->id)->delete();

            } catch (Exception $e) {
                DB::rollback();
                return redirect()->back()
                ->withErrors(['msg'=> 'Error! (BD-1) '.$e->getMessage()]);
            }

            // Step 2: Update Saldo
            try {
                $saldo = Saldo::where(
                    [
                        'ta' => $ta,
                    ]
                )->first();
                $saldo->saldo_tunai +=  $nominal;
                $saldo->save();

            } catch (Exception $e) {
                DB::rollback();
                return redirect()->back()
                ->withErrors(['msg'=> 'Error! (BD-2) '.$e->getMessage()]);
            }

            // Step 3: Update Saldo Awal
            try {
                $saldoawal = SaldoAwal::where(
                    [
                        'ta' => $ta,
                        'periode' => $periode
                    ]
                )->first();
                $saldoawal->saldo_tunai += $nominal;
                $saldoawal->save();

            } catch (Exception $e) {
                DB::rollback();
                return redirect()->back()
                ->withErrors(['msg'=> 'Error! (BD-3) '.$e->getMessage()]);
            }

            // Step 4: Update RKA
            try {
                $bulan = $tanggal->format('n');
                $bulan = ($bulan > 6) ? $bulan -= 6 : $bulan += 6;
                $realisasi_bulan = 'realisasi_'.$bulan;
                $realisasi_sumber_dana = $rkaPengeluaran->realisasi_sumber_dana;
                $realisasi_sumber_dana[$sumber_dana][$realisasi_bulan] = $realisasi_sumber_dana[$sumber_dana][$realisasi_bulan] ?? 0;
                $realisasi_sumber_dana[$sumber_dana][$realisasi_bulan] -= $nominal;

                $rkaPengeluaran->$realisasi_bulan -= $nominal;
                $rkaPengeluaran->realisasi_sumber_dana = $realisasi_sumber_dana;
                $rkaPengeluaran->save();

            } catch (Exception $e) {
                DB::rollback();
                return redirect()->back()
                ->withErrors(['msg'=> 'Error! (BD-4) '.$e->getMessage()]);
            }

            DB::commit();

            $notification = array(
                'message' => 'Belanja deleted successfully!',
                'alert-type' => 'success'
            );

            return redirect()->route('admin.belanjas.index')->with($notification);

        } catch (Exception $e) {
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'danger'
            );
            return redirect()->route('admin.belanjas.index')->with($notification);
        }
    }
}
