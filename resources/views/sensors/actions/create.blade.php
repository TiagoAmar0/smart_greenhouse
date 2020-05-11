@extends('layouts.card-template')

@section('card-title')
    Adicionar novo sensor
@endsection

@section('card-content')
    <a href="{{ route('sensors.index') }}" class="btn btn-large btn-outline-dark mb-3">
        « Voltar à listagem
    </a>

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger">
                {{ $error }}
            </div>
        @endforeach
    @endif

    <form method="POST" action="{{ route('sensors.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="sensor">Sensor:</label>
            <select id="sensor" name="sensor" class="custom-select custom-select-sm" required>
                <option disabled selected value>Escolha o sensor </option>
                @foreach($sensors as $sensor)
                    <option value="{{ $sensor->id }}">{{ $sensor->name }}</option>
                @endforeach
            </select>
            <small id="sensor_name_help" class="form-text text-muted">Nome do sensor a adicionar.</small>
        </div>
        <div class="form-group">
            <label for="text">Texto:</label>
            <input type="text" class="form-control" id="text" name="text" aria-describedby="action_text_help" required>
            <small id="action_text_help" class="form-text text-muted">Texto a aparecer no botão que executará a ação.</small>
        </div>
        <div class="form-group">
            <label for="route">Route:</label>
            <input type="text" class="form-control" id="route" name="route" aria-describedby="action_route_help" required>
            <small id="action_route_help" class="form-text text-muted">Route da api que executará a ação.</small>
        </div>
        <div class="form-group">
            <label for="value">Route:</label>
            <input type="text" class="form-control" id="value" name="value" aria-describedby="action_value_help">
            <small id="action_value_help" class="form-text text-muted">Valor a enviar para a route (opcional).</small>
        </div>
        <button type="submit" class="btn btn-dark">Adicionar</button>
    </form>
@endsection
