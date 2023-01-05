@extends('admin.layouts.backend')
@section('title')
    {{ $title='Daftar Rka Pendapatan' }}
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
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="block block-themed">
                <div class="block-header">
                    <h3 class="block-title">
                        {{ $title }}
                    </h3>

                    <div class="block-options">
                        <a href="/admin/rekening-pendapatans" class="btn btn-sm btn-alt-primary">
                        <i class="fa fa-fw fa-level-up-alt opacity-50"></i> Rekening Pendapatan
                        </a>
                    </div>
                </div>

                <div class="block-content">
                    @if (session('message'))
                    <div class="alert alert-success" role="alert">
                        {{ session('message') }}
                    </div>
                    @endif

                    <a class="btn btn-primary btn-sm mb-2" href='{{ route("admin.rka-pendapatans.create") }}'><i class="fa fa-plus"></i> Tambah</a>
                    <div class="table-responsive">
                        <table class="table table-bordered mono" style="white-space: nowrap;">
                            <thead>
                                <tr>
                                    <th rowspan="2">Actions</th>
                                    <th rowspan="2">
                                        TA
                                    </th>
                                    <th rowspan="2">
                                        Rekening
                                    </th>
                                    <th rowspan="2">
                                        Nominal
                                    </th>
                                    <th colspan="12">Realisasi</th>
                                    
                                </tr>
                                <tr>
                                    <th>Juli</th>
                                    <th>Agustus</th>
                                    <th>September</th>
                                    <th>Oktober</th>
                                    <th>November</th>
                                    <th>Desember</th>
                                    <th>Januari</th>
                                    <th>Februari</th>
                                    <th>Maret</th>
                                    <th>April</th>
                                    <th>Mei</th>
                                    <th>Juni</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($rkaPendapatans as $rkaPendapatan)
                                <tr>
                                    <td>
                                        <a class="btn btn-sm btn-success me-1 w-100 mb-1" href='{{ route("admin.rka-pendapatans.edit", $rkaPendapatan->id) }}'><i class="fa fa-pencil opacity-50 me-1"></i> Edit</a>

                                        <form method="POST" action='{{ route("admin.rka-pendapatans.destroy", $rkaPendapatan->id) }}'>
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}

                                            <button type="submit" class="btn btn-sm btn-danger me-1 mb-1 w-100">
                                                <i class="fa fa-times opacity-50 me-1"></i> Delete
                                            </button>
                                        </form>

                                    </td>
                                    <td>
                                        {{ $rkaPendapatan->ta ?? 'N/A' }}
                                    </td>
                                    <td>
                                        {{ $rkaPendapatan->rekeningPendapatan->kode_rekening ?? 'N/A' }} - {{ $rkaPendapatan->rekeningPendapatan->nama_rekening ?? 'N/A' }}
                                    </td>
                                    <td class="text-end">
                                        @money($rkaPendapatan->nominal ?? 0)
                                    </td>
                                    @for ($i = 1; $i <= 12; $i++)
                                        <td class="text-end">
                                            @php $realisasi ='realisasi_'.$i; @endphp
                                            @money($rkaPendapatan->$realisasi ?? 0)
                                        </td>
                                    @endfor

                                    

                                </tr>
                                @empty
                                <tr>
                                    <td colspan="16" align="center">No records found!</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination  -->
                    <div class="d-flex justify-content-center">
                        {{ $rkaPendapatans->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection