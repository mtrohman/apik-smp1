@extends('admin.layouts.backend')
@section('title')
    {{ $title='Saldo Awal' }}
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
        <div class="col-md-10">
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
                                    <th width="5%">No</th>

                                    <th>Periode</th>
                                    
                                    <th width="20%" class="text-end">
                                        Saldo
                                    </th>
                                    
                                    <th width="20%">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- @forelse($saldo_awals as $sa)
                                <tr>
                                    <td>
                                        {{ $sa->ta ?? 'N/A' }}
                                    </td>
                                    <td class="text-end">
                                        @money($sa->saldo_tunai ?? '0')
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="2" align="center">No records found!</td>
                                </tr>
                                @endforelse --}}

                                @php
                                    $ta= Cookie::get('ta');
                                @endphp
                                @for ($i = 2; $i <= 12; $i++)
                                    @php
                                        $url="";
                                        $text = "";
                                        $period= \Carbon\Carbon::createFromFormat("!Y-n-j", $ta."-".$i."-1");
                                        $ada_saldo_awal= $saldo_awals->contains('periode', $period->format('Y-m-d'));
                                        $saldo_tunai_awal_bln= $saldo_awals->where('periode',$period->format('Y-m-d'))->sum('saldo_tunai'); 
                                    @endphp

                                    <tr>
                                        <td>{{($i-1)}}</td>
                                        <td>{{$period->locale('id_ID')->isoFormat('LL')}}</td>
                                        <td align="right">@money($saldo_tunai_awal_bln)</td>
                                        <td>
                                            @php
                                                if ($ada_saldo_awal) {
                                                    $id_sa= $saldo_awals->firstWhere('periode', $period->format('Y-m-d'))->id;
                                                    $url = route('admin.saldo_awal.hitung', ['id' => $id_sa]);
                                                    $text = "Hitung Ulang";
                                                }
                                                else{
                                                    $url= route('admin.saldo_awal.kalkulasi', ['periode' => $period->format('Y-m-d')]);
                                                    $text = "Kalkulasi";
                                                }
                                            @endphp
                                            <a class="btn btn-sm btn-primary w-100" href="{{$url}}">
                                                {{$text}}
                                            </a>
                                        </td>            
                                    </tr>
                                @endfor

                                    <tr>
                                        @php
                                            $period= \Carbon\Carbon::createFromFormat("!Y-n-j", $ta."-".$i."-1");
                                            $ada_saldo_awal= $saldo_awals->contains('periode', $period->format('Y-m-d'));
                                            $saldo_tunai_awal_bln= $saldo_awals->where('periode',$period->format('Y-m-d'))->sum('saldo_tunai'); 
                                        @endphp
                                        <td>{{($i-1)}}</td>
                                        <td>{{$period->locale('id_ID')->isoFormat('LL')}}</td>
                                        <td align="right">@money($saldo_tunai_awal_bln)</td>
                                        <td>
                                            @php
                                                if ($ada_saldo_awal) {
                                                    $id_sa= $saldo_awals->firstWhere('periode', $period->format('Y-m-d'))->id;
                                                    $url = route('admin.saldo_awal.hitung', ['id' => $id_sa]);
                                                    $text = "Hitung Ulang";
                                                }
                                                else{
                                                    $url= route('admin.saldo_awal.kalkulasi', ['periode' => $period->format('Y-m-d')]);
                                                    $text = "Kalkulasi";
                                                }
                                            @endphp
                                            <a class="btn btn-sm btn-primary w-100" href="{{$url}}">
                                                {{$text}}
                                            </a>
                                        </td>
                                    </tr>

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