@extends('admin.layouts.backend')
@section('title')
    {{ $title='Edit Rekening Pendapatan' }}
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

                    <form id="editForm" method="POST" action='{{ route("admin.rekening-pendapatans.update", $rekeningPendapatan->id) }}' enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="mb-4">
                                <div class="form-floating">
                                    <select class="form-select @error('parent_id') is-invalid @enderror" id="parent_id" name="parent_id" style="width: 100%;">
                                        <option value>Pilih Parent Rekening</option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
                                        @foreach ($parent as $item)
                                            <option value="{{$item->id}}" @if($rekeningPendapatan->parent_id == $item->id) selected @endif>{{ $item->nama_parent }}</option>
                                        @endforeach
                                    </select>
                                    <label class="form-label" for="example-select2">Parent</label>
                                    @error('parent_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>
                        </div>

                        <div class="row">
                            <div class="mb-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('kode_rekening') is-invalid @enderror" id="kode_rekening" name="kode_rekening" placeholder="Masukkan Kode" value="{{$rekeningPendapatan->kode_rekening}}">
                                    <label class="form-label" for="kode_rekening">Kode Rekening</label>
                                    @error('kode_rekening')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>
                        </div>

                        <div class="row">
                            <div class="mb-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('nama_rekening') is-invalid @enderror" id="nama_rekening" name="nama_rekening" placeholder="Masukkan Nama" value="{{$rekeningPendapatan->nama_rekening}}">
                                    <label class="form-label" for="nama_rekening">Nama Rekening</label>
                                    @error('nama_rekening')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>
                        </div>
                        
                    </form>
                </div>

                <div class="block-content block-content-full block-content-sm bg-body-light text-end">
                    <a class="btn btn-danger btn-sm mr-1" href='{{ route("admin.rekening-pendapatans.index") }}'>Batal</a>
                    <button type="submit" form="editForm" class="btn btn-sm btn-alt-primary">
                      <i class="fa fa-check opacity-50 me-1"></i> Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection