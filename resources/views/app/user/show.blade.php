@extends('app.layouts.base')

@section('content')
    <div class="col-12">
        <h4>Detalhes do usuário</h4>
        <hr>
    </div>

    <div class="row mt-1">
        <div class="col-6">
            <div><strong>Nome:</strong> <span id="span-user-name"></span></div>
            <div><strong>E-mail:</strong> <span id="span-user-email"></div>
            <div><strong>Criado em:</strong> <span id="span-user-created-at"></div>
        </div>
    </div>
    
    <div class="d-flex flex-row bd-highlight mt-5 justify-content-center">
        <a class="btn btn-sm btn_primary col-2 mx-3" href="{{ route('users.index') }}">Voltar</a>
        <button id="button-delete-user" class="btn btn-sm btn_primary col-2">Excluir usuário</button>
      </div>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            $.ajax({
                type: "GET",
                contentType: 'application/json',
                url: "/api/users/{{ $id }}",
                success: (response) => {
                    if (response.success) {
                        $('#span-user-name').html(response.data.name);
                        $('#span-user-email').html(response.data.email);
                        $('#span-user-created-at').html(response.data.createdAt);
                    } else {
                        $('#toast-body-message').html('Erro ao buscar usuário.');
                        $('.toast').toast('show')
                    }
                },
                error: (xhr, ajaxOptions, thrownError) => {
                    $('#toast-body-message').html(JSON.parse(xhr.responseText).data.errorMessage);
                    $('.toast').toast('show')
                }
            });

            $('#button-delete-user').click((e) => {
                $.ajax({
                    type: "DELETE",
                    contentType: 'application/json',
                    url: "/api/users/{{ $id }}",
                    success: (response) => {
                        window.location.href = "{{ route('users.index') }}";
                    },
                    error: (xhr, ajaxOptions, thrownError) => {
                        $('#toast-body-message').html(JSON.parse(xhr.responseText).data.errorMessage);
                        $('.toast').toast('show');
                    }
                });
            })
        });
    </script>
@endsection
