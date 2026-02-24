@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ isset($scheduleRequest) ? 'Editar Solicitação de Agendamento' : 'Nova Solicitação de Agendamento' }}</h1>

    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <form action="{{ isset($scheduleRequest) ? route('schedule_requests.update', $scheduleRequest->id) : route('schedule_requests.store') }}" method="POST">
        @csrf
        @if (isset($scheduleRequest))
        @method('PUT')
        @endif

        <div class="form-group">
            <label for="client_id">Cliente:</label>
            <select name="client_id" id="client_id" class="form-control" required>
                <option value="">Selecione um cliente</option>
                @foreach ($clients as $client)
                <option value="{{ $client->id }}" {{ old('client_id', $scheduleRequest->client_id ?? '') == $client->id ? 'selected' : '' }}>
                    {{ $client->name }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="machine_id">Máquina Desejada:</label>
            <select name="machine_id" id="machine_id" class="form-control" required>
                <option value="">Selecione uma máquina</option>
                @foreach ($machines as $machine)
                <option value="{{ $machine->id }}" {{ old('machine_id', $scheduleRequest->machine_id ?? '') == $machine->id ? 'selected' : '' }}>
                    {{ $machine->name }} ({{ $machine->status }})
                </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="requested_date">Data Solicitada:</label>
            <input type="datetime-local" name="requested_date" id="requested_date" class="form-control" value="{{ isset($requested_date) ? $requested_date : old('requested_date') }}" required>
        </div>

        <div class="form-group">
            <label for="comments">Comentários Adicionais:</label>
            <textarea name="comments" id="comments" class="form-control">{{ old('comments', $scheduleRequest->comments ?? '') }}</textarea>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">{{ isset($scheduleRequest) ? 'Salvar Alterações' : 'Salvar Agendamento' }}</button>
            <a href="{{ route('rentals.create') }}" class="btn btn-secondary">Voltar para Página de Locação</a>
        </div>
    </form>
</div>
@endsection
