<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use App\Models\Saldo;
use App\Models\SaldoAwal;

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
}
