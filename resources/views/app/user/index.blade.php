@extends('app.layouts.base')

@section('content')
    <div class="col-12">
        <h4>Lista de usuários</h4>
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
            <tbody id="tbody_list_users">
            </tbody>
        </table>
    </div>
    <div class="col-12 text-center">
        <h6>Total: <span id="span_count_users"></span></h6>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            $.ajax({
                method: "GET",
                contentType: 'application/json',
                url: "/api/users",
                success: (response) => {
                    let tbody = '';
                    if (response.success) {
                        if (response.data.length > 0) {
                            $.each(response.data, function(index, user) {
                                let showUserUrl = '{{ route('users.edit', ':id') }}';
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
                        $('#toast_body_message').html('Erro ao buscar lista de usuários.');
                        $('.toast').toast('show')
                    }
                    $('#tbody_list_users').html(tbody);
                    $('#span_count_users').html(response.data.length);
                },
                error: (error) => {
                    $('#toast_body_message').html('Erro ao buscar lista de usuários.');
                    $('.toast').toast('show')
                }
            });
        });
    </script>
@endsection
