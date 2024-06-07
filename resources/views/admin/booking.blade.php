@extends('layout.admin')

@section('title', 'Booking')

{{-- @section('button-side')

    <button data-toggle="modal" data-target="#rekeningModal" class="d-sm-inline-block btn btn-sm btn-dark shadow-sm ml-2">
        <i class="fas fa-credit-card fa-sm text-white-50"></i> Rekening Transfer
    </button>

@endsection --}}

@section('sidebar-toggled', 'sidebar-toggled')
@section('toggled', 'toggled')

@section('active-booking', 'active')

@section('header', 'Booking')

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
                            <th>ID Booking</th>
                            <th>ID Lapangan</th>
                            <th>ID User</th>
                            <th>Jam Pesan</th>
                            <th>Tanggal Main</th>
                            <th>Lama Main</th>
                            <th>Jam Mulai</th>
                            <th>Jam Selesai</th>
                            <th>Harga / Jam</th>
                            <th>Total Harga</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>ID Booking</th>
                            <th>ID Lapangan</th>
                            <th>ID User</th>
                            <th>Jam Pesan</th>
                            <th>Tanggal Main</th>
                            <th>Lama Main</th>
                            <th>Jam Mulai</th>
                            <th>Jam Selesai</th>
                            <th>Harga / Jam</th>
                            <th>Total Harga</th>
                            <th>Status</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($user_booking as $row)
                            <tr>
                                <td>{{ $row->booking_id }}</td>
                                <td>{{ $row->lapangan_id }}</td>
                                <td>{{ $row->user_id }}</td>
                                <td>{{ date('Y-m-d', strtotime($row->created_at)) }}</td>
                                <td>{{ $row->tanggal }}</td>
                                <td>{{ $row->lama_mulai }}</td>
                                <td>{{ $row->jam_mulai }}</td>
                                <td>{{ $row->jam_habis }}</td>
                                <td>{{ number_format($row->harga_lapangan) }}</td>
                                <td>{{ number_format($row->total) }}</td>
                                <td>{{ $row->status }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- View Image --}}
    <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Bukti Pembayaran</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body" id="image-container">

                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                </div>
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
                    @php
                        $rekening_check = collect(DB::select('select * from rekenings'));
                        $rekening = $rekening_check->count();
                        $rekening_data = $rekening_check->first();
                    @endphp
                    @if ($rekening == 0)        
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
                    @else
                        <form action="{{ route('admin.rekening.edit') }}" id="div-container" method="POST" enctype="multipart/form-data">
                            @csrf

                            @method('PATCH')
                            
                            <input type="text" style="display: none" value="{{ $rekening_data->id }}" class="form-control @error('id') is-invalid @enderror" id="id" name="id">
                            <div class="mb-3 row">
                                <label for="nama_rekening" class="col-sm-4 col-form-label">Nama Rekening</label>
                                <div class="col-sm-8">
                                    <input type="text" value="{{ $rekening_data->nama_rekening }}" class="form-control @error('nama_rekening') is-invalid @enderror" id="nama_rekening" name="nama_rekening">
                                    @error('nama_rekening')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="nomer_rekening" class="col-sm-4 col-form-label">Nomer Rekening</label>
                                <div class="col-sm-8">
                                    <input type="text" value="{{ $rekening_data->nomer_rekening }}" class="form-control @error('nomer_rekening') is-invalid @enderror" id="nomer_rekening" name="nomer_rekening" >
                                    @error('nomer_rekening')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </form>
                    @endif
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    @if ($rekening == 0)
                        <a class="btn btn-primary" href="{{ route('admin.rekening.store') }}" onclick="event.preventDefault(); document.getElementById('div-container').submit();">Create</a>
                    @else
                        <a class="btn btn-primary" href="{{ route('admin.rekening.edit') }}" onclick="event.preventDefault(); document.getElementById('div-container').submit();">Update</a>    
                    @endif
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

        $(".warning").click(function () {
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
                    $("#warning-form" + id).submit();
                }
            });
        })
        
        $(".success").click(function () {
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
                    $("#success-form" + id).submit();
                }
            });
        })

        function image1(d) {
            const imageTag = document.querySelectorAll('.ImageTag');

            if (imageTag) {
                imageTag.forEach(el => el.remove());
            }

            var imageUrl = d.getAttribute('data-image')

            const DivContainer = document.getElementById('image-container');
            const newDiv1 = document.createElement('img');

            newDiv1.setAttribute('class', 'mr-1 mb-1 ImageTag');
            newDiv1.setAttribute('src', '/' + imageUrl);
            newDiv1.setAttribute('style', 'width: 450px; height: 350px;');

            DivContainer.appendChild(newDiv1);
        }
    </script>

@endsection