<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;

class LaporanController extends Controller
{
    public function __construct()
    {
        $this->middleware("permission:laporan rkas")->only([
            'rkas_bab3',
            'rkas_bab4',
            'rkas_bab5',
            'rkas_bab6',
        ]);

        $this->middleware("permission:laporan realisasi")->only([
            'realisasi_bab3',
            'realisasi_bab4',
            'realisasi_bab5',
            'realisasi_bab6',
        ]);      
    }

    public function rkas_bab3(Request $request)
    {
        # code...
    }

    public function rkas_bab4(Request $request)
    {
        # code...
    }

    public function rkas_bab5(Request $request)
    {
        # code...
    }

    public function rkas_bab6(Request $request)
    {
        # code...
    }

    public function realisasi_bab3(Request $request)
    {
        # code...
    }

    public function realisasi_bab4(Request $request)
    {
        # code...
    }

    public function realisasi_bab5(Request $request)
    {
        # code...
    }

    public function realisasi_bab6(Request $request)
    {
        # code...
    }
}
