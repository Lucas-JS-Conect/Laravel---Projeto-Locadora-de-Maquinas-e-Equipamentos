@extends('layouts.app')

@section('content')
    <div>
        <h2>Detalhes da Manutenção</h2>
        <table class="table">
            <tbody>
                <tr>
                    <th>ID</th>
                    <td>{{ $maintenance->id }}</td>
                </tr>
                <tr>
                    <th>Máquina</th>
                    <td>{{ $maintenance->machine->name }}</td>
                </tr>
                <tr>
                    <th>Data de Início</th>
                    <td>{{ \Carbon\Carbon::parse($maintenance->start_date)->format('d/m/Y') }}</td>
                </tr>
                <tr>
                    <th>Data de Término</th>
                    <td>{{ $maintenance->end_date ? \Carbon\Carbon::parse($maintenance->end_date)->format('d/m/Y') : '-' }}</td>
                </tr>
                <tr>
                    <th>Descrição</th>
                    <td>{{ $maintenance->description }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>{{ $maintenance->is_finished ? 'Concluída' : 'Em andamento' }}</td>
                </tr>
            </tbody>
        </table>

        @if (!$maintenance->is_finished)
            <form action="{{ route('maintenances.finish', $maintenance) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="end_date">Data de Término:</label>
                    <input type="date" id="end_date" name="end_date" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-success">Finalizar Manutenção</button>
            </form>
        @else
            <p>Esta manutenção já foi concluída.</p>
        @endif
    </div>
@endsection
