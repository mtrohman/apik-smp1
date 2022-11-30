@extends('admin.layouts.backend')
@section('title')
    {{ $title="Tambah Parent Rekening Pendapatan" }}
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="block">
                <div class="block-header block-header-default">
                    <h3 class="block-title">
                        {{ $title }}
                    </h3>
                </div>

                <div class="block-content">
                    <form id="tambahForm" method="POST" action='{{ route("admin.rekening-parent-pendapatans.store") }}' >
                            @csrf

                            <div class="row">
                                <div class="mb-4">
                                    <div class="form-floating">
                                        <input type="text" class="form-control @error('kode_parent') is-invalid @enderror" id="kode_parent" name="kode_parent" placeholder="Masukkan Kode">
                                        <label class="form-label" for="kode_parent">Kode Parent</label>
                                        @error('kode_parent')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="mb-4">
                                    <div class="form-floating">
                                        <input type="text" class="form-control @error('nama_parent') is-invalid @enderror" id="nama_parent" name="nama_parent" placeholder="Masukkan Nama Parent">
                                        <label class="form-label" for="nama_parent">Nama Parent</label>
                                        @error('nama_parent')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>
                            </div>
                            
                        </form>
                    
                </div>

                <div class="block-content block-content-full block-content-sm bg-body-light text-end">
                    <a class="btn btn-danger btn-sm mr-1" href='{{ route("admin.rekening-parent-pendapatans.index") }}'>Batal</a>
                    <button type="submit" form="tambahForm" class="btn btn-sm btn-alt-primary">
                      <i class="fa fa-check opacity-50 me-1"></i> Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection