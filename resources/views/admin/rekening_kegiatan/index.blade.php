@extends('admin.layouts.backend')
@section('title')
    {{ $title='Daftar Kegiatan' }}
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
                        <a href="/admin/rekening-pengeluarans" class="btn btn-sm btn-alt-primary">
                            <i class="fa fa-fw fa-level-up-alt opacity-50"></i> Rekening Pengeluaran
                        </a>
                    </div>
                </div>

                <div class="block-content">
                    @if (session('message'))
                    <div class="alert alert-success" role="alert">
                        {{ session('message') }}
                    </div>
                    @endif

                    <a class="btn btn-primary btn-sm mb-2" href='{{ route("admin.rekening-kegiatans.create") }}'><i class="fa fa-plus"></i> Tambah</a>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th width="20%">
                                        Rekening
                                    </th>

                                    <th width="10%">
                                        Kode
                                    </th>

                                    <th>
                                        Nama Kegiatan
                                    </th>

                                    <th width="15%">
                                        Keterangan
                                    </th>
                                    {{-- <th>
                                        Created
                                    </th> --}}
                                    <th width="15%">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($rekeningKegiatans as $rekeningKegiatan)
                                <tr>
                                    <td>
                                        {{ $rekeningKegiatan->rekeningPengeluaran->nama_rekening ?? 'N/A' }}
                                    </td>

                                    <td>
                                        {{ $rekeningKegiatan->kode_kegiatan ?? 'N/A' }}
                                    </td>

                                    <td>
                                        {{ $rekeningKegiatan->nama_kegiatan ?? 'N/A' }}
                                    </td>

                                    <td>
                                        {{ $rekeningKegiatan->ket_kegiatan ?? '-' }}
                                    </td>

                                    {{-- <td>
                                        {{ optional($rekeningKegiatan->created_at)->diffForHumans() }}
                                    </td> --}}

                                    <td style="white-space: nowrap">
                                        <a class="btn btn-sm btn-success me-1 w-100 mb-1" href='{{ route("admin.rekening-kegiatans.edit", $rekeningKegiatan->id) }}'><i class="fa fa-pencil opacity-50 me-1"></i> Edit</a>

                                        <form method="POST" action='{{ route("admin.rekening-kegiatans.destroy", $rekeningKegiatan->id) }}'>
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
                                    <td colspan="3" align="center">No records found!</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination  -->
                    <div class="d-flex justify-content-center">
                        {{ $rekeningKegiatans->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection