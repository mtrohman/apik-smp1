<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RekeningKegiatan;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\RekeningParentPengeluaran;
use App\Models\RekeningPengeluaran;
use App\Models\RkaPendapatan;
use App\Models\RkaPengeluaran;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Str;
use Carbon\Carbon;

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
        return view('admin.laporan.rkas.bab3');
    }

    public function proses_rkas_bab3(Request $request)
    {
        $ta = $request->cookie('ta');
        $tanggal = Carbon::parse($request->tanggal);
        // return $tanggal->locale('id')->isoFormat('DD MMMM Y');
        $tempat_tanggal = "Demak, ".$tanggal->locale('id')->isoFormat('DD MMMM Y');;
        $spreadsheet = IOFactory::load('storage/format/rkas_bab3.xlsx');
        $worksheet = $spreadsheet->getActiveSheet();
        $worksheet->getCell('ta')->setValue($ta);
        $worksheet->getCell('tempat_tanggal')->setValue($tempat_tanggal);
        
        $rkaPendapatan = RkaPendapatan::with('rekeningPendapatan')->where('ta', $request->cookie('ta'))->get();
        // return $rkaPendapatan;
        foreach ($rkaPendapatan as $key => $item) {
            $nama_rekening = Str::of($item->rekeningPendapatan->nama_rekening)->replaceMatches('/[^A-Za-z0-9 _]/', '')->lower()->snake();
            $$nama_rekening = $item->nominal;
            $worksheet->getCell("$nama_rekening")->setValue($$nama_rekening);
        }

        // return Str::of("Sumbangan Alumni Kls IX")->replaceMatches('/[^A-Za-z0-9 _]/', '')->lower()->snake();
        // return $pendapatan_apbd;
        /* $rkaPengeluaran = RkaPengeluaran::with('rekeningKegiatan.rekeningPengeluaran.parentPengeluaran')->where('ta', $request->cookie('ta'))->get();
        foreach ($rkaPengeluaran as $key => $item) {
            $nama_rekening = Str::of($item->rekeningKegiatan->rekeningPengeluaran->parentPengeluaran->nama_parent)->replaceMatches('/[^A-Za-z0-9 _]/', '')->lower()->snake();
            $$nama_rekening = $$nama_rekening ?? 0;
            $$nama_rekening += $item->nominal;
            // return $nama_rekening;
        } */
        // return $standar_kompetensi_lulusan;

        $parentPengeluaran = RekeningParentPengeluaran::all();
        // return $parentPengeluaran;
        foreach ($parentPengeluaran as $key => $parent) {
            $nama_rekening = Str::of($parent->nama_parent)->replaceMatches('/[^A-Za-z0-9 _]/', '')->lower()->snake();;
            $$nama_rekening = RkaPengeluaran::ta($request->cookie('ta'))->parent($parent->id)->sum('nominal');
            $worksheet->getCell("$nama_rekening")->setValue($$nama_rekening);
        }
        // return $standar_isi;

        // Cetak
        if ($request->has('preview')) {
            if ($request->preview == 'true') {
                $writer = IOFactory::createWriter($spreadsheet, 'Html');
                $documento = $writer->save('php://output');
                return $documento;
            }
        }

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $temp_file = tempnam(sys_get_temp_dir(), 'Excel');
        $writer->save($temp_file);
        $file= 'rkas_'.$request->cookie('ta').'_bab3.xlsx';
        $documento = file_get_contents($temp_file);
        unlink($temp_file);  // delete file tmp
        header("Content-Disposition: attachment; filename= ".$file."");
        header('Content-Type: application/excel');
        return $documento;

    }

    public function rkas_bab4(Request $request)
    {
        return view('admin.laporan.rkas.bab4');
    }

    public function proses_rkas_bab4(Request $request)
    {
        $spreadsheet = IOFactory::load('storage/format/rkas_bab4.xlsx');
        $worksheet = $spreadsheet->getActiveSheet();

        $rkaPendapatan = RkaPendapatan::with('rekeningPendapatan')->where('ta', $request->cookie('ta'))->get();
        // return $rkaPendapatan;
        foreach ($rkaPendapatan as $key => $item) {
            $nama_rekening = Str::of($item->rekeningPendapatan->nama_rekening)->replaceMatches('/[^A-Za-z0-9 _]/', '')->lower()->snake();
            $$nama_rekening = $item->nominal;
            $worksheet->getCell("$nama_rekening")->setValue($$nama_rekening);
        }

        $parentPengeluaran = RekeningParentPengeluaran::all();
        // $rkaPengeluaran = RkaPengeluaran::with('rekeningKegiatan')->get();
        
        // $rekeningKegiatan = RekeningKegiatan::all();
        // return $parentPengeluaran;
        $barisTambahan = 0;
        $parentIndex = [
            24, 26, 28, 30, 32, 34, 36, 38
        ];

        foreach ($parentPengeluaran as $keyP=> $parent) {
            $jumlahBaris = 0;
            $dataArray = array();
            $indexKepala = array();
            $rekeningPengeluaran = RekeningPengeluaran::with('rekeningKegiatan.rkaPengeluaran')->parent($parent->id)->get();
            // return $rekeningPengeluaran;
            
            // return $rekeningPengeluaran[3]->rekeningKegiatan[0]->id ?? "N/A";
            $i= 0;
            foreach ($rekeningPengeluaran as $key_rekening => $item_rekening) {
                $indexKepala[] = $i;
                $koderekening = Str::of($item_rekening->kode_rekening)->explode('.');
                $dataArray[$i][0] = $i + $barisTambahan + 1;
                $dataArray[$i][1] = $koderekening[0];
                $dataArray[$i][2] = $koderekening[1];
                $dataArray[$i][3] = $item_rekening->nama_rekening;

                
                foreach ($item_rekening->rekeningKegiatan as $key_kegiatan => $item_kegiatan) {
                    $i++;
                    $kodekegiatan = Str::of($item_kegiatan->kode_kegiatan)->explode('.');
                    $dataArray[$i][0] = $i + $barisTambahan + 1;
                    $dataArray[$i][1] = NULL;
                    $dataArray[$i][2] = NULL;
                    $dataArray[$i][3] = $kodekegiatan[2];
                    $dataArray[$i][4] = $item_kegiatan->nama_kegiatan;
                    $dataArray[$i][5] = NULL;
                    $dataArray[$i][6] = NULL;
                    // --------------------------------------------
                    if($item_kegiatan->rkaPengeluaran != null){
                        $dataArray[$i][7] = $item_kegiatan->rkaPengeluaran->nominal;
                        $dataArray[$i][8] = $item_kegiatan->rkaPengeluaran->sumber_dana['apbd'];
                        $dataArray[$i][9] = $item_kegiatan->rkaPengeluaran->sumber_dana['bos'];
                        $dataArray[$i][10] = $item_kegiatan->rkaPengeluaran->sumber_dana['spm'];

                    }
                }
                
                $i++;
            }

            $jumlahBaris = count($dataArray);
            
            // return $dataArray;
            // return $indexKepala;
            $rowBefore = $barisTambahan + ($parentIndex[$keyP] );
            $startFrom = $barisTambahan + ($parentIndex[$keyP] -1);
            $barisTambahan += $jumlahBaris;

            if ($jumlahBaris) {
                # code...
                $worksheet->insertNewRowBefore($rowBefore ,$jumlahBaris - 1);
                $worksheet->fromArray(
                    $dataArray,
                    NULL,
                    "A$startFrom"
                );
            }
            
            foreach ($indexKepala as $value) {
                $row = $startFrom + $value;
                $spreadsheet->getActiveSheet()->getStyle("D$row")->getAlignment()->setHorizontal('left');
            }

        }

        // return $startFrom;
        // return $rowBefore;
        
        $maxBaris = 45 + $barisTambahan;
        $conditionalStyles = $spreadsheet->getActiveSheet()->getStyle('B23')->getConditionalStyles();
        $spreadsheet->getActiveSheet()->getStyle("B23:K$maxBaris")->setConditionalStyles($conditionalStyles);


        // Cetak
        if ($request->has('preview')) {
            if ($request->preview == 'true') {
                $writer = IOFactory::createWriter($spreadsheet, 'Html');
                $documento = $writer->save('php://output');
                return $documento;
            }
        }

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $temp_file = tempnam(sys_get_temp_dir(), 'Excel');
        $writer->save($temp_file);
        $file= 'rkas_'.$request->cookie('ta').'_bab4.xlsx';
        $documento = file_get_contents($temp_file);
        unlink($temp_file);  // delete file tmp
        header("Content-Disposition: attachment; filename= ".$file."");
        header('Content-Type: application/excel');
        return $documento;
    }

    public function rkas_bab5(Request $request)
    {
        return view('admin.laporan.rkas.bab5');
    }

    public function proses_rkas_bab5(Request $request)
    {

    }

    public function rkas_bab6(Request $request)
    {
        return view('admin.laporan.rkas.bab6');
    }

    public function proses_rkas_bab6(Request $request)
    {

    }


    // --------------------------------------------Realisasi -----------------------------------------


    public function realisasi_bab3(Request $request)
    {
        return view('admin.laporan.realisasi.bab3');
    }

    public function proses_realisasi_bab3(Request $request)
    {
        $ta = $request->cookie('ta');
        $tanggal = Carbon::parse($request->tanggal);
        $tempat_tanggal = "Demak, ".$tanggal->locale('id')->isoFormat('DD MMMM Y');
        $triwulan = $request->triwulan;
        $spreadsheet = IOFactory::load('storage/format/realisasi_bab3.xlsx');
        $worksheet = $spreadsheet->getActiveSheet();
        $worksheet->getCell('ta')->setValue($ta);
        $worksheet->getCell('tempat_tanggal')->setValue($tempat_tanggal);
        $triwulanArray = [
            [1,2,3],
            [4,5,6],
            [7,8,9],
            [10,11,12]
        ];
        // return end($triwulanArray[($triwulan-1)]);
        
        $rkaPendapatan = RkaPendapatan::with('rekeningPendapatan')->where('ta', $request->cookie('ta'))->get();
        // return $rkaPendapatan;
        foreach ($rkaPendapatan as $key => $item) {
            $nama_rekening = Str::of($item->rekeningPendapatan->nama_rekening)->replaceMatches('/[^A-Za-z0-9 _]/', '')->lower()->snake();
            $$nama_rekening = 0;
            for ($i=1; $i <= end($triwulanArray[($triwulan-1)]); $i++) { 
                $realisasi_bulan = 'realisasi_'.$i;
                $$nama_rekening += $item->$realisasi_bulan;
            }
            $worksheet->getCell("$nama_rekening")->setValue($$nama_rekening);
        }
        // return $saldo_bos;

        $parentPengeluaran = RekeningParentPengeluaran::all();
        // return $parentPengeluaran;
        foreach ($parentPengeluaran as $key => $parent) {
            $nama_rekening = Str::of($parent->nama_parent)->replaceMatches('/[^A-Za-z0-9 _]/', '')->lower()->snake();;
            $$nama_rekening = 0;
            for ($i=1; $i <= end($triwulanArray[($triwulan-1)]); $i++) { 
                $realisasi_bulan = 'realisasi_'.$i;
                // $$nama_rekening += $item->$realisasi_bulan;
                $$nama_rekening += RkaPengeluaran::ta($request->cookie('ta'))->parent($parent->id)->sum($realisasi_bulan);
            }
            $worksheet->getCell("$nama_rekening")->setValue($$nama_rekening);
        }
        // return $standar_isi;

        // Cetak
        if ($request->has('preview')) {
            if ($request->preview == 'true') {
                $writer = IOFactory::createWriter($spreadsheet, 'Html');
                $documento = $writer->save('php://output');
                return $documento;
            }
        }

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $temp_file = tempnam(sys_get_temp_dir(), 'Excel');
        $writer->save($temp_file);
        $file= 'realisasi_'.$request->cookie('ta').'_bab3.xlsx';
        $documento = file_get_contents($temp_file);
        unlink($temp_file);  // delete file tmp
        header("Content-Disposition: attachment; filename= ".$file."");
        header('Content-Type: application/excel');
        return $documento;
    }

    public function realisasi_bab4(Request $request)
    {
        return view('admin.laporan.realisasi.bab4');
    }

    public function proses_realisasi_bab4(Request $request)
    {

    }

    public function realisasi_bab5(Request $request)
    {
        return view('admin.laporan.realisasi.bab5');
    }

    public function proses_realisasi_bab5(Request $request)
    {

    }

    public function realisasi_bab6(Request $request)
    {
        return view('admin.laporan.realisasi.bab6');
    }

    public function proses_realisasi_bab6(Request $request)
    {

    }
}
