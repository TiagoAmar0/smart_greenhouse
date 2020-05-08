@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header bg-dark text-white">
                        @yield('card-title')
                    </div>

                    <div class="card-body">
                        @yield('card-content')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection