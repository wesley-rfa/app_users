@extends('app.layouts.base')

@section('content')
    <div class="col-12 m-0 p-0">
        <h4>Novo Usuário</h4>
        <hr>
    </div>

    <form id="form-store-user" class="row g-3 needs-validation" method="POST">
        <div class="col-md-5 mb-3">
            <label class="form-label">Nome*</label>
            <input type="text" class="form-control form-control-sm" name="name">
            <div id="invalid-feedback-name" class="invalid_feedback"></div>
        </div>
        <div class="col-md-5 mb-3">
            <label class="form-label">E-mail*</label>
            <input type="text" class="form-control form-control-sm" name="email">
            <div id="invalid-feedback-email" class="invalid_feedback"></div>
        </div>
        <div class="col-md-5 mb-3">
            <label class="form-label">Senha*</label>
            <input type="password" class="form-control form-control-sm" name="password">
            <div id="invalid-feedback-password" class="invalid_feedback"></div>
        </div>
        <div class="col-md-5 mb-3">
            <label class="form-label">Confirmação de Senha*</label>
            <input type="password" class="form-control form-control-sm" name="password_confirmation">
            <div id="invalid-feedback-password-confirmation" class="invalid_feedback"></div>
        </div>
        <div class="col-10 text-center">
            <button type="submit" class="btn btn-sm btn_primary col-2">Salvar</button>
        </div>
    </form>
@endsection


@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#form-store-user').submit((e) => {
                e.preventDefault();
                $.ajax({
                    type: "POST",
                    contentType: 'application/json',
                    url: "/api/users",
                    data: JSON.stringify({
                        name: $('[name="name"]').val(),
                        email: $('[name="email"]').val(),
                        password: $('[name="password"]').val(),
                        passwordConfirmation: $('[name="password_confirmation"]').val(),
                    }),
                    success: (response) => {
                        if (response.success) {
                            window.location.href = "{{ route('users.index') }}";
                        } else {
                            $('#toast-body-message').html("Erro ao tentar criar usuário.");
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

                            if (!(responseError.data.errorList.password === undefined)) {
                                let passwordErrors = "";
                                $.each(responseError.data.errorList.password, function(index,
                                    error) {
                                    passwordErrors += `${error}<br>`;
                                })
                                $('#invalid-feedback-password').html(passwordErrors);
                            } else {
                                $('#invalid-feedback-password').html('');
                            }

                            if (!(responseError.data.errorList.passwordConfirmation === undefined)) {
                                let passwordConfirmationErrors = "";
                                $.each(responseError.data.errorList.passwordConfirmation, function(index,
                                    error) {
                                        passwordConfirmationErrors += `${error}<br>`;
                                })
                                $('#invalid-feedback-password-confirmation').html(passwordConfirmationErrors);
                            } else {
                                $('#invalid-feedback-password-confirmation').html('');
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
