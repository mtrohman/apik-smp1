{{-- @extends('errors::minimal')

@section('title', __('Forbidden'))
@section('code', '403')
@section('message', __($exception->getMessage() ?: 'Forbidden')) --}}

@extends('layouts.simple')
@section('title', 'Not Found')

@section('content')

    <div class="hero bg-body-extra-light">
          <div class="hero-inner">
            <div class="content content-full">
              <div class="py-4 text-center">
                <div class="display-1 fw-bold text-corporate">
                  <i class="fa fa-ban opacity-50 me-1"></i> 403
                </div>
                <h1 class="fw-bold mt-5 mb-2">Oops.. Akses Terlarang..</h1>
                <h2 class="fs-4 fw-medium text-muted mb-5">Maaf, anda tidak memiliki izin untuk mengakses halaman ini</h2>
                <a class="btn btn-lg btn-alt-secondary" href="#" onclick="history.back()">
                  <i class="fa fa-arrow-left opacity-50 me-1"></i> Kembali
                </a>
              </div>
            </div>
          </div>
        </div>

@endsection