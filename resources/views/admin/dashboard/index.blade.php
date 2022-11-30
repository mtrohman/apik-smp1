@extends('admin.layouts.backend')
@section('title', 'Dashboard')

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="block block-rounded">
                {{-- <div class="block-header block-header-default">
                    {{ __('Dashboard') }}
                </div> --}}

                <div class="block-content">
                    @if (session('message'))
                    <div class="alert alert-success" role="alert">
                        {{ session('message') }}
                    </div>
                    @endif

                    <h4>Welcome, {{auth()->user()->name}}!</h4>
                </div>
            </div>

            
        </div>
    </div>

@endsection