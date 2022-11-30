@extends('admin.layouts.backend')
@section('title', 'Parent Rekening Pendapatan')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="block">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Daftar Parent</h3>
                </div>

                <div class="block-content">
                    @if (session('message'))
                    <div class="alert alert-success" role="alert">
                        {{ session('message') }}
                    </div>
                    @endif

                    <a class="btn btn-primary btn-sm mb-2" href='{{ route("admin.rekening-parent-pendapatans.create") }}'><i class="fa fa-plus"></i> Tambah</a>

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>
                                    Kode
                                </th>
                                <th>
                                    Nama Parent
                                </th>
                                
                                <th width="20%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($rekeningParentPendapatans as $rekeningParentPendapatan)
                            <tr>
                                <td>
                                    {{ $rekeningParentPendapatan->kode_parent ?? 'N/A' }}
                                </td>

                                <td>
                                    {{ $rekeningParentPendapatan->nama_parent ?? 'N/A' }}
                                </td>

                                <td>
                                    <a class="btn btn-sm btn-success w-100 mb-2" href='{{ route("admin.rekening-parent-pendapatans.edit", $rekeningParentPendapatan->id) }}'><i class="fa fa-pencil opacity-50 me-1"></i> Edit</a>

                                    <form method="POST" action='{{ route("admin.rekening-parent-pendapatans.destroy", $rekeningParentPendapatan->id) }}'>
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
                        {{ $rekeningParentPendapatans->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection