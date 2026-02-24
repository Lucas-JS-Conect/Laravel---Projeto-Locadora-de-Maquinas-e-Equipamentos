@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detalhes do Usuário</h1>

    <div class="card">
        <div class="card-header">
            {{ $user->name }}
        </div>
        <div class="card-body">
            <p><strong>ID:</strong> {{ $user->id }}</p>
            <p><strong>Nome:</strong> {{ $user->name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
        </div>
    </div>

    <a href="{{ route('users.index') }}" class="btn btn-primary mt-3">Voltar</a>
</div>
@endsection
