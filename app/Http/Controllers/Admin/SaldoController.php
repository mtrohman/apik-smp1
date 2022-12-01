<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;

class SaldoController extends Controller
{
    public function __construct()
    {
        parent::__construct('saldo');
        $this->middleware("permission:saldo_awal list")->only('saldo_awal');      
    }

    public function index()
    {
        return view('admin.saldo.index');
    }

    public function saldo_awal()
    {
        return view('admin.saldo_awal.index');
    }
}
