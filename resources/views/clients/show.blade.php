@extends('layouts.main')

@section('title', 'Detalhes do Cliente')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h1>Detalhes do Cliente</h1>
            <div class="card">
                <div class="card-header">
                    {{ $client->name }}
                </div>
                <div class="card-body">
                    <p><strong>Email:</strong> {{ $client->email }}</p>
                    <p><strong>CPF/CNPJ:</strong> {{ $client->cpf_cnpj }}</p>
                    <p><strong>Telefone:</strong> {{ $client->phone }}</p>
                    <p><strong>Data de Nascimento:</strong> {{ \Carbon\Carbon::parse($client->birth_date)->format('d/m/Y') }}</p>
                    <p><strong>Sexo:</strong> {{ $client->gender }}</p>
                    <p><strong>Endereço:</strong> {{ $client->address }}</p>
                    <p><strong>Ocupação:</strong> {{ $client->occupation }}</p>
                    <p><strong>Usuário:</strong> {{ $client->user->name }}</p>
                </div>
            </div>
            <a href="{{ route('clients.edit', ['client' => $client->id]) }}" class="btn btn-primary mt-3">Editar</a>
            <a href="{{ route('clients.index') }}" class="btn btn-secondary mt-3">Voltar</a>
        </div>
    </div>
</div>
@endsection
