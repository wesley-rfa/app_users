@extends('app.layouts.base')

@section('content')
    <div class="col-12">
        <h4>Detalhes do usuário</h4>
    </div>

    <ul class="col-6 list-group list-group-flush mt-4">
        <li class="list-group-item">Nome:</li>
        <li class="list-group-item">E-mail:</li>
    </ul>

    <form class="row g-3 needs-validation" method="POST">
        <div class="col-12 text-center">
            <button type="submit" class="btn btn_primary">Excluir usuário</button>
        </div>
    </form>
@endsection
