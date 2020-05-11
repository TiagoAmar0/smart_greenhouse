@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row row-cols-1 row-cols-lg-6 row-cols-md-4 row-cols-sm-3 row-cols-xs-1">
        @foreach($sensors as $sensor)
            <div class="col mb-4">
                <x-information-box
                    name="{{ $sensor->name }}"
                    image="{{ $sensor->image }}"
                    value="{{ $sensor->value }}"
                    metric="{{ $sensor->metric }}"
                    updatedAt="{{ $sensor->updated_at }}"
                >
                </x-information-box>
            </div>
        @endforeach
    </div>

    <div class="row">

    </div>
</div>
@endsection

