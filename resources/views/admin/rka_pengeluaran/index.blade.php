@extends('admin.layouts.backend')
@section('title')
    {{ $title='Daftar Rka Pengeluaran' }}
@endsection

@section('css_before')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inconsolata:wght@600&display=swap" rel="stylesheet">
    <style>
        .mono {
            font-family: 'Inconsolata', monospace !important;
        }
    </style>
@endsection

@section('content')
<div class="">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="block block-themed">
                <div class="block-header">
                    <h3 class="block-title">
                        {{ $title }}
                    </h3>
                </div>

                <div class="block-content">
                    @if (session('message'))
                    <div class="alert alert-success" role="alert">
                        {{ session('message') }}
                    </div>
                    @endif

                    <a class="btn btn-primary btn-sm mb-2" href='{{ route("admin.rka-pengeluarans.create") }}'><i class="fa fa-plus"></i> Tambah</a>

                    <div class="table-responsive">
                        <table class="table table-bordered mono" style="white-space: nowrap;">
                            <thead>
                                <tr>
                                    <th rowspan="2">Actions</th>
                                    <th rowspan="2">
                                        TA
                                    </th>
                                    <th rowspan="2">
                                        Kegiatan
                                    </th>
                                    <th rowspan="2">
                                        Sumber Dana
                                    </th>
                                    <th rowspan="2">
                                        Alokasi
                                    </th>
                                    <th rowspan="2">
                                        Nominal
                                    </th>
                                    <th colspan="12">Realisasi</th>
                                    
                                </tr>
                                <tr>
                                    <th>Januari</th>
                                    <th>Februari</th>
                                    <th>Maret</th>
                                    <th>April</th>
                                    <th>Mei</th>
                                    <th>Juni</th>
                                    <th>Juli</th>
                                    <th>Agustus</th>
                                    <th>September</th>
                                    <th>Oktober</th>
                                    <th>November</th>
                                    <th>Desember</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($rkaPengeluarans as $rkaPengeluaran)
                                <tr>
                                    <td>
                                        <a class="btn btn-sm btn-success me-1 w-100 mb-1" href='{{ route("admin.rka-pengeluarans.edit", $rkaPengeluaran->id) }}'><i class="fa fa-pencil opacity-50 me-1"></i> Edit</a>
                                        <form method="POST" action='{{ route("admin.rka-pengeluarans.destroy", $rkaPengeluaran->id) }}'>
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}

                                            <button type="submit" class="btn btn-sm btn-danger me-1 mb-1 w-100">
                                                <i class="fa fa-times opacity-50 me-1"></i> Delete
                                            </button>
                                        </form>
                                    </td>

                                    <td>
                                        {{ $rkaPengeluaran->ta ?? 'N/A' }}
                                    </td>
                                    <td style="white-space: normal">
                                        {{ $rkaPengeluaran->rekeningKegiatan->kode_kegiatan ?? 'N/A' }} - {{ $rkaPengeluaran->rekeningKegiatan->nama_kegiatan ?? 'N/A' }}
                                    </td>
                                    <td>
                                        <table class="table table-sm">
                                            <tr>
                                                <td>APBD</td>
                                                <td class="text-end">@money($rkaPengeluaran->sumber_dana['apbd'] ?? 0)</td>
                                            </tr>
                                            <tr>
                                                <td>BOS</td>
                                                <td class="text-end">@money($rkaPengeluaran->sumber_dana['bos'] ?? 0)</td>
                                            </tr>
                                            <tr>
                                                <td>SPM</td>
                                                <td class="text-end">@money($rkaPengeluaran->sumber_dana['spm'] ?? 0)</td>
                                            </tr>
                                        </table>
                                        
                                    </td>

                                    <td class="text-end">
                                        <table class="table table-sm">
                                            <tr>
                                                <td>Triwulan 1</td>
                                                <td class="text-end">@money($rkaPengeluaran->alokasi['triwulan_1'] ?? 0)</td>
                                            </tr>
                                            <tr>
                                                <td>Triwulan 2</td>
                                                <td class="text-end">@money($rkaPengeluaran->alokasi['triwulan_2'] ?? 0)</td>
                                            </tr>
                                            <tr>
                                                <td>Triwulan 3</td>
                                                <td class="text-end">@money($rkaPengeluaran->alokasi['triwulan_3'] ?? 0)</td>
                                            </tr>
                                            <tr>
                                                <td>Triwulan 4</td>
                                                <td class="text-end">@money($rkaPengeluaran->alokasi['triwulan_4'] ?? 0)</td>
                                            </tr>
                                            
                                        </table>
                                    </td>
                                    <td class="text-end">
                                        @money($rkaPengeluaran->nominal ?? 0)
                                    </td>
                                    @for ($i = 1; $i <= 12; $i++)
                                        <td class="text-end">
                                            @php $realisasi ='realisasi_'.$i; @endphp
                                            @money($rkaPengeluaran->$realisasi ?? 0)
                                        </td>
                                    @endfor

                                </tr>
                                @empty
                                <tr>
                                    <td colspan="18" align="left">No records found!</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination  -->
                    <div class="d-flex justify-content-center">
                        {{ $rkaPengeluarans->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection