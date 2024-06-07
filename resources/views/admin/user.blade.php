@extends('layout.admin')

@section('title', 'User')

@section('sidebar-toggled', 'sidebar-toggled')
@section('toggled', 'toggled')

@section('active-user', 'active')

@section('header', 'User')

@section('content')

    @if (session('message_success'))
    <div class="alert alert-success alert-dismissible show fade">
        <div class="alert-body">
            <button class="close" data-dismiss="alert">
                <span></span>
            </button>
            {{ session('message_success') }}
        </div>
    </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID User</th>
                            <th>Nama</th>
                            <th>Username</th>
                            <th>Nomer Handphone</th>
                            <th>Jenis Kelamin</th>
                            <th>Email</th>
                            <th>Alamat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>ID User</th>
                            <th>Nama</th>
                            <th>Username</th>
                            <th>Nomer Handphone</th>
                            <th>Jenis Kelamin</th>
                            <th>Email</th>
                            <th>Alamat</th>
                            <th>Aksi</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($user as $row)
                            <tr>
                                <td>{{ $row->user_id }}</td>
                                <td>{{ $row->name }}</td>
                                <td>{{ $row->username }}</td>
                                <td>{{ $row->no_hp }}</td>
                                <td>{{ $row->jk }}</td>
                                <td>{{ $row->email }}</td>
                                <td>{{ $row->alamat }}</td>
                                <td>
                                    <a href="#" class="btn btn-danger btn-circle btn-sm delete" data-id="{{ $row->id }}">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                    <form action="{{ route('admin.user.delete', [$row->id]) }}" id="delete-form{{ $row->id }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('js')

    <script>
        // Call the dataTables jQuery plugin
        $(document).ready(function() {
            $('#dataTable').DataTable();
        });
        
        $(".delete").click(function () {
            var id = $(this).data('id')

            swal({
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    swal("berhasil!", {
                        icon: "success",
                    });
                    $("#delete-form" + id).submit();
                }
            });
        })
    </script>

@endsection