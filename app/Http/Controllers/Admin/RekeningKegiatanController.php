<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RekeningKegiatanRequest;
use Illuminate\Http\Request;
use App\Models\RekeningKegiatan;
use App\Models\RekeningPengeluaran;
use App\Http\Resources\RekeningKegiatanResource;
use Exception;

class RekeningKegiatanController extends Controller
{
    public function __construct()
    {
        parent::__construct('rekening_kegiatan');
    }

    public function index(Request $request)
    {
        $data['rekeningKegiatans'] = RekeningKegiatan::ta($request->cookie('ta'))->orderBy('rekening_id')->orderBy('kode_kegiatan')->paginate(10);
        return view('admin.rekening_kegiatan.index', $data);
    }

    public function create()
    {
        $parent = RekeningPengeluaran::all();
        return view('admin.rekening_kegiatan.create', compact('parent'));
    }

    public function store(RekeningKegiatanRequest $request)
    {
        try{
            $rekeningKegiatan = RekeningKegiatan::create($request->all());

            $notification = array(
                'message' => 'Rekening Kegiatan saved successfully!',
                'alert-type' => 'success'
            );

            return redirect()->route('admin.rekening-kegiatans.index')->with($notification);

        } catch (Exception $e) {
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );

            return redirect()->route('admin.rekening-kegiatans.index')->with($notification);
        }
    }

    public function show(RekeningKegiatan $rekeningKegiatan)
    {
        //
    }

    public function edit(RekeningKegiatan $rekeningKegiatan)
    {
        $parent = RekeningPengeluaran::all();
        return view('admin.rekening_kegiatan.edit', compact('rekeningKegiatan', 'parent'));
    }

    public function update(RekeningKegiatanRequest $request, RekeningKegiatan $rekeningKegiatan)
    {
        try {
            $rekeningKegiatan = $rekeningKegiatan->update($request->all());

            $notification = array(
                'message' => 'Rekening Kegiatan saved successfully!',
                'alert-type' => 'success'
            );

            return redirect()->route('admin.rekening-kegiatans.index')->with($notification);
        } catch (Exception $e) {
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return redirect()->route('admin.rekening-kegiatans.index')->with($notification);
        }
    }

    public function destroy(RekeningKegiatan $rekeningKegiatan)
    {
        try{
            RekeningKegiatan::find($rekeningKegiatan->id)->delete();

            $notification = array(
                'message' => 'Rekening Kegiatan deleted successfully!',
                'alert-type' => 'success'
            );

            return redirect()->route('admin.rekening-kegiatans.index')->with($notification);
        } catch (Exception $e) {
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return redirect()->route('admin.rekening-kegiatans.index')->with($notification);
        }
    }

    public function search($rekeningId)
    {
        $rekeningKegiatans = RekeningKegiatan::where('rekening_id', $rekeningId)->get();
        return RekeningKegiatanResource::collection($rekeningKegiatans);
    }
}
