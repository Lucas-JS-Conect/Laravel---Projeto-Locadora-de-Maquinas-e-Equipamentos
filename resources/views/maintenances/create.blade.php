@extends('layouts.main')

@section('title', 'Adicionar Manutenção')

@section('content')
<div class="container">
    <h1>Adicionar Manutenção</h1>

    <form action="{{ route('maintenances.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="machine_id">Máquina:</label>
            <select name="machine_id" id="machine_id" class="form-control">
                <option value="">Selecione uma máquina</option>
                @foreach($machines as $machine)
                    @if ($machine->status != 'Alugada')
                        <option value="{{ $machine->id }}">{{ $machine->name }}</option>
                    @endif
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="start_date">Data de Início:</label>
            <input type="datetime-local" class="form-control" id="start_date" name="start_date" required>
        </div>

        <div class="form-group">
            <label for="description">Descrição:</label>
            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Adicionar</button>
        <a href="{{ route('maintenances.index') }}" class="btn btn-secondary">Voltar</a>
    </form>
</div>
@endsection
