@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Lista de Depreciações</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('depreciations.create') }}" class="btn btn-primary mb-3">Adicionar Depreciação</a>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Máquina</th>
                <th>Valor Inicial</th>
                <th>Valor Residual</th>
                <th>Vida Útil (Anos)</th>
                <th>Valor da Depreciação</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($depreciations as $depreciation)
                <tr>
                    <td>{{ $depreciation->id }}</td>
                    <td>{{ $depreciation->machine->name }}</td>
                    <td>{{ $depreciation->initial_value }}</td>
                    <td>{{ $depreciation->residual_value }}</td>
                    <td>{{ $depreciation->useful_life_years }}</td>
                    <td>{{ $depreciation->amount }}</td>
                    <td>
                        <a href="{{ route('depreciations.show', $depreciation->id) }}" class="btn btn-info">Ver</a>
                        <a href="{{ route('depreciations.edit', $depreciation->id) }}" class="btn btn-warning">Editar</a>
                        <form action="{{ route('depreciations.destroy', $depreciation->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Excluir</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
