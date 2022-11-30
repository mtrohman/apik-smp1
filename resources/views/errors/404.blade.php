{{-- @extends('errors::minimal')

@section('title', __('Not Found'))
@section('code', '404')
@section('message', __('Not Found')) --}}

@extends('layouts.simple')
@section('title', 'Not Found')

@section('content')

    <div class="hero bg-body-extra-light">
          <div class="hero-inner">
            <div class="content content-full">
              <div class="py-4 text-center">
                <div class="display-1 fw-bold text-danger">
                  <i class="fa fa-exclamation-triangle opacity-50 me-1"></i> 404
                </div>
                <h1 class="fw-bold mt-5 mb-2">Oops.. Tidak Ditemukan..</h1>
                <h2 class="fs-4 fw-medium text-muted mb-5">Maaf, halaman yang anda cari tidak ditemukan</h2>
                <a class="btn btn-lg btn-alt-secondary" href="#" onclick="history.back()">
                  <i class="fa fa-arrow-left opacity-50 me-1"></i> Kembali
                </a>
              </div>
            </div>
          </div>
        </div>

@endsection
