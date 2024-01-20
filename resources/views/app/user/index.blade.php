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
                    <th width="40%">Nome</th>
                    <th width="40%">E-mail</th>
                    <th width="7%" class="text-center">Ver mais</th>
                    <th width="5%" class="text-center">Editar</th>
                    <th width="5%" class="text-center">Excluir</th>
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
            getUsers();
        });

        function getUsers() {
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
                                        <td class="text-center">
                                            <a href="${showUserUrl}" style="color: #1e293b;"><i class="bi bi-eye-fill" title="Ver usuário"></i></a>
                                        </td>
                                        <td class="text-center">
                                            <a href="${editUserUrl}" style="color: #1e293b;"><i class="bi bi-pencil-square" title="Editar usuário"></i></a>
                                        </td>
                                        <td class="text-center">
                                            <span onclick="deleteUser(${user.id})" style="color: #1e293b;"><i class="bi bi-trash" title="Excluir usuário"></i></span>
                                        </td>
                                    </tr>`;
                                });
                            } else {
                                tbody += `<tr>
                                            <td colspan="100" class="text-center">Nenhum usuário encontrado.</td>
                                        </tr>`;
                            }
                        } else {
                            tbody = `<tr>
                                        <td colspan="100" class="text-center">Erro.</td>
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
            }

        function deleteUser(id) {
                $.ajax({
                    type: "DELETE",
                    contentType: 'application/json',
                    url: `/api/users/${id}`,
                    success: (response) => {
                        $('#toast-body-message').html('Usuário excluído com sucesso.');
                        $('.toast').toast('show')
                        getUsers();
                    },
                    error: (xhr, ajaxOptions, thrownError) => {
                        $('#toast-body-message').html(JSON.parse(xhr.responseText).data.errorMessage);
                        $('.toast').toast('show');
                    }
                });
            }
    </script>
@endsection
