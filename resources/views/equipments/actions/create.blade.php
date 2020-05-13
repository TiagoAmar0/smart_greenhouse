@extends('layouts.card-template')

@section('card-title')
    Adicionar novo sensor
@endsection

@section('card-content')
    <a href="{{ route('actions.index') }}" class="btn btn-large btn-outline-dark mb-3">
        « Voltar à listagem
    </a>

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger">
                {{ $error }}
            </div>
        @endforeach
    @endif

    <form method="POST" action="{{ route('actions.store') }}">
        @csrf
        <div class="form-group">
            <label for="equipment_id">Sensor:</label>
            <select id="equipment_id" name="equipment_id" class="custom-select custom-select-sm" aria-describedby="equipment_id_help" required>
                <option disabled selected value>Escolha o equipamento </option>
                @foreach($equipments as $equipment)
                    <option value="{{ $equipment->id }}">{{ $equipment->name }}</option>
                @endforeach
            </select>
            <small id="equipment_id_help" class="form-text text-muted">Nome do equipamento no qual a ação recairá.</small>
        </div>
        <div class="form-group">
            <label for="text">Texto:</label>
            <input type="text" class="form-control" id="text" name="text" aria-describedby="action_text_help" required>
            <small id="action_text_help" class="form-text text-muted">Texto a aparecer no botão que executará a ação.</small>
        </div>
        <div class="form-group">
            <label for="route">Route:</label>
            <input type="text" class="form-control" id="route" name="route" aria-describedby="action_route_help" required>
            <small id="action_route_help" class="form-text text-muted">Route da api que executará a ação (colocar '/' no início do caminho relativo).</small>
        </div>
        <div class="form-group">
            <label for="value">Valor:</label>
            <input type="text" class="form-control" id="value" name="value" aria-describedby="action_value_help">
            <small id="action_value_help" class="form-text text-muted">Valor a enviar para a route (opcional).</small>
        </div>
        <button type="submit" class="btn btn-dark">Adicionar</button>
    </form>
@endsection
