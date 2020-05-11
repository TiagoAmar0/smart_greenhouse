<div class="card text-center">
    <div class="card-header bg-dark text-white ">
        {{ $name }}: {{ $value }} {{ $metric }}
    </div>
    <div class="card-body">
        <img src="{{ $image }}" alt="{{ $name }}" style="width: auto; height: 200px">
    </div>
    <div class="card-footer bg-dark text-white ">
        Atualizado em: {{ $updatedAt }} - Histórico
    </div>
</div>
