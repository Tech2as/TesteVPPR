@extends('layouts.auth')

@section('title', 'Cadastro')

@section('content')
    <h1>Cadastro</h1>

    @if ($errors->any())
        <div class="errors">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <label>Nome</label>
        <input type="text" name="name" value="{{ old('name') }}" required>

        <label>Email</label>
        <input type="email" name="email" value="{{ old('email') }}" required>

        <label>Senha</label>
        <input type="password" name="password" required>

        <label>Confirmar Senha</label>
        <input type="password" name="password_confirmation" required>

        <button type="submit">Criar conta</button>
    </form>

    <a class="link" href="{{ route('login') }}">
        Já tem conta? <strong>Entrar</strong>
    </a>
@endsection