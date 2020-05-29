<div class="card text-center" id="{{ "equipment_". $id ."_info" }}">
    <div class="card-header bg-dark text-white">
        {{ $name }}: <span id="value_info">{{ $value }}</span> {{ $metric }}
    </div>
    <div class="card-body">
        <img class="card-img" src="{{ $image }}" alt="{{ $name }}">
    </div>
    <div class="card-footer bg-dark text-white">
        Atualizado em: <span id="value_updated">{{ $updatedAt }}</span>
        <br>
            <br>
            <button class="btn-sm btn-light" data-toggle="collapse" href="#collapse-{{ $id }}" role="button" aria-expanded="false" aria-controls="collapse-{{ $id }}">Ver ações »</button>
    </div>

    <div class="collapse" id="collapse-{{ $id }}">
        <div class="card card-body">
            @if(!$actions->isEmpty())
               @foreach($actions as $action)
                    @if(isset($action->value))
                        <form action="{{ '/'. $action->route. '/' . $id . '/' . $action->value }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-outline-dark btn-block mb-2">{{ $action->text }} »</button>
                        </form>
                    @else
                        <form action="{{ $action->route. '/' . $id  }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-outline-dark btn-block mb-2">{{ $action->text }} »</button>
                        </form>
                    @endif
                    @csrf
               @endforeach
            @endif
            <a href="{{ url('/dashboard/equipments/history/' . $id ) }}" class="btn btn-outline-dark btn-block">Ver Histórico »</a>
        </div>
    </div>
</div>
