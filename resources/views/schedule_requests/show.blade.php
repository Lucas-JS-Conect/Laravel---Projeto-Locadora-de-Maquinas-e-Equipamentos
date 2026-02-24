@extends('layouts.main')

@section('title', 'Detalhes da Solicitação de Agendamento')

@section('content')
<div class="container">
    <h1>Detalhes da Solicitação de Agendamento</h1>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">ID da Solicitação: {{ $scheduleRequest->id }}</h5>
            <p class="card-text"><strong>Máquina Desejada:</strong> {{ $scheduleRequest->machine->name }}</p>
            <p class="card-text"><strong>Cliente:</strong> {{ $scheduleRequest->client->name }}</p>
            <p class="card-text"><strong>Data Solicitada:</strong> {{ \Carbon\Carbon::parse($scheduleRequest->requested_date)->format('d/m/Y H:i') }}</p>
            <p class="card-text"><strong>Status:</strong> {{ ucfirst($scheduleRequest->status) }}</p>
            <a href="{{ route('schedule_requests.index') }}" class="btn btn-primary">Voltar para Lista de Solicitações</a>
        </div>
        @if ($scheduleRequest->status == 'Aberto')
        <div class="card-footer">
            <form action="{{ route('schedule_requests.complete', $scheduleRequest->id) }}" method="POST">
                @csrf
                @method('PUT')
                <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Tem certeza que deseja finalizar esta solicitação de agendamento?')">Finalizar</button>
            </form>
        </div>
        @else
        <div class="card-footer">
            <span class="text-success">Finalizado</span>
        </div>
        @endif
    </div>
</div>
@endsection
