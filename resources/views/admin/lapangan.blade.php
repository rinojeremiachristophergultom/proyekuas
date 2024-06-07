@extends('layout.admin')

@section('title', 'Lapangan')

@section('button-side')

    <button data-toggle="modal" data-target="#lapanganModal" class="d-sm-inline-block btn btn-sm btn-dark shadow-sm ml-2">
        <i class="fas fa-pen-square fa-sm text-white-50"></i> Tambah Lapangan
    </button>

@endsection

@section('sidebar-toggled', 'sidebar-toggled')
@section('toggled', 'toggled')

@section('active-lapangan', 'active')

@section('header', 'Lapangan')

@section('content')

    @if (session('message_success'))
        <div class="alert alert-success alert-dismissible show fade">
            <div class="alert-body">
                <button class="close" data-dismiss="alert">
                    <span>x</span>
                </button>
                {{ session('message_success') }}
            </div>
        </div>
    @endif
    
    @if (session('message_fail'))
        <div class="alert alert-danger alert-dismissible show fade">
            <div class="alert-body">
                <button class="close" data-dismiss="alert">
                    <span>x</span>
                </button>
                {{ session('message_fail') }}
            </div>
        </div>
    @endif

    @foreach ($errors->all() as $error)
        <div class="alert alert-danger alert-dismissible show fade">
            <div class="alert-body">
                <button class="close" data-dismiss="alert">
                    <span>x</span>
                </button>
                {{ $error }}
            </div>
        </div>
    @endforeach

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Keterangan</th>
                            <th>Harga Siang / Jam</th>
                            <th>Harga Malam / Jam</th>
                            <th>Foto 1</th>
                            <th>Foto 2</th>
                            <th>Foto 3</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Namaaa</th>
                            <th>Keterangan</th>
                            <th>Harga Siang / Jam</th>
                            <th>Harga Malam / Jam</th>
                            <th>Foto 1</th>
                            <th>Foto 2</th>
                            <th>Foto 3</th>
                            <th>Aksi</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($lapangan as $row)
                            <tr>
                                <td>{{ $row->lapangan_id }}</td>
                                <td>{{ $row->nama }}</td> 
                                <td>{{ $row->keterangan }}</td> 
                                <td>Rp. {{ number_format($row->harga_siang) }}</td> 
                                <td>Rp. {{ number_format($row->harga_malam) }}</td> 
                                <td>
                                    <a onclick="image1(this)" data-toggle="modal" data-image="{{ $row->foto1 }}" href="#imageModal">
                                        <img style="width: 50px; height: 30px;" src="{{ asset($row->foto1) }}" alt="{{ asset($row->foto1) }}">
                                    </a>
                                </td> 
                                <td>
                                    @if ($row->foto2 != Null)
                                        <a onclick="image2(this)" data-toggle="modal" data-image="{{ $row->foto2 }}" href="#imageModal">
                                            <img style="width: 50px; height: 30px;" src="{{ asset($row->foto2) }}" alt="{{ asset($row->foto2) }}">
                                        </a>
                                    @endif
                                </td> 
                                <td>
                                    @if ($row->foto3 != Null)
                                        <a onclick="image3(this)" data-toggle="modal" data-image="{{ $row->foto3 }}" href="#imageModal">
                                            <img style="width: 50px; height: 30px;" src="{{ asset($row->foto3) }}" alt="{{ asset($row->foto3) }}">
                                        </a>
                                    @endif
                                </td> 
                                <td>
                                    <a href="#lapanganEditModal" data-toggle="modal" class="btn btn-info btn-circle btn-sm edit" data-id="{{ $row->id }}" data-lapangan_id="{{ $row->lapangan_id }}" data-nama="{{ $row->nama }}" data-keterangan="{{ $row->keterangan }}" data-harga_siang="Rp. {{ number_format($row->harga_siang) }}" data-harga_malam="Rp. {{ number_format($row->harga_malam) }}">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <a href="#" class="btn btn-danger btn-circle btn-sm delete" data-id="{{ $row->id }}">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                    <form action="{{ route('admin.lapangan.delete', [$row->lapangan_id]) }}" method="POST" id="delete-form{{ $row->id }}">
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
    <div class="modal fade" id="lapanganModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Lapangan</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.lapangan.store') }}" id="div-container" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-3 row">
                            <label for="nama_lapangan" class="col-sm-4 col-form-label">Nama Lapangan</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control @error('nama_lapangan') is-invalid @enderror" id="nama_lapangan" name="nama_lapangan" value="{{ old('nama_lapangan') }}">
                                @error('nama_lapangan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="keterangan" class="col-sm-4 col-form-label">Keterangan</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control @error('keterangan') is-invalid @enderror" id="keterangan" name="keterangan" value="{{ old('keterangan') }}">
                                @error('keterangan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="harga_siang" class="col-sm-4 col-form-label">Harga Siang / Jam</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control @error('harga_siang') is-invalid @enderror" id="harga_siang" name="harga_siang" value="{{ old('harga_siang') }}">
                                @error('harga_siang')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="harga_malam" class="col-sm-4 col-form-label">Harga Malam / Jam</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control @error('harga_malam') is-invalid @enderror" id="harga_malam" name="harga_malam" value="{{ old('harga_malam') }}">
                                @error('harga_malam')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="foto1" class="col-sm-4 col-form-label">Foto 1</label>
                            <div class="col-sm-8">
                                <input type="file" id="foto1" class="@error('foto1') is-invalid @enderror" name="foto1" value="">
                                @error('foto1')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="foto2" class="col-sm-4 col-form-label">Foto 2</label>
                            <div class="col-sm-8">
                                <input type="file" id="foto2" class="@error('foto2') is-invalid @enderror" name="foto2" value="">
                                @error('foto2')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="foto3" class="col-sm-4 col-form-label">Foto 3</label>
                            <div class="col-sm-8">
                                <input type="file" id="foto3" class="@error('foto3') is-invalid @enderror" name="foto3" value="">
                                @error('foto3')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="{{ route('admin.lapangan.store') }}" onclick="event.preventDefault(); document.getElementById('div-container').submit();">Create</a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Edit Lapangan Modal-->
    <div class="modal fade" id="lapanganEditModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Lapangan</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.lapangan.edit') }}" id="edit-form" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method("PATCH")
                        <input type="text" class="form-control" id="lapangan_id" name="lapangan_id" value="{{ old('nama_lapangan') }}" style="display: none !important;">
                        <div class="mb-3 row">
                            <label for="edit_nama" class="col-sm-4 col-form-label">Nama Lapangan</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control @error('edit_nama') is-invalid @enderror" id="edit_nama" name="edit_nama" value="{{ old('edit_nama') }}">
                                @error('edit_nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="edit_keterangan" class="col-sm-4 col-form-label">Keterangan</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control @error('edit_keterangan') is-invalid @enderror" id="edit_keterangan" name="edit_keterangan" value="{{ old('edit_keterangan') }}">
                                @error('edit_keterangan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="edit_harga_siang" class="col-sm-4 col-form-label">Harga Siang / Jam</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control @error('edit_harga_siang') is-invalid @enderror" id="edit_harga_siang" name="edit_harga_siang" value="{{ old('edit_harga_siang') }}">
                                @error('edit_harga_siang')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="edit_harga_malam" class="col-sm-4 col-form-label">Harga Malam / Jam</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control @error('edit_harga_malam') is-invalid @enderror" id="edit_harga_malam" name="edit_harga_malam" value="{{ old('edit_harga_malam') }}">
                                @error('edit_harga_malam')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="edit_foto1" class="col-sm-4 col-form-label">Foto 1</label>
                            <div class="col-sm-8">
                                <input type="file" id="edit_foto1" class="@error('edit_foto1') is-invalid @enderror" name="edit_foto1" value="">
                                @error('edit_foto1')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="edit_foto2" class="col-sm-4 col-form-label">Foto 2</label>
                            <div class="col-sm-8">
                                <input type="file" id="edit_foto2" class="@error('edit_foto2') is-invalid @enderror" name="edit_foto2" value="">
                                @error('edit_foto2')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="edit_foto3" class="col-sm-4 col-form-label">Foto 3</label>
                            <div class="col-sm-8">
                                <input type="file" id="edit_foto3" class="@error('edit_foto3') is-invalid @enderror" name="edit_foto3" value="">
                                @error('edit_foto3')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="{{ route('admin.lapangan.edit') }}" onclick="event.preventDefault(); document.getElementById('edit-form').submit();">Create</a>
                </div>
            </div>
        </div>
    </div>

    {{-- View Image --}}
    <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Foto Lapangan</h5>
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

@endsection

@section('js')

    <script type="text/javascript">
    
        // Call the dataTables jQuery plugin
        $(document).ready(function() {
            $('#dataTable').DataTable();
        });

        $(".edit").click(function () {
            var lapangan_id = $(this).data('lapangan_id')
            var nama = $(this).data('nama')
            var keterangan = $(this).data('keterangan')
            var harga_siang = $(this).data('harga_siang')
            var harga_malam = $(this).data('harga_malam')



            $('#lapangan_id').val(lapangan_id)
            $('#edit_nama').val(nama)
            $('#edit_keterangan').val(keterangan)
            $('#edit_harga_siang').val(harga_siang.replace(',', '.'))
            $('#edit_harga_malam').val(harga_malam.replace(',', '.'))
        })

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

        function image2(d) {
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

        function image3(d) {
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

        var rupiah1 = document.getElementById('harga_siang');
        rupiah1.addEventListener('keyup', function(e){
            // tambahkan 'Rp.' pada saat form di ketik
            // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
            rupiah1.value = formatRupiah(this.value, 'Rp. ');
        });

        /* Fungsi formatRupiah */
        function formatRupiah(angka, prefix){
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split   		= number_string.split(','),
            sisa     		= split[0].length % 3,
            rupiah1     		= split[0].substr(0, sisa),
            ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);

            // tambahkan titik jika yang di input sudah menjadi angka ribuan
            if(ribuan){
                separator = sisa ? '.' : '';
                rupiah1 += separator + ribuan.join('.');
            }

            rupiah1 = split[1] != undefined ? rupiah1 + ',' + split[1] : rupiah1;
            return prefix == undefined ? rupiah1 : (rupiah1 ? 'Rp. ' + rupiah1 : '');
        }

        var rupiah2= document.getElementById('harga_malam');
        rupiah2.addEventListener('keyup', function(e){
            // tambahkan 'Rp.' pada saat form di ketik
            // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
            rupiah2.value = formatRupiah(this.value, 'Rp. ');
        });

        /* Fungsi formatRupiah */
        function formatRupiah(angka, prefix){
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split   		= number_string.split(','),
            sisa     		= split[0].length % 3,
            rupiah2     		= split[0].substr(0, sisa),
            ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);

            // tambahkan titik jika yang di input sudah menjadi angka ribuan
            if(ribuan){
                separator = sisa ? '.' : '';
                rupiah2 += separator + ribuan.join('.');
            }

            rupiah2 = split[1] != undefined ? rupiah2 + ',' + split[1] : rupiah2;
            return prefix == undefined ? rupiah2 : (rupiah2 ? 'Rp. ' + rupiah2 : '');
        }

        var rupiah3 = document.getElementById('edit_harga_siang');
        rupiah3.addEventListener('keyup', function(e){
            // tambahkan 'Rp.' pada saat form di ketik
            // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
            rupiah3.value = formatRupiah(this.value, 'Rp. ');
        });

        /* Fungsi formatRupiah */
        function formatRupiah(angka, prefix){
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split   		= number_string.split(','),
            sisa     		= split[0].length % 3,
            rupiah3     		= split[0].substr(0, sisa),
            ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);

            // tambahkan titik jika yang di input sudah menjadi angka ribuan
            if(ribuan){
                separator = sisa ? '.' : '';
                rupiah3 += separator + ribuan.join('.');
            }

            rupiah3 = split[1] != undefined ? rupiah3 + ',' + split[1] : rupiah3;
            return prefix == undefined ? rupiah3 : (rupiah3 ? 'Rp. ' + rupiah3 : '');
        }

        var rupiah4= document.getElementById('edit_harga_malam');
        rupiah4.addEventListener('keyup', function(e){
            // tambahkan 'Rp.' pada saat form di ketik
            // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
            rupiah4.value = formatRupiah(this.value, 'Rp. ');
        });

        /* Fungsi formatRupiah */
        function formatRupiah(angka, prefix){
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split   		= number_string.split(','),
            sisa     		= split[0].length % 3,
            rupiah4     		= split[0].substr(0, sisa),
            ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);

            // tambahkan titik jika yang di input sudah menjadi angka ribuan
            if(ribuan){
                separator = sisa ? '.' : '';
                rupiah4 += separator + ribuan.join('.');
            }

            rupiah4 = split[1] != undefined ? rupiah4 + ',' + split[1] : rupiah4;
            return prefix == undefined ? rupiah4 : (rupiah4 ? 'Rp. ' + rupiah4 : '');
        }
    </script>

@endsection