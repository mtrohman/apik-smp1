@extends('admin.layouts.backend')
@section('title')
    {{ $title='Laporan RKAS BAB 4' }}
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

                    <form id="laporan" method="POST" action='{{ route("admin.proses.rkas_bab4") }}' enctype="multipart/form-data">
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

                        <div class="row">
                            <div class="mb-4">
                                <div class="form-floating">
                                    <input type="date" class="form-control mono @error('tanggal') is-invalid @enderror" id="tanggal" name="tanggal" placeholder="Masukkan Tanggal" required>
                                    <label class="form-label" for="ta">Tanggal</label>
                                    @error('tanggal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>
                        </div>

                        

                    </form>
                </div>

                <div class="block-content block-content-full block-content-sm bg-body-light text-end">
                    <button form="laporan" type="submit" formtarget="_blank" formaction="{{ route('admin.proses.rkas_bab4', ['preview'=> 'true']) }}" class="btn btn-raised btn-sm btn-alt-primary mb-0">
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