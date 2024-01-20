<div class="container-fluid">
    <div class="row flex-nowrap">
        <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 menu">
            <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
                <a href="{{ route('users.index') }}"
                    class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                    <span class="fs-5 d-none d-sm-inline">Gestão de Usuários</span>
                </a>
                <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start"
                    id="menu">
                    <li class="nav-item">
                        <a href="{{ route('users.index') }}" class="nav-link align-middle px-0">
                            <i class="fs-4 bi-house"></i> <span class="ms-1 d-none d-sm-inline">Início</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('users.create') }}" class="nav-link align-middle px-0">
                            <i class="fs-4 bi-people"></i> <span class="ms-1 d-none d-sm-inline">Novo usuário</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col p-4 content">
            <div class="row sub-content">
                @yield('content')

                <div aria-live="polite" data-delay="5000" aria-atomic="true" style="position: relative; min-height: 200px;">
                    <div class="toast" style="position: absolute; top: 0; right: 0;">
                        <div class="toast-header">
                            <strong class="mr-auto">Aviso</strong>
                        </div>
                        <div class="toast-body" id="toast-body-message">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
