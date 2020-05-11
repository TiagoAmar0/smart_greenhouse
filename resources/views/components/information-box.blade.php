<div class="card h-100 text-center">
    <div class="card-header bg-dark text-white">
        {{ $name }}: {{ $value }} {{ $metric }}
    </div>
    <div class="card-body">
        <img class="card-img" src="{{ $image }}" alt="{{ $name }}">
    </div>
    <div class="card-footer bg-dark text-white">
        Atualizado em: {{ $updatedAt }} - Histórico
        @if($slot)
            <br>
            {{ $slot }}
        @endif
    </div>
</div>
