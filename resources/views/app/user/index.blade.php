@extends('app.layouts.base')

@section('content')
    <div class="col-12">
        <h4>Lista de usuários</h4>
        <hr>
    </div>

    <div class="col-12">
        <table class="table table-hover table-sm">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>E-mail</th>
                    <th></th>
                </tr>
            </thead>
            <tbody id="tbody-list-users">
            </tbody>
        </table>
    </div>
    <div class="col-12 text-center">
        <h6>Total: <span id="span-count-users"></span></h6>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            $.ajax({
                type: "GET",
                contentType: 'application/json',
                url: "/api/users",
                success: (response) => {
                    let tbody = '';
                    if (response.success) {
                        if (response.data.length > 0) {
                            $.each(response.data, function(index, user) {
                                let showUserUrl = '{{ route('users.show', ':id') }}';
                                let editUserUrl = '{{ route('users.edit', ':id') }}';

                                showUserUrl = showUserUrl.replace(':id', user.id);
                                editUserUrl = editUserUrl.replace(':id', user.id);

                                tbody += `<tr>
                                        <td>${user.name}</td>
                                        <td>${user.email}</td>
                                        <td>
                                            <a href="${showUserUrl}">Ver</a>
                                            <a href="${editUserUrl}">Editar</a>
                                        </td>
                                    </tr>`;
                            });
                        } else {
                            tbody += `<tr>
                                        <td colspan="100">Nenhum usuário encontrado.</td>
                                      </tr>`;
                        }
                    } else {
                        tbody = `<tr>
                                    <td colspan="100">Erro.</td>
                                </tr>`;
                        $('#toast-body-message').html('Erro ao buscar lista de usuários.');
                        $('.toast').toast('show')
                    }
                    $('#tbody-list-users').html(tbody);
                    $('#span-count-users').html(response.data.length);
                },
                error: (xhr, ajaxOptions, thrownError) => {
                    $('#toast-body-message').html('Erro ao buscar lista de usuários.');
                    $('.toast').toast('show')
                }
            });
        });
    </script>
@endsection
