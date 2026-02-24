@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detalhes da Locação</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Máquina: {{ $rental->machine->name }}</h5>
            <p class="card-text">Cliente: {{ $rental->client->name }}</p>
            <p class="card-text">Data de Início: {{ $rental->start_date }}</p>
            <p class="card-text">Data de Término: {{ $rental->end_date }}</p>
            <p class="card-text">Forma de Pagamento: {{ $rental->payment_method }}</p>
            @if ($rental->payment_method == 'cartao_credito')
                <p class="card-text">Número de Parcelas: {{ $rental->installments }}</p>
            @endif
            <p class="card-text">Horas de Locação: {{ $rental->hours_rented }}</p>
            <p class="card-text">Valor Total: {{ $rental->total_amount }}</p>
            <p class="card-text">Pagamento Realizado: {{ $rental->paid ? 'Sim' : 'Não' }}</p>
            <p class="card-text">Máquina Devolvida: {{ $rental->returned ? 'Sim' : 'Não' }}</p>

            @if (!$rental->returned)
                <form action="{{ route('rentals.return', $rental->id) }}" method="POST" style="display: inline-block;">
                    @csrf
                    <button type="submit" class="btn btn-success btn-sm">Devolver</button>
                </form>
            @endif

            <a href="{{ route('rentals.index') }}" class="btn btn-primary">Voltar</a>
        </div>
    </div>
</div>
@endsection
