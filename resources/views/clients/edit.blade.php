@extends('layouts.main')

@section('title', 'Editar Cliente')

@section('content')

<div id="client-edit-container" class="col-md-6 offset-md-3">
    <h1>Editando: {{ $client->name }}</h1>
    <form action="{{ route('clients.update', ['client' => $client->id]) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Nome:</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $client->name }}">
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ $client->email }}">
        </div>

        <div class="form-group">
            <label for="cpf_cnpj">CPF/CNPJ:</label>
            <input type="text" class="form-control" id="cpf_cnpj" name="cpf_cnpj" value="{{ $client->cpf_cnpj }}">
        </div>

        <div class="form-group">
            <label for="phone">Telefone:</label>
            <input type="text" class="form-control" id="phone" name="phone" value="{{ $client->phone }}">
        </div>

        <div class="form-group">
            <label for="birth_date">Data de Nascimento:</label>
            <input type="date" class="form-control" id="birth_date" name="birth_date" value="{{ $client->birth_date }}">
        </div>

        <div class="form-group">
            <label for="gender">Sexo:</label>
            <div>
                <input type="radio" id="male" name="gender" value="male" {{ $client->gender == 'male' ? 'checked' : '' }}>
                <label for="male">Masculino</label>
                <input type="radio" id="female" name="gender" value="female" {{ $client->gender == 'female' ? 'checked' : '' }}>
                <label for="female">Feminino</label>
            </div>
        </div>

        <div class="form-group">
            <label for="address">Endereço:</label>
            <input type="text" class="form-control" id="address" name="address" value="{{ $client->address }}">
        </div>

        <div class="form-group">
            <label for="occupation">Ocupação:</label>
            <input type="text" class="form-control" id="occupation" name="occupation" value="{{ $client->occupation }}">
        </div>

        <button type="submit" class="btn btn-primary">Salvar</button>
    </form>
    <a href="{{ route('clients.index') }}" class="btn btn-secondary mt-2">Voltar</a>
</div>

@endsection
