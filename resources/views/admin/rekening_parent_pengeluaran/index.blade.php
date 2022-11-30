@extends('admin.layouts.backend')
@section('title')
    {{ $title="Daftar Standar Program" }}
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="block">
                <div class="block-header block-header-default">
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

                    <a class="btn btn-primary btn-sm mb-2" href='{{ route("admin.rekening-parent-pengeluarans.create") }}'><i class="fa fa-plus"></i> Tambah</a>

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th width="10%">
                                    Kode
                                </th>
                                <th>
                                    Nama Standar Program
                                </th>
                                <th width="20%">
                                    Created
                                </th>
                                <th width="20%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($rekeningParentPengeluarans as $rekeningParentPengeluaran)
                            <tr>
                                <td>
                                    {{ $rekeningParentPengeluaran->kode_parent ?? 'N/A' }}
                                </td>

                                <td>
                                    {{ $rekeningParentPengeluaran->nama_parent ?? 'N/A' }}
                                </td>

                                <td>
                                    {{ optional($rekeningParentPengeluaran->created_at)->diffForHumans() }}
                                </td>

                                <td>
                                    <a class="btn btn-sm btn-success me-1 w-100 mb-1" href='{{ route("admin.rekening-parent-pengeluarans.edit", $rekeningParentPengeluaran->id) }}'><i class="fa fa-pencil opacity-50 me-1"></i> Edit</a>

                                    <form method="POST" action='{{ route("admin.rekening-parent-pengeluarans.destroy", $rekeningParentPengeluaran->id) }}'>
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
                        {{ $rekeningParentPengeluarans->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection