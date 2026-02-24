@extends('layouts.main')

@section('title', 'Cadastrar Cliente')

@section('content')

<div id="client-create-container" class="col-md-6 offset-md-3">
    <h1>Cadastre um Cliente</h1>

    <form action="{{ route('clients.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="name">Nome:</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Nome do Cliente">
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Email do Cliente">
        </div>

        <div class="form-group">
            <label for="cpf_cnpj">CPF/CNPJ:</label>
            <input type="text" class="form-control" id="cpf_cnpj" name="cpf_cnpj" placeholder="CPF/CNPJ">
        </div>

        <div class="form-group">
            <label for="phone">Telefone:</label>
            <input type="text" class="form-control" id="phone" name="phone" placeholder="Telefone">
        </div>

        <div class="form-group">
            <label for="birth_date">Data de Nascimento:</label>
            <input type="date" class="form-control" id="birth_date" name="birth_date">
        </div>

        <div class="form-group">
            <label for="gender">Sexo:</label><br>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" id="male" name="gender" value="male" required>
                <label class="form-check-label" for="male">Masculino</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" id="female" name="gender" value="female" required>
                <label class="form-check-label" for="female">Feminino</label>
            </div>

            <div class="form-group">
                <label for="address">Endereço:</label>
                <input type="text" class="form-control" id="address" name="address" placeholder="Endereço">
            </div>

            <div class="form-group">
                <label for="occupation">Ocupação:</label>
                <input type="text" class="form-control" id="occupation" name="occupation" placeholder="Ocupação">
            </div>

            <div class="form-group">
                <label for="user_id">Usuário:</label>
                <select class="form-control" id="user_id" name="user_id">
                    @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Salvar</button>
    </form>

    <a href="{{ route('clients.index') }}" class="btn btn-secondary mt-2">Voltar</a>

</div>

@endsection