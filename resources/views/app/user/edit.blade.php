@extends('app.layouts.base')

@section('content')
    <div class="col-12 m-0 p-0">
        <h4>Editar Usuário</h4>
    </div>

    <form class="row g-3 needs-validation" method="POST">
        <div class="col-md-5 mb-3">
            <label class="form-label">Nome</label>
            <input type="text" class="form-control form-control-sm" name="name">
            <div class="invalid_feedback"></div>
        </div>
        <div class="col-md-5 mb-3">
            <label class="form-label">E-mail</label>
            <input type="email" class="form-control form-control-sm" name="email">
            <div class="invalid_feedback"></div>
        </div>
        <div class="col-10 text-center">
            <button type="submit" class="btn btn_primary">Salvar</button>
        </div>
    </form>
@endsection
