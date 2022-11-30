@extends('admin.layouts.backend')
@section('title')
    {{ $title='Edit Kegiatan' }}
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
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

                    <form id="editForm" method="POST" action='{{ route("admin.rekening-kegiatans.update", $rekeningKegiatan->id) }}' enctype="multipart/form-data">
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
                                    <select class="form-select @error('rekening_id') is-invalid @enderror" id="rekening_id" name="rekening_id" style="width: 100%;">
                                        <option value>Pilih Rekening</option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
                                        @foreach ($parent as $item)
                                            <option value="{{$item->id}}" @if($rekeningKegiatan->rekening_id == $item->id) selected @endif>{{ $item->kode_rekening." - ".$item->nama_rekening }}</option>
                                        @endforeach
                                        {{--<option value="2">CSS</option> --}}
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
                                    <input type="text" class="form-control @error('kode_kegiatan') is-invalid @enderror" id="kode_kegiatan" name="kode_kegiatan" placeholder="Masukkan Kode" value="{{$rekeningKegiatan->kode_kegiatan}}">
                                    <label class="form-label" for="kode_kegiatan">Kode</label>
                                    @error('kode_kegiatan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>
                        </div>

                        <div class="row">
                            <div class="mb-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('nama_kegiatan') is-invalid @enderror" id="nama_kegiatan" name="nama_kegiatan" placeholder="Masukkan Nama" value="{{$rekeningKegiatan->nama_kegiatan}}">
                                    <label class="form-label" for="nama_kegiatan">Nama Kegiatan</label>
                                    @error('nama_kegiatan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>
                        </div>

                        <div class="row">
                            <div class="mb-4">
                                <div class="form-floating">
                                    <textarea class="form-control @error('ket_kegiatan') is-invalid @enderror" id="ket_kegiatan" name="ket_kegiatan" placeholder="Masukkan Keterangan" style="height: 100px">{{$rekeningKegiatan->ket_kegiatan}}</textarea>
                                    <label class="form-label" for="ket_kegiatan">Keterangan Kegiatan</label>
                                    @error('ket_kegiatan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>
                        </div>

                        {{-- <div class="row">
                            <div class="mb-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" placeholder="Masukkan Title" value="{{$rekeningKegiatan->title}}">
                                    <label class="form-label" for="title">Title</label>
                                    @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div> --}}
                        
                    </form>
                </div>

                <div class="block-content block-content-full block-content-sm bg-body-light text-end">
                    <a class="btn btn-danger btn-sm mr-1" href='{{ route("admin.rekening-kegiatans.index") }}'>Batal</a>
                    <button type="submit" form="editForm" class="btn btn-sm btn-alt-primary">
                      <i class="fa fa-check opacity-50 me-1"></i> Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection