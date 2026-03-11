@extends('layouts.auth')

@section('title', 'Login')

@section('content')
    <h1>Login</h1>

    @if ($errors->any())
        <div class="errors">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <label>Email</label>
        <input type="email" name="email" value="{{ old('email') }}" required>

        <label>Senha</label>
        <input type="password" name="password" required>

        <button type="submit">Entrar</button>
    </form>

    <a class="link" href="">
        Não tem conta? <strong>Criar cadastro</strong>
    </a>
@endsection