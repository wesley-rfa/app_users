@extends('app.layouts.base')

@section('content')
    <div class="col-12 m-0 p-0">
        <h4>Novo Usuário</h4>
        <hr>
    </div>

    <form class="row g-3 needs-validation" action="{{ route('users.store') }}" method="post">
        @csrf
        <div class="col-md-5 mb-3">
            <label class="form-label">Nome</label>
            <input type="text" class="form-control form-control-sm" name="name">
            <div class="invalid_feedback"></div>
        </div>
        <div class="col-md-5 mb-3">
            <label class="form-label">E-mail</label>
            <input type="text" class="form-control form-control-sm" name="email">
            <div class="invalid_feedback"></div>
        </div>
        <div class="col-md-5 mb-3">
            <label class="form-label">Senha</label>
            <input type="password" class="form-control form-control-sm" name="password">
            <div class="invalid_feedback"></div>
        </div>
        <div class="col-md-5 mb-3">
            <label class="form-label">Confirmação de Senha</label>
            <input type="password" class="form-control form-control-sm" name="password_verify">
            <div class="invalid_feedback"></div>
        </div>
        <div class="col-10 text-center">
            <button type="submit" class="btn btn_primary">Salvar</button>
        </div>
    </form>
@endsection
