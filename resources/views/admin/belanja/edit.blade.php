@extends('admin.layouts.backend')
@section('title')
    {{ $title='Edit Belanja' }}
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

@section('js_after')
    <script src="{{ asset('js/plugins/cleave/cleave.min.js') }}"></script>
    <script>
        new Cleave('.rupiah', {
            numeral: true,
            numeralDecimalMark: ',',
            delimiter: '.',
            swapHiddenInput: true
        });
    </script>
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

                    <form id="editForm" method="POST" action='{{ route("admin.belanjas.update", $belanja->id) }}' enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

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
                                    <input type="hidden" name="rekening_id" value="{{$belanja->rkaPengeluaran->rekeningKegiatan->rekening_id}}">
                                    <select class="form-select mono @error('rekening_id') is-invalid @enderror" id="rekening_id" name="rekening_id" style="width: 100%;" disabled>
                                        <option value>Pilih Rekening</option>
                                        <option selected value="{{ $belanja->rkaPengeluaran->rekeningKegiatan->rekeningPengeluaran->id }}">{{ $belanja->rkaPengeluaran->rekeningKegiatan->rekeningPengeluaran->kode_rekening }} - {{ $belanja->rkaPengeluaran->rekeningKegiatan->rekeningPengeluaran->nama_rekening }}</option>
                                    </select>
                                    <label class="form-label" for="rekening_id">Rekening</label>
                                    @error('rekening_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>
                        </div>

                        <div class="row">
                            <div class="mb-4">
                                <div class="form-floating">
                                    <input type="hidden" name="rka_pengeluaran_id" value="{{$belanja->rka_pengeluaran_id}}">
                                    <select class="form-select mono @error('rka_pengeluaran_id') is-invalid @enderror" id="rka_pengeluaran_id" name="rka_pengeluaran_id" style="width: 100%;" disabled>
                                        <option value>Pilih Kegiatan</option>
                                        <option selected value="{{ $belanja->rka_pengeluaran_id }}">{{ $belanja->rkaPengeluaran->rekeningKegiatan->kode_kegiatan }} - {{ $belanja->rkaPengeluaran->rekeningKegiatan->nama_kegiatan}}</option>
                                    </select>
                                    <label class="form-label" for="rka_pengeluaran_id">Kegiatan</label>
                                    @error('rka_pengeluaran_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>
                        </div>

                        <div class="row">
                            <div class="mb-4">
                                <div class="form-floating">
                                    <input type="hidden" name="sumber_dana" value="{{$belanja->sumber_dana}}">
                                    <select class="form-select mono @error('sumber_dana') is-invalid @enderror" id="sumber_dana" name="sumber_dana" style="width: 100%;" required disabled>
                                        <option value>Pilih Sumber Dana</option>
                                        <option selected value="{{ $belanja->sumber_dana }}">{{ $belanja->sumber_dana }}</option>                                     
                                    </select>
                                    <label class="form-label" for="sumber_dana">Sumber Dana</label>
                                    @error('sumber_dana')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>
                        </div>

                        <div class="row">
                            <div class="mb-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control mono rupiah @error('nominal') is-invalid @enderror" id="nominal" name="nominal" placeholder="Masukkan Nominal" value="{{ $belanja->nominal }}" required>
                                    <label class="form-label" for="nominal">Nominal</label>
                                    @error('nominal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>
                        </div>

                         <div class="row">
                            <div class="mb-4">
                                <div class="form-floating">
                                    <input type="date" class="form-control mono @error('tanggal') is-invalid @enderror" id="tanggal" name="tanggal" placeholder="Masukkan Tanggal" readonly value="{{$belanja->tanggal->format('Y-m-d')}}">
                                    <label class="form-label" for="ta">Tanggal</label>
                                    @error('tanggal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>
                        </div>

                        <div class="row">
                            <div class="mb-4">
                                <div class="form-floating">
                                    <textarea class="form-control @error('keterangan') is-invalid @enderror" id="keterangan" name="keterangan" placeholder="Masukkan Keterangan" style="height: 100px">{{$belanja->keterangan}}</textarea>
                                    <label class="form-label" for="keterangan">Keterangan</label>
                                    @error('keterangan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>
                        </div>
                        
                    </form>
                </div>

                <div class="block-content block-content-full block-content-sm bg-body-light text-end">
                    <a class="btn btn-danger btn-sm mr-1" href='{{ route("admin.belanjas.index") }}'>Batal</a>
                    <button type="submit" form="editForm" class="btn btn-sm btn-alt-primary">
                      <i class="fa fa-check opacity-50 me-1"></i> Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection