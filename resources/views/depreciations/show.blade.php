@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detalhes da Depreciação</h1>

    <div class="card">
        <div class="card-header">
            Depreciação #{{ $depreciation->id }}
        </div>
        <div class="card-body">
            <p><strong>Máquina:</strong> {{ $depreciation->machine->name }}</p>
            <p><strong>Valor Inicial:</strong> {{ $depreciation->initial_value }}</p>
            <p><strong>Valor Residual:</strong> {{ $depreciation->residual_value }}</p>
            <p><strong>Vida Útil (anos):</strong> {{ $depreciation->useful_life_years }}</p>
            <p><strong>Valor da Depreciação:</strong> {{ $depreciation->amount }}</p>
        </div>
        <div class="card-footer">
            <a href="{{ route('depreciations.edit', $depreciation->id) }}" class="btn btn-warning">Editar</a>
            <form action="{{ route('depreciations.destroy', $depreciation->id) }}" method="POST" style="display:inline-block;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Excluir</button>
            </form>
            <a href="{{ route('depreciations.index') }}" class="btn btn-secondary">Voltar</a>
        </div>
    </div>
</div>
@endsection
