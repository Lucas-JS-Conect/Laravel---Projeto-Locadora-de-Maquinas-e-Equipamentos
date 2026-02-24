@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Solicitações de Agendamento</h1>

    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <a href="{{ route('schedule_requests.create') }}" class="btn btn-primary mb-3">Nova Solicitação</a>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Cliente</th>
                <th>Máquina</th>
                <th>Solicitação</th>
                <th>Comentários</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($scheduleRequests as $scheduleRequest)
            <tr>
                <td>{{ $scheduleRequest->id }}</td>
                <td>{{ $scheduleRequest->client->name }}</td>
                <td>{{ $scheduleRequest->machine->name }}</td>
                <td>{{ \Carbon\Carbon::parse($scheduleRequest->requested_date)->format('d-m-Y') }}</td>
                <td>{{ $scheduleRequest->comments }}</td>
                <td>{{ ucfirst($scheduleRequest->status) }}</td>
                <td>
                    @if ($scheduleRequest->status == 'Aberto')
                    <form action="{{ route('schedule_requests.complete', $scheduleRequest->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-success btn-sm">Finalizar</button>
                    </form>
                    @else
                    <span class="text-success">Finalizado</span>
                    @endif

                    <a href="{{ route('schedule_requests.show', $scheduleRequest->id) }}" class="btn btn-info btn-sm">Ver</a>
                    <a href="{{ route('schedule_requests.edit', $scheduleRequest->id) }}" class="btn btn-warning btn-sm">Editar</a>
                    <form action="{{ route('schedule_requests.destroy', $scheduleRequest->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection