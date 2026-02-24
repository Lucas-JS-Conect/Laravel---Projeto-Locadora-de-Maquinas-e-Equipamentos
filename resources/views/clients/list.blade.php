@extends('layouts.main')

@section('title', 'Lista de Clientes')

@section('content')

<div class="col-md-10 offset-md-1 dashboard-clients-container">
    <h1>Clientes</h1>

    @if(count($clients) > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>CPF/CNPJ</th>
                    <th>Telefone</th>
                    <th>Data de Nascimento</th>
                    <th>Sexo</th>
                    <th>Endereço</th>
                    <th>Ocupação</th>
                    <th>Usuário</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($clients as $client)
                    <tr>
                        <td>{{ $client->name }}</td>
                        <td>{{ $client->email }}</td>
                        <td>{{ $client->cpf_cnpj }}</td>
                        <td>{{ $client->phone }}</td>
                        <td>{{ \Carbon\Carbon::parse($client->birth_date)->format('d/m/Y') }}</td>
                        <td>{{ $client->gender }}</td>
                        <td>{{ $client->address }}</td>
                        <td>{{ $client->occupation }}</td>
                        <td>{{ $client->user->name }}</td>
                        <td>
                            <a href="{{ route('clients.edit', ['client' => $client->id]) }}" class="btn btn-info edit-btn">Editar</a>
                            <form action="{{ route('clients.destroy', ['client' => $client->id]) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger delete-btn">Deletar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Não há clientes cadastrados.</p>
    @endif

    <a href="{{ route('clients.create') }}" class="btn btn-primary">Cadastrar Cliente</a>
    <a href="{{ route('agendamentos.create') }}" class="btn btn-success">Agendar Atendimento</a>
    <a href="{{ route('home') }}" class="btn btn-secondary mt-2">Voltar</a>

</div>

@endsection
