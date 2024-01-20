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

    <form id="form-delete-user" class="row g-3 needs-validation">
        @method('DELETE')
        <div class="col-12 text-center">
            <button type="submit" class="btn btn_primary">Excluir usuário</button>
        </div>
    </form>
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

            $('#form-delete-user').submit((e) => {
                e.preventDefault();
                $.ajax({
                    type: "DELETE",
                    contentType: 'application/json',
                    url: "/api/users/{{ $id }}",
                    success: (response) => {
                        window.location.href = "{{ route('users.index') }}";
                    },
                    error: (xhr, ajaxOptions, thrownError) => {
                        $('#toast-body-message').html(JSON.parse(xhr.responseText).data.errorMessage);
                        $('.toast').toast('show')
                    }
                });
            })
        });
    </script>
@endsection
