@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Lista de Locações</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('rentals.create') }}" class="btn btn-primary mb-3">Nova Locação</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Máquina</th>
                <th>Cliente</th>
                <th>Data de Início</th>
                <th>Horas Trabalhadas</th>
                <th>Valor Total</th>
                <th>Devolução</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($rentals as $rental)
                <tr>
                    <td>{{ $rental->id }}</td>
                    <td>{{ $rental->machine->name }}</td>
                    <td>{{ $rental->client->name }}</td>
                    <td>{{ \Carbon\Carbon::parse($rental->start_date)->format('d-m-Y H:i') }}</td>
                    <td>{{ $rental->hours_rented }}</td>
                    <td>R$ {{ number_format($rental->total_amount, 2, ',', '.') }}</td>
                    <td>
                        @if (!$rental->returned)
                            <form action="{{ route('rentals.return', $rental->id) }}" method="POST" style="display: inline-block;">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">Devolver</button>
                            </form>
                        @else
                            <span class="text-success">Devolvida</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('rentals.show', $rental->id) }}" class="btn btn-info btn-sm">Ver</a>
                        <a href="{{ route('rentals.edit', $rental->id) }}" class="btn btn-primary btn-sm">Editar</a>
                        <form action="{{ route('rentals.destroy', $rental->id) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja deletar?')">Deletar</button>
                        </form>
                        <form action="{{ route('rentals.markPayment', $rental->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="paid" id="paid_1" value="1" {{ $rental->paid ? 'checked' : '' }}>
                                <label class="form-check-label" for="paid_1">Pago</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="paid" id="paid_0" value="0" {{ !$rental->paid ? 'checked' : '' }}>
                                <label class="form-check-label" for="paid_0">Pendente</label>
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm">Atualizar Pagamento</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
