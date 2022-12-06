@extends('admin.layouts.backend')
@section('title')
    {{ $title='Tambah Belanja' }}
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
    <script src="{{ asset('js/lib/jquery.min.js') }}"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="{{ asset('js/plugins/cleave/cleave.min.js') }}"></script>
    <script>
        new Cleave('.rupiah', {
            numeral: true,
            numeralDecimalMark: ',',
            delimiter: '.',
            swapHiddenInput: true
        });

        $(function () {
            var rekening_id = $('#rekening_id').val();
            // console.log(rekening_id);
            if(Number(rekening_id) > 0){
                let url = '{{ route('admin.rka-pengeluarans.parent' , ':id') }}';
                url = url.replace(':id', rekening_id);
                axios.get(url)
                .then(function (response) {
                    $('#rka_pengeluaran_id').children().not(':first').remove();//.empty();

                    $.each(response.data, function (id, value) {
                        // console.log(value);
                        $('#rka_pengeluaran_id').append(new Option(value.rekening_kegiatan.kode_kegiatan+" - "+value.rekening_kegiatan.nama_kegiatan, value.id))
                    })
                });
            }

            $('#rekening_id').on('change', function () {
                let url = '{{ route('admin.rka-pengeluarans.parent' , ':id') }}';
                url = url.replace(':id', $(this).val());

                axios.get(url)
                .then(function (response) {
                    // console.log(response.data);
                    $('#rka_pengeluaran_id').children().not(':first').remove();//.empty();

                    $.each(response.data, function (id, value) {
                        // console.log(value);
                        $('#rka_pengeluaran_id').append(new Option(value.rekening_kegiatan.kode_kegiatan+" - "+value.rekening_kegiatan.nama_kegiatan, value.id))
                    })
                });
            });

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

                    <form id="tambahForm" method="POST" action='{{ route("admin.belanjas.store") }}' enctype="multipart/form-data">
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
                                    <select class="form-select mono @error('rekening_id') is-invalid @enderror" id="rekening_id" name="rekening_id" style="width: 100%;" required>
                                        <option value>Pilih Rekening</option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
                                        @foreach ($parent as $item)
                                            <option value="{{$item->id}}" @if($item->id == old('rekening_id')) selected @endif >{{ $item->kode_rekening." - ".$item->nama_rekening }}</option>
                                        @endforeach
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
                                    <select class="form-select mono @error('rka_pengeluaran_id') is-invalid @enderror" id="rka_pengeluaran_id" name="rka_pengeluaran_id" style="width: 100%;" required>
                                        <option value>Pilih Kegiatan</option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
                                        {{-- @foreach ($parent as $item)
                                            <option value="{{$item->id}}">{{ $item->kode_kegiatan." - ".$item->nama_kegiatan }}</option>
                                        @endforeach --}}
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
                                    <input type="text" class="form-control mono rupiah @error('nominal') is-invalid @enderror" id="nominal" name="nominal" placeholder="Masukkan Nominal" value="0" required>
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
                                    <input type="date" class="form-control mono @error('tanggal') is-invalid @enderror" id="tanggal" name="tanggal" placeholder="Masukkan Tanggal" required>
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
                                    <textarea class="form-control @error('keterangan') is-invalid @enderror" id="keterangan" name="keterangan" placeholder="Masukkan Keterangan" style="height: 100px"></textarea>
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
                    <button type="submit" form="tambahForm" class="btn btn-sm btn-alt-primary">
                      <i class="fa fa-check opacity-50 me-1"></i> Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection