@extends('admin.layouts.backend')
@section('title')
    {{ $title='Daftar Belanja' }}
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
                        <a href="/admin/rka-pengeluarans" class="btn btn-sm btn-alt-primary">
                            <i class="fa fa-fw fa-level-up-alt opacity-50"></i> RKA Pengeluaran
                        </a>
                    </div>
                </div>

                <div class="block-content">
                    @if (session('message'))
                    <div class="alert alert-success" role="alert">
                        {{ session('message') }}
                    </div>
                    @endif

                    <a class="btn btn-primary btn-sm mb-2" href='{{ route("admin.belanjas.create") }}'><i class="fa fa-plus"></i> Tambah</a>

                    <div class="table-responsive">
                        <table class="table mono table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>TA</th>
                                    <th>
                                        Tanggal
                                    </th>
                                    <th>
                                        RKA Pengeluaran
                                    </th>
                                    <th>
                                        Sumber Dana
                                    </th>
                                    <th>
                                        Nominal
                                    </th>
                                    <th>
                                        Keterangan
                                    </th>
                                    <th width="12%">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($belanjas as $belanja)
                                <tr>
                                    <td>
                                        {{$loop->iteration}}
                                    </td>
                                    <td style="white-space: nowrap;">
                                        {{ $belanja->ta ?? 'N/A' }}
                                    </td>
                                    <td style="white-space: nowrap;">
                                        {{ $belanja->tanggal->locale('id')->isoFormat('LL') ?? 'N/A' }}
                                    </td>
                                    <td>
                                        {{ $belanja->rkaPengeluaran->rekeningKegiatan->kode_kegiatan ?? 'N/A' }} - {{ $belanja->rkaPengeluaran->rekeningKegiatan->nama_kegiatan ?? 'N/A' }}
                                    </td>
                                    <td>
                                        {{ $belanja->sumber_dana ?? "-"}}
                                    </td>
                                    <td class="text-end" style="white-space: nowrap">
                                        @money($belanja->nominal ?? 0)
                                    </td>

                                    <td>
                                        {{ $belanja->keterangan ?? "-" }}
                                    </td>

                                    <td style="white-space: nowrap">
                                        <a class="btn btn-sm btn-success me-1 w-100 mb-1" href='{{ route("admin.belanjas.edit", $belanja->id) }}'><i class="fa fa-pencil opacity-50 me-1"></i> Edit</a>

                                        <form method="POST" action='{{ route("admin.belanjas.destroy", $belanja->id) }}'>
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}

                                            <button type="submit" class="btn btn-sm btn-danger me-1 mb-1 w-100">
                                                <i class="fa fa-times opacity-50 me-1"></i> Delete
                                            </button>
                                        </form>

                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" align="center">No records found!</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>

                    </div>

                    <!-- Pagination  -->
                    <div class="d-flex justify-content-center">
                        {{ $belanjas->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection