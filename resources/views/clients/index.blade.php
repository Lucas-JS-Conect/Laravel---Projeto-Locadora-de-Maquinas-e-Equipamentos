@extends('layouts.app')

@section('title', 'Lista de Clientes')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Lista de Clientes</h1>

            @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
            @endif

            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>CPF/CNPJ</th>
                        <th>Telefone</th>
                        <th>Data de Nascimento</th>
                        <th>Sexo</th>
                        <th>Endereço</th>
                        <th>Ocupação</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($clients as $client)
                    <tr>
                        <td>{{ $client->id }}</td>
                        <td>{{ $client->name }}</td>
                        <td>{{ $client->email }}</td>
                        <td>{{ $client->cpf_cnpj }}</td>
                        <td>{{ $client->phone }}</td>
                        <td>{{ \Carbon\Carbon::parse($client->birth_date)->format('d/m/Y') }}</td>
                        <td>{{ $client->gender }}</td>
                        <td>{{ $client->address }}</td>
                        <td>{{ $client->occupation }}</td>
                        <td>
                            <a href="{{ route('clients.show', ['client' => $client->id]) }}" class="btn btn-info btn-sm">Ver</a>
                            <a href="{{ route('clients.edit', ['client' => $client->id]) }}" class="btn btn-primary btn-sm">Editar</a>
                            <form action="{{ route('clients.destroy', ['client' => $client->id]) }}" method="POST" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja deletar?')">Deletar</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            @if(count($clients) == 0)
            <p>Não há clientes cadastrados.</p>
            @endif

            <div class="row">
                <div class="col-md-6">
                    <a href="{{ route('rentals.create') }}" class="btn btn-success btn-block">Realizar Locação</a>
                </div>
                <div class="col-md-6">
                    <a href="{{ route('clients.create') }}" class="btn btn-secondary btn-block mt-2">Voltar</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
