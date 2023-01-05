@extends('admin.layouts.backend')
@section('title')
    {{ $title='Saldo Berjalan' }}
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
        <div class="col-md-6">
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

                    {{-- <a class="btn btn-primary btn-sm mb-2" href=''><i class="fa fa-plus"></i> Tambah</a> --}}
                    <div class="table-responsive">
                        <table class="table mono table-bordered">
                            <thead>
                                <tr>
                                    <th width="25%">
                                        TA
                                    </th>
                                    
                                    <th class="text-end">
                                        Saldo
                                    </th>
                                    
                                    {{-- <th width="15%">Actions</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($saldos as $saldo)
                                <tr>
                                    <td>
                                        {{ $saldo->ta ?? 'N/A' }}
                                    </td>
                                    <td class="text-end">
                                        @money($saldo->saldo_tunai ?? '0')
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="2" align="center">No records found!</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>

                    </div>

                    <!-- Pagination  -->
                    <div class="d-flex justify-content-center">
                        {{-- {{ $rekeningPendapatans->links() }} --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection