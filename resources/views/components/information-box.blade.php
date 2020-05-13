{{--<div class="card h-100 text-center">--}}
{{--    <div class="card-header bg-dark text-white">--}}
{{--        {{ $name }}: {{ $value }} {{ $metric }}--}}
{{--    </div>--}}
{{--    <div class="card-body">--}}
{{--        <img class="card-img" src="{{ $image }}" alt="{{ $name }}">--}}
{{--    </div>--}}
{{--    <div class="card-footer bg-dark text-white">--}}
{{--        Atualizado em: {{ $updatedAt }} <br> Histórico »--}}
{{--        @if($slot)--}}
{{--            <br>--}}
{{--            {{ $slot }}--}}
{{--        @endif--}}
{{--    </div>--}}
{{--</div>--}}

<div class="card h-100 text-center" >
    <div class="card-header bg-dark text-white">
        {{ $name }}: {{ $value }} {{ $metric }}
    </div>
    <div class="card-body">
        <img class="card-img" src="{{ $image }}" alt="{{ $name }}">
    </div>
    <div class="card-footer bg-dark text-white">
        Atualizado em: {{ $updatedAt }}
        <br>
        @if(!$actions->isEmpty())
            <br>
            <button class="btn-sm btn-light" data-toggle="collapse" href="#collapse-{{ $id }}" role="button" aria-expanded="false" aria-controls="collapse-{{ $id }}">Ver ações »</button>
        @endif
    </div>
    @if(!$actions->isEmpty())
        <div class="collapse" id="collapse-{{ $id }}">
            <div class="card card-body">
               @foreach($actions as $action)
                    @if($action->value)
                        <form action="{{ $action->route, $action->value }}" method="POST">
                    @else
                        <form action="{{ url($action->route) }}" method="POST">
                    @endif

                    @csrf
                    <button type="submit" class="btn btn-outline-dark btn-block">{{ $action->text }} »</button>
                    </form>
               @endforeach
            </div>
        </div>
    @endif
</div>
