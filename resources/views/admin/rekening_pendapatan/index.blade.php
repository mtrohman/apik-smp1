@extends('admin.layouts.backend')
@section('title')
    {{ $title='Daftar Rekening Pendapatan' }}
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
                        <a href="/admin/rekening-parent-pendapatans" class="btn btn-sm btn-alt-primary">
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

                    <a class="btn btn-primary btn-sm mb-2" href='{{ route("admin.rekening-pendapatans.create") }}'><i class="fa fa-plus"></i> Tambah</a>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th width="10%">
                                        Parent
                                    </th>
                                    <th width="10%">
                                        Kode
                                    </th>
                                    <th>
                                        Nama Rekening
                                    </th>
                                    
                                    <th width="15%">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($rekeningPendapatans as $rekeningPendapatan)
                                <tr>
                                    <td>
                                        {{ $rekeningPendapatan->parentPendapatan->nama_parent ?? 'N/A' }}
                                    </td>
                                    <td>
                                        {{ $rekeningPendapatan->kode_rekening ?? 'N/A' }}
                                    </td>
                                    <td>
                                        {{ $rekeningPendapatan->nama_rekening ?? 'N/A' }}
                                    </td>

                                    <td style="white-space: nowrap">
                                        <a class="btn btn-sm btn-success me-1 w-100 mb-1" href='{{ route("admin.rekening-pendapatans.edit", $rekeningPendapatan->id) }}'><i class="fa fa-pencil opacity-50 me-1"></i> Edit</a>

                                        <form method="POST" action='{{ route("admin.rekening-pendapatans.destroy", $rekeningPendapatan->id) }}'>
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
                                    <td colspan="5" align="center">No records found!</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>

                    </div>

                    <!-- Pagination  -->
                    <div class="d-flex justify-content-center">
                        {{ $rekeningPendapatans->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection