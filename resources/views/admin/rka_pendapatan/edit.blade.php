@extends('admin.layouts.backend')
@section('title')
    {{ $title='Edit Rka Pendapatan' }}
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
    <script src="{{ asset('js/plugins/cleave/cleave.min.js') }}"></script>
    <script>
        $(function () {
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
        });
    </script>
    
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-9">
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

                    <form id="editForm" method="POST" action='{{ route("admin.rka-pendapatans.update", $rkaPendapatan->id) }}' enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-lg-7">

                                <div class="row">
                                    <div class="mb-4">
                                        <div class="form-floating">
                                            <input type="text" class="form-control mono @error('ta') is-invalid @enderror" id="ta" name="ta" placeholder="Masukkan TA" value="{{$rkaPendapatan->ta}}" readonly>
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
                                            <input type="hidden" name="rekening_id" value="{{$rkaPendapatan->rekening_id}}">
                                            <select class="form-select mono @error('rekening_id') is-invalid @enderror" id="rekening_id" name="rekening_id" style="width: 100%;" disabled>
                                                <option value>Pilih Rekening</option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
                                                @foreach ($parent as $item)
                                                    <option value="{{$item->id}}" @if($rkaPendapatan->rekening_id == $item->id) selected @endif>{{ $item->kode_rekening." - ".$item->nama_rekening }}</option>
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
                                            <input type="text" class="form-control mono rupiah @error('title') is-invalid @enderror" id="nominal" name="nominal" placeholder="Masukkan Nominal" value="{{$rkaPendapatan->nominal}}" readonly>
                                            <label class="form-label" for="nominal">Nominal</label>
                                            @error('nominal')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-5">
                                    
                                @for ($i = 1; $i <= 4; $i++)
                                <div class="row">
                                    @php $triwulan= "triwulan_".$i; @endphp
                                    <div class="mb-4">
                                        <div class="form-floating">
                                            <input type="text" class="form-control triwulan mono rupiah @error($triwulan) is-invalid @enderror" id="{{$triwulan}}" name="{{$triwulan}}" placeholder="Masukkan Triwulan {{$i}}" value="{{$rkaPendapatan->alokasi[$triwulan] ?? 0}}">
                                            <label class="form-label" for="{{$triwulan}}">Triwulan {{$i}}</label>
                                            @error($triwulan)
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                    </div>
                                </div>
                                @endfor

                            </div>
                        </div>
                        
                    </form>
                </div>

                <div class="block-content block-content-full block-content-sm bg-body-light text-end">
                    <a class="btn btn-danger btn-sm mr-1" href='{{ route("admin.rka-pendapatans.index") }}'>Batal</a>
                    <button type="submit" form="editForm" class="btn btn-sm btn-alt-primary">
                      <i class="fa fa-check opacity-50 me-1"></i> Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection