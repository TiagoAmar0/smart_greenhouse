@extends('layouts.card-template')

@section('card-title')
    Equipamentos
@endsection

@section('card-content')
    <a href="{{ route('equipments.create') }}" class="btn btn-large btn-outline-dark mb-3">
        Adicionar novo equipamento
    </a>

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
                <th>Nome</th>
                <th>Tipo</th>
                <th>Criado em</th>
                <th>Atualizado em</th>
                <th colspan="2">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($equipments as $equipment)
                <tr>
                    <td>{{ $equipment->id }}</td>
                    <td>{{ $equipment->name }}</td>
                    <td>{{ $equipment->type == 1 ? "Sensor" : ($equipment->type == "2" ? "Atuador" : "Thing") }}</td>
                    <td>{{ $equipment->created_at }}</td>
                    <td>{{ $equipment->updated_at }}</td>
                    <td>
                        <a href="{{ route('equipments.edit', $equipment->id) }}" class="btn btn-success btn-block">⠀Editar⠀</a>
                    </td>
                    <td>
                        <form action="{{ route('equipments.destroy', $equipment->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-block">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
