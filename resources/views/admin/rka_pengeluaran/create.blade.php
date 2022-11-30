@extends('admin.layouts.backend')
@section('title')
    {{ $title='Tambah Rka Pengeluaran' }}
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
        /* new Cleave('.rupiah', {
            numeral: true,
            numeralDecimalMark: ',',
            delimiter: '.',
            swapHiddenInput: true
        }); */

        $(function () {
            var rekening_id = $('#rekening_id').val();
            // console.log(rekening_id);
            if(Number(rekening_id) > 0){
                let url = '{{ route('admin.rekening-kegiatans.parent' , ':id') }}';
                url = url.replace(':id', rekening_id);
                axios.get(url)
                .then(function (response) {
                    console.log(response.data.data);
                    $('#kegiatan_id').children().not(':first').remove();//.empty();

                    $.each(response.data.data, function (id, value) {
                        // console.log(value);
                        $('#kegiatan_id').append(new Option(value.kode_kegiatan+" - "+value.nama_kegiatan, value.id))
                    })
                });
            }

            var arrayCleave = [];
            var rupiahCollection = document.getElementsByClassName("rupiah");
            var rupiah = Array.from(rupiahCollection);
            rupiah.forEach(function (id, index) {
                arrayCleave[index] = new Cleave(id, {
                    numeral: true,
                    numeralDecimalMark: ',',
                    delimiter: '.',
                    swapHiddenInput: true
                })
            });
            // console.log(arrayCleave[1]);

            $('.triwulan').parent().focusout(function() {
                let tw1 = Number($('#triwulan_1').val());
                let tw2 = Number($('#triwulan_2').val());
                let tw3 = Number($('#triwulan_3').val());
                let tw4 = Number($('#triwulan_4').val());
                let nominal = tw1 + tw2 + tw3+ tw4;
                // console.log(nominal);
                arrayCleave[0].setRawValue(nominal);
                // $('input[name=nominal]').val(nominal).trigger("change");
            });

            $('#rekening_id').on('change', function () {
                let url = '{{ route('admin.rekening-kegiatans.parent' , ':id') }}';
                url = url.replace(':id', $(this).val());

                axios.get(url)
                .then(function (response) {
                    // console.log(response.data.data);
                    $('#kegiatan_id').children().not(':first').remove();//.empty();

                    $.each(response.data.data, function (id, value) {
                        // console.log(value);
                        $('#kegiatan_id').append(new Option(value.kode_kegiatan+" - "+value.nama_kegiatan, value.id))
                    })
                });
            });

        });
    </script>
    
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
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

                    <form id="tambahForm" method="POST" action='{{ route("admin.rka-pengeluarans.store") }}' enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-lg-6">
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
                                            <select class="form-select mono @error('kegiatan_id') is-invalid @enderror" id="kegiatan_id" name="kegiatan_id" style="width: 100%;" required>
                                                <option value>Pilih Kegiatan</option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
                                                {{-- @foreach ($parent as $item)
                                                    <option value="{{$item->id}}">{{ $item->kode_kegiatan." - ".$item->nama_kegiatan }}</option>
                                                @endforeach --}}
                                                {{--<option value="2">CSS</option> --}}
                                            </select>
                                            <label class="form-label" for="kegiatan_id">Kegiatan</label>
                                            @error('kegiatan_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mb-4">
                                        <div class="form-floating">
                                            <input type="text" class="form-control mono rupiah @error('nominal') is-invalid @enderror" id="nominal" name="nominal" placeholder="Masukkan Nominal" value="{{ old('nominal', 0) }}" readonly>
                                            <label class="form-label" for="nominal">Nominal</label>
                                            @error('nominal')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-3">
                                    
                                @for ($i = 1; $i <= 4; $i++)
                                <div class="row">
                                    @php $triwulan= "triwulan_".$i; @endphp
                                    <div class="mb-4">
                                        <div class="form-floating">
                                            <input type="text" class="form-control triwulan mono rupiah @error($triwulan) is-invalid @enderror" id="{{$triwulan}}" name="{{$triwulan}}" placeholder="Masukkan Triwulan {{$i}}" value="{{ old($triwulan, 0) }}">
                                            <label class="form-label" for="{{$triwulan}}">Triwulan {{$i}}</label>
                                            @error($triwulan)
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                    </div>
                                </div>
                                @endfor

                            </div>

                            <div class="col-lg-3">
                                
                                <div class="row">
                                    <div class="mb-4">
                                        <div class="form-floating">
                                            <input type="text" class="form-control mono rupiah @error('apbd') is-invalid @enderror" id="apbd" name="apbd" placeholder="Masukkan Apbd" value="{{ old('apbd', 0) }}">
                                            <label class="form-label" for="apbd">APBD</label>
                                            @error('apbd')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-4">
                                        <div class="form-floating">
                                            <input type="text" class="form-control mono rupiah @error('bos') is-invalid @enderror" id="bos" name="bos" placeholder="Masukkan Bos" value="{{ old('bos', 0) }}">
                                            <label class="form-label" for="bos">BOS Pusat</label>
                                            @error('bos')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-4">
                                        <div class="form-floating">
                                            <input type="text" class="form-control mono rupiah @error('spm') is-invalid @enderror" id="spm" name="spm" placeholder="Masukkan Spm" value="{{ old('spm', 0) }}">
                                            <label class="form-label" for="spm">SPM</label>
                                            @error('spm')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>

                    </form>
                </div>

                <div class="block-content block-content-full block-content-sm bg-body-light text-end">
                    <a class="btn btn-danger btn-sm mr-1" href='{{ route("admin.rka-pengeluarans.index") }}'>Batal</a>
                    <button type="submit" form="tambahForm" class="btn btn-sm btn-alt-primary">
                      <i class="fa fa-check opacity-50 me-1"></i> Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection