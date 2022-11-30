@extends('admin.layouts.backend')
@section('title')
    {{ $title='Daftar Rekening Pengeluaran' }}
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
                        <a href="/admin/rekening-parent-pengeluarans" class="btn btn-sm btn-alt-primary">
                            <i class="fa fa-fw fa-level-up-alt opacity-50"></i> Parent Rekening
                        </a>
                    </div>
                </div>

                <div class="block-content">
                    @if (session('message'))
                    <div class="alert alert-success" role="alert">
                        {{ session('message') }}
                    </div>
                    @endif

                    <a class="btn btn-primary btn-sm mb-2" href='{{ route("admin.rekening-pengeluarans.create") }}'><i class="fa fa-plus"></i> Tambah</a>

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>
                                    Parent
                                </th>
                                <th>
                                    Kode
                                </th>
                                <th>
                                    Nama Rekening
                                </th>
                                
                                <th width="15%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($rekeningPengeluarans as $rekeningPengeluaran)
                            <tr>
                                <td>
                                    {{ $rekeningPengeluaran->parentPengeluaran->nama_parent ?? 'N/A' }}
                                </td>

                                <td>
                                    {{ $rekeningPengeluaran->kode_rekening ?? 'N/A' }}
                                </td>

                                <td>
                                    {{ $rekeningPengeluaran->nama_rekening ?? 'N/A' }}
                                </td>

                                <td>
                                    <a class="btn btn-sm btn-success me-1 w-100 mb-1" href='{{ route("admin.rekening-pengeluarans.edit", $rekeningPengeluaran->id) }}'><i class="fa fa-pencil opacity-50 me-1"></i> Edit</a>

                                    <form method="POST" action='{{ route("admin.rekening-pengeluarans.destroy", $rekeningPengeluaran->id) }}'>
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

                    <!-- Pagination  -->
                    <div class="d-flex justify-content-center">
                        {{ $rekeningPengeluarans->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection