@extends('layouts.card-template')

@section('card-title')
    Sensores
@endsection

@section('card-content')
    @if(session()->get('success'))

        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session()->get('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <table class="table table-striped table-bordered text-center">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome do Equipamento</th>
                <th>Unidade</th>
                <th>Criado em</th>
                <th>Atualizado em</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sensors as $sensor)
                <tr>
                    <td>{{ $sensor->id }}</td>
                    <td>{{ $sensor->equipment->name }}</td>
                    <td>{{ $sensor->metric ? $sensor->metric : 'Por definir'}}</td>
                    <td>{{ $sensor->created_at }}</td>
                    <td>{{ $sensor->updated_at }}</td>
                    <td>
                        <a href="{{ route('sensors.edit', $sensor->id) }}" class="btn btn-success btn-block">⠀Editar⠀</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
