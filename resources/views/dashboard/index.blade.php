@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        @foreach($sensors as $sensor)
            <div class="col-md-3 mb-5">
                <x-information-box
                    name="{{ $sensor->name }}"
                    image="{{ $sensor->image }}"
                    value="{{ $sensor->value }}"
                    metric="{{ $sensor->metric }}"
                    updatedAt="{{ $sensor->updated_at }}"
                />
            </div>
        @endforeach
    </div>
</div>
@endsection
