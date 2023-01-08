<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use App\Models\Saldo;
use App\Models\SaldoAwal;
use App\Models\Penerimaan;
use App\Models\Belanja;
use Carbon\Carbon;

class SaldoController extends Controller
{
    public function __construct()
    {
        $this->middleware("permission:saldo saldo_berjalan")->only('index');
        $this->middleware("permission:saldo saldo_awal")->only('saldo_awal');      
    }

    public function index(Request $request)
    {
        $saldos = Saldo::where('ta', $request->cookie('ta'))->get();
        return view('admin.saldo.index', compact('saldos'));
    }

    public function saldo_awal(Request $request)
    {
        $saldo_awals = SaldoAwal::where('ta', $request->cookie('ta'))->get();
        return view('admin.saldo.saldo_awal', compact('saldo_awals'));
    }

    public function sa_hitung(Request $request)
    {
        // Hitung Ulang...
        $ta= $request->cookie('ta');
        $id = $request->id;
        $sa = SaldoAwal::findOrFail($id);
        $periode = $sa->periode;
        $bulan = Carbon::createFromFormat('Y-m-d', $periode)->format('n');
        $tahun = Carbon::createFromFormat('Y-m-d', $periode)->format('Y');
        $fromDate = Carbon::createFromDate($tahun, $bulan-1, 1)->format('Y-m-d');
        $tillDate = Carbon::createFromDate($tahun, $bulan-1, 1)->endOfMonth()->format('Y-m-d');
        // return $fromDate;
        $saldo_awal = SaldoAwal::where('periode', $fromDate)->get();
        $saldoawal_tunai = $saldo_awal->sum('saldo_tunai');
        $pendapatan_sebulan = Penerimaan::whereBetween('tanggal',[$fromDate, $tillDate])->sum('nominal');
        $belanja_sebulan = Belanja::whereBetween('tanggal',[$fromDate, $tillDate])->sum('nominal');
        $saldoakhir_tunai= ($saldoawal_tunai + $pendapatan_sebulan) - $belanja_sebulan;

        // return $saldoakhir_tunai;
        try {
            $sa->saldo_tunai = $saldoakhir_tunai;

            $sa->save();
            return redirect()->route('admin.saldo_awal')->with(['success' => 'Berhasil Update Saldo Awal']);

        } catch (Exception $e) {
            return redirect()->route('admin.saldo_awal')->withErrors('Error :'. $e->getMessage());
        }
    }

    public function sa_kalkulasi(Request $request)
    {
        // Kalkulasi...
        
        $ta= $request->cookie('ta');
        $periode = $request->periode;
        $bulan = Carbon::createFromFormat('Y-m-d', $periode)->format('n');
        $tahun = Carbon::createFromFormat('Y-m-d', $periode)->format('Y');
        $fromDate = Carbon::createFromDate($tahun, $bulan-1, 1)->format('Y-m-d');
        $tillDate = Carbon::createFromDate($tahun, $bulan-1, 1)->endOfMonth()->format('Y-m-d');
        // return $tillDate;

        $saldo_awal = SaldoAwal::where('periode', $fromDate)->get();
        $saldoawal_tunai = $saldo_awal->sum('saldo_tunai');
        $pendapatan_sebulan = Penerimaan::whereBetween('tanggal',[$fromDate, $tillDate])->sum('nominal');
        $belanja_sebulan = Belanja::whereBetween('tanggal',[$fromDate, $tillDate])->sum('nominal');
        $saldoakhir_tunai= ($saldoawal_tunai + $pendapatan_sebulan) - $belanja_sebulan;
        
        // return $saldoakhir_tunai;
        try {
            $sa = new SaldoAwal();
            $sa->ta = $ta;
            $sa->periode = $periode;
            $sa->saldo_tunai = $saldoakhir_tunai;

            $sa->save();
            return redirect()->route('admin.saldo_awal')->with(['success' => 'Berhasil Update Saldo Awal']);

        } catch (Exception $e) {
            return redirect()->route('admin.saldo_awal')->withErrors('Error :'. $e->getMessage());
        }
    }
    
}
