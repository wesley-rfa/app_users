@extends('app.layouts.base')

@section('content')
    <div class="col-12 m-0 p-0">
        <h4>Editar Usuário</h4>
        <hr>
    </div>

    <form id="form-update-user" class="row g-3 needs-validation" method="POST">
        <div class="col-md-5 mb-3">
            <label class="form-label">Nome</label>
            <input type="text" class="form-control form-control-sm" name="name">
            <div id="invalid-feedback-name" class="invalid_feedback"></div>
        </div>
        <div class="col-md-5 mb-3">
            <label class="form-label">E-mail</label>
            <input type="email" class="form-control form-control-sm" name="email">
            <div id="invalid-feedback-email" class="invalid_feedback"></div>
        </div>
        <div class="col-10 text-center">
            <button type="submit" class="btn btn_primary">Salvar</button>
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
                        $('[name="name"]').val(response.data.name);
                        $('[name="email"]').val(response.data.email);
                    } else {
                        $('#toast-body-message').html('Erro ao buscar tentar excluir usuário.');
                        $('.toast').toast('show')
                    }
                },
                error: (xhr, ajaxOptions, thrownError) => {
                    $('#toast-body-message').html(JSON.parse(xhr.responseText).data.errorMessage);
                    $('.toast').toast('show')
                }
            });

            $('#form-update-user').submit((e) => {
                e.preventDefault();
                $.ajax({
                    type: "PUT",
                    contentType: 'application/json',
                    url: "/api/users/{{ $id }}",
                    data: JSON.stringify({
                        name: $('[name="name"]').val(),
                        email: $('[name="email"]').val(),
                    }),
                    success: (response) => {
                        if (response.success) {
                            window.location.href = "{{ route('users.index') }}";
                        } else {
                            $('#toast-body-message').html("Erro ao tentar editar usuário.");
                            $('.toast').toast('show');
                        }
                    },
                    error: (xhr, ajaxOptions, thrownError) => {
                        let responseError = JSON.parse(xhr.responseText);
                        if (responseError.data.errorCode == 1) {
                            if (!(responseError.data.errorList.name === undefined)) {
                                let nameErrors = "";
                                $.each(responseError.data.errorList.name, function(index,
                                error) {
                                    nameErrors += `${error}<br>`;
                                })
                                $('#invalid-feedback-name').html(nameErrors);
                            } else {
                                $('#invalid-feedback-name').html('');
                            }

                            if (!(responseError.data.errorList.email === undefined)) {
                                let emailErrors = "";
                                $.each(responseError.data.errorList.email, function(index,
                                    error) {
                                    emailErrors += `${error}<br>`;
                                })
                                $('#invalid-feedback-email').html(emailErrors);
                            } else {
                                $('#invalid-feedback-email').html('');
                            }
                        }

                        $('#toast-body-message').html(JSON.parse(xhr.responseText).data
                            .errorMessage);
                        $('.toast').toast('show');
                    }
                });
            })
        });
    </script>
@endsection
