@extends('layout.admin')

@section('title', 'Rekening')

@section('button-side')

    <button data-toggle="modal" data-target="#rekeningModal" class="d-sm-inline-block btn btn-sm btn-dark shadow-sm ml-2">
        <i class="fas fa-credit-card fa-sm text-white-50"></i> Buat Rekening
    </button>

@endsection

@section('sidebar-toggled', 'sidebar-toggled')
@section('toggled', 'toggled')

@section('active-rekening', 'active')

@section('header', 'Rekening')

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
                            <th>Nomer Rekening</th>
                            <th>Nama Rekening</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Nomer Rekening</th>
                            <th>Nama Rekening</th>
                            <th>Aksi</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($rekening as $row)
                            <tr>
                                <td>{{ $row->nomer_rekening }}</td>
                                <td>{{ $row->nama_rekening }}</td>
                                <td>
                                    <a href="#" class="btn btn-danger btn-circle btn-sm delete" data-id="{{ $row->id }}">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                    <form action="{{ route('admin.rekening.delete', [$row->id]) }}" method="POST" id="delete-form{{$row->id}}">
                                        @csrf
                                        @method('PATCH')
                                    </form>
                                    <a data-toggle="modal" data-target="#rekeningEditModal" id="edit" class="btn btn-info btn-circle btn-sm edit" data-id="{{ $row->id }}" data-nomer_rekening="{{ $row->nomer_rekening }}" data-nama_rekening="{{ $row->nama_rekening }}">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <form action="{{ route('admin.rekening.edit', [$row->id]) }}" id="edit-form{{ $row->id }}" method="POST">
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

    <!-- Tambah Lapangan Modal-->
    <div class="modal fade" id="rekeningModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Rekening Transfer</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">      
                        <form action="{{ route('admin.rekening.store') }}" id="div-container" method="POST" enctype="multipart/form-data">
                            @csrf
                            
                            <div class="mb-3 row">
                                <label for="nama_rekening" class="col-sm-4 col-form-label">Nama Rekening</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control @error('nama_rekening') is-invalid @enderror" id="nama_rekening" name="nama_rekening" value="{{ old('nama_rekening') }}">
                                    @error('nama_rekening')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="nomer_rekening" class="col-sm-4 col-form-label">Nomer Rekening</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control @error('nomer_rekening') is-invalid @enderror" id="nomer_rekening" name="nomer_rekening" value="{{ old('nomer_rekening') }}">
                                    @error('nomer_rekening')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="{{ route('admin.rekening.store') }}" onclick="event.preventDefault(); document.getElementById('div-container').submit();">Buat</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Tambah Lapangan Modal-->
    <div class="modal fade" id="rekeningEditModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ubah Rekening</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">      
                        <form action="{{ route('admin.rekening.edit') }}" id="div-container-edit" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <input type="text" class="form-control @error('id_rekening') is-invalid @enderror" id="id_rekening" name="id_rekening" value="{{ old('id_rekening') }}" hidden>
                            <div class="mb-3 row">
                                <label for="nama_rekening1" class="col-sm-4 col-form-label">Nama Rekening</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control @error('nama_rekening1') is-invalid @enderror" id="nama_rekening1" name="nama_rekening1" value="{{ old('nama_rekening1') }}">
                                    @error('nama_rekening1')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="nomer_rekening1" class="col-sm-4 col-form-label">Nomer Rekening</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control @error('nomer_rekening1') is-invalid @enderror" id="nomer_rekening1" name="nomer_rekening1" value="{{ old('nomer_rekening1') }}">
                                    @error('nomer_rekening1')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="{{ route('admin.rekening.edit') }}" onclick="event.preventDefault(); document.getElementById('div-container-edit').submit();">Update</a> 
                </div>
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

        $(document).on('click', '#edit', function () {
			var id = $(this).data('id')
			var nomer_rekening = $(this).data('nomer_rekening')
			var nama_rekening = $(this).data('nama_rekening')

			$('#id_rekening').val(id)
			$('#nomer_rekening1').val(nomer_rekening)
			$('#nama_rekening1').val(nama_rekening)
		})
    </script>

@endsection