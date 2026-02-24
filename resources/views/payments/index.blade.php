@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Pagamentos</h1>

    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Máquina</th>
                <th>Data de Início</th>
                <th>Data de Término</th>
                <th>Valor Pago</th>
                <th>Data do Pagamento</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($payments as $payment)
            <tr>
                <td>{{ $payment->id }}</td>
                <td>{{ $payment->rental->client->name ?? '-' }}</td>
                <td>{{ $payment->rental->machine->name ?? '-' }}</td>
                <td>{{ $payment->rental->start_date ? Carbon\Carbon::parse($payment->rental->start_date)->format('d-m-Y H:i') : '-' }}</td>
                <td>{{ $payment->rental->end_date ? Carbon\Carbon::parse($payment->rental->end_date)->format('d-m-Y H:i') : '-' }}</td>
                <td>R$ {{ number_format($payment->amount, 2, ',', '.') }}</td>
                <td>{{ $payment->paid_at ? Carbon\Carbon::parse($payment->paid_at)->format('d-m-Y H:i') : '-' }}</td>
                <td>
                    <a href="{{ route('payments.edit', $payment->id) }}" class="btn btn-warning btn-sm">Editar</a>
                    <form action="{{ route('payments.destroy', $payment->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir este pagamento?')">Excluir</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
