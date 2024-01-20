@extends('app.layouts.base')

@section('content')
    <div class="col-12">
        <h4>Lista de usuários</h4>
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
                },
                error: (error) => {
                }
            });
        });
    </script>
@endsection
