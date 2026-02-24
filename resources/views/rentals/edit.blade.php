@extends('layouts.main')

@section('title', 'Editar Manutenção')

@section('content')
<div class="col-md-10 offset-md-1">
    <h1>Editar Manutenção</h1>

    <form action="{{ route('maintenances.update', ['maintenance' => $maintenance->id]) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="machine_id">Máquina:</label>
            <select name="machine_id" id="machine_id" class="form-control">
                <option value="">Selecione uma máquina</option>
                @foreach($machines as $machine)
                    <option value="{{ $machine->id }}" @if($machine->id == $maintenance->machine_id) selected @endif>{{ $machine->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="start_date">Data de Início:</label>
            <input type="datetime-local" class="form-control" id="start_date" name="start_date" value="{{ \Carbon\Carbon::parse($maintenance->start_date)->format('Y-m-d\TH:i') }}">
        </div>

        <div class="form-group">
            <label for="end_date">Data de Término:</label>
            <input type="datetime-local" class="form-control" id="end_date" name="end_date" value="{{ \Carbon\Carbon::parse($maintenance->end_date)->format('Y-m-d\TH:i') }}">
        </div>

        <div class="form-group">
            <label for="type">Tipo:</label>
            <input type="text" class="form-control" id="type" name="type" value="{{ $maintenance->type }}" required>
        </div>

        <div class="form-group">
            <label for="description">Descrição:</label>
            <textarea class="form-control" id="description" name="description" rows="3" required>{{ $maintenance->description }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Salvar</button>
    </form>
</div>
@endsection
