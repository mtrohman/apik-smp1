@extends('admin.layouts.backend')
@section('title')
    {{ $title='Laporan Realisasi BAB 3' }}
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
        <div class="col-lg-6">
            <div class="block block-themed">
                <div class="block-header">
                    <h3 class="block-title">
                        {{ $title }}
                    </h3>
                    
                    @if (Request::has('sampaitanggal'))
                        <div class="block-options">
                            <a href="/admin/laporan/realisasi-bab3" class="btn btn-sm btn-alt-primary">
                                <i class="fa fa-fw fa-arrow-right opacity-50"></i>
                                <span class="d-none d-sm-inline-block">triwulan</span>
                            </a>
                        </div>
                    @else
                        <div class="block-options">
                            <a href="/admin/laporan/realisasi-bab3?sampaitanggal" class="btn btn-sm btn-alt-primary">
                                <i class="fa fa-fw fa-arrow-right opacity-50"></i>
                                <span class="d-none d-sm-inline-block">sampai dengan</span>
                            </a>
                        </div>
                    @endif
                </div>

                <div class="block-content">
                    @if (session('message'))
                    <div class="alert alert-success" role="alert">
                        {{ session('message') }}
                    </div>
                    @endif

                    <form id="laporan" method="POST" action='{{ (Request::missing('sampaitanggal')) ? route("admin.proses.realisasi_bab3") : route("admin.proses.realisasi_bab3", ['sampaitanggal']) }}' enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="mb-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control mono @error('ta') is-invalid @enderror" id="ta" name="ta" placeholder="Masukkan TA" value="{{Cookie::get('ta')}}" readonly>
                                    <label class="form-label" for="ta">TA</label>
                                    @error('ta')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>
                        </div>
                        @if (Request::missing('sampaitanggal'))
                            <div class="row">
                                <div class="mb-4">
                                    <div class="form-floating">
                                        <select class="form-select mono @error('triwulan') is-invalid @enderror" id="triwulan" name="triwulan" required>
                                            <option value>Pilih Triwulan</option>
                                            @for ($i = 1; $i <= 4; $i++)
                                                <option value="{{$i}}">Triwulan {{$i}}</option>
                                            @endfor
                                        </select>
                                        <label class="form-label" for="triwulan">Triwulan</label>
                                        @error('triwulan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>
                            </div>

                            <div class="row">
                                <div class="mb-4">
                                    <div class="form-floating">
                                        <input type="date" class="form-control mono @error('tanggal') is-invalid @enderror" id="tanggal" name="tanggal" placeholder="Masukkan Tanggal" required>
                                        <label class="form-label" for="tanggal">Tanggal</label>
                                        @error('tanggal')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>
                            </div>
                        @else
                            <div class="row">
                                <div class="mb-4">
                                    <div class="form-floating">
                                        <input type="date" class="form-control mono @error('until') is-invalid @enderror" id="until" name="until" placeholder="Masukkan Tanggal" required>
                                        <label class="form-label" for="until">Sampai Dengan</label>
                                        @error('until')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>
                            </div>

                            <div class="row">
                                <div class="mb-4">
                                    <div class="form-floating">
                                        <input type="date" class="form-control mono @error('tanggal') is-invalid @enderror" id="tanggal" name="tanggal" placeholder="Masukkan Tanggal" required>
                                        <label class="form-label" for="tanggal">Tanggal Surat</label>
                                        @error('tanggal')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>
                            </div>
                        @endif

                    </form>
                </div>

                <div class="block-content block-content-full block-content-sm bg-body-light text-end">
                    <button form="laporan" type="submit" formtarget="_blank" formaction="{{ route('admin.proses.realisasi_bab3', ['preview'=> 'true']) }}" class="btn btn-raised btn-sm btn-alt-primary mb-0">
                        <i class="fa fa-file"></i> Preview
                    </button>
                    <button form="laporan" type="submit" class="btn btn-raised btn-sm btn-primary mb-0">
                        <i class="fa fa-check-square-o"></i> Proses
                    </button>
                </div>
                    
            </div>
        </div>
    </div>
</div>
@endsection