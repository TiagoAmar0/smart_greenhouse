<div class="card bg-dark text-white text-center">
    <div class="card-header">
        {{ $name }} - {{ $value }} {{ $metric }}
    </div>
    <div class="card-body">
        <img src="{{ $image }}" alt="{{ $name }}" style="width: 100%">
    </div>
    <div class="card-footer text-muted">
        Atualizado em: {{ $updatedAt }} - Histórico
    </div>
</div>
