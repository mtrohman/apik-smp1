@extends('admin.layouts.backend')
@section('title')
    {{ $title='Daftar Penerimaan' }}
@endsection

@section('css_before')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inconsolata:wght@600&display=swap" rel="stylesheet">
    <style>
        .rupiah {
            text-align: right;
        }

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
                        <a href="/admin/rka-pendapatans" class="btn btn-sm btn-alt-primary">
                            <i class="fa fa-fw fa-level-up-alt opacity-50"></i> RKA Pendapatan
                        </a>
                    </div>
                </div>

                <div class="block-content">
                    @if (session('message'))
                    <div class="alert alert-{{ session('alert-type') }}" role="alert">
                        {{ session('message') }}
                    </div>
                    @endif

                    <a class="btn btn-primary btn-sm mb-2" href='{{ route("admin.penerimaans.create") }}'><i class="fa fa-plus"></i> Tambah</a>

                    <div class="table-responsive">
                        <table class="table mono table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th width="20%">
                                        Tanggal
                                    </th>
                                    <th>
                                        RKA Pendapatan
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
                                @forelse($penerimaans as $penerimaan)
                                <tr>
                                    <td>
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>
                                        {{ $penerimaan->tanggal->locale('id')->isoFormat('LL') ?? 'N/A' }}
                                    </td>

                                    <td>
                                        {{$penerimaan->rkaPendapatan->rekeningPendapatan->kode_rekening ?? 'N/A'}} - {{ $penerimaan->rkaPendapatan->rekeningPendapatan->nama_rekening ?? 'N/A'}}
                                    </td>

                                    <td style="white-space: nowrap" class="text-end">
                                        @money($penerimaan->nominal ?? 0)
                                    </td>

                                    <td>
                                        {{ $penerimaan->keterangan ?? '-'}}
                                    </td>

                                    <td style="white-space: nowrap">
                                        <a class="btn btn-sm btn-success me-1 w-100 mb-1" href='{{ route("admin.penerimaans.edit", $penerimaan->id) }}'><i class="fa fa-pencil opacity-50 me-1"></i> Edit</a>

                                        <form method="POST" action='{{ route("admin.penerimaans.destroy", $penerimaan->id) }}'>
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
                                    <td colspan="6" align="center">No records found!</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>

                    </div>

                    <!-- Pagination  -->
                    <div class="d-flex justify-content-center">
                        {{ $penerimaans->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection