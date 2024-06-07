@extends('layout.template')

@section('title', 'Basket Viladelima')

@section('header5', 'header5')

@section('active-booking', 'active')

@section('content')
    
    <!---->
	<div class="back">
		<h2>Pesan</h2>
	</div>
	<!---->
	<div class="container">
		<div class="contact" style="margin-bottom: 30px;">
			<div class="typrography">
				<h3>Pesan Lapangan</h3>
				@if (session('message_success'))
					<ol class="breadcrumb" style="background-color: green; color: #fff;">
						<li class="">{{ session('message_success') }}</li>
					</ol>
				@endif
				
				@if (session('message_fail'))
					<ol class="breadcrumb" style="background-color: #ff5d56; color: #fff;">
						<li class="">{{ session('message_fail') }}</li>
					</ol>
				@endif
				<div style="display: flex; justify-content: space-between; margin-top: 20px;">
					@foreach ($lapangan as $row)
						<div class="card" style="width: 350px; height: auto; box-shadow: 2px 2px 10px 1px #000;">
							<div class="card-body">
								<img src="{{ asset($row->foto1) }}" style="width: 100%; height: 200px;">

								<div style="padding: 10px;">
									<table>
										<tr>
											<td style="font-weight: 600;">ID</td>
											<td style="padding: 0 5px;">:</td>
											<td>{{ $row->lapangan_id }}</td>
										</tr>
										<tr>
											<td style="font-weight: 600;">Nama</td>
											<td style="padding: 0 5px;">:</td>
											<td>{{ $row->nama }}</td>
										</tr>
										<tr>
											<td style="font-weight: 600;">Keterangan</td>
											<td style="padding: 0 5px;">:</td>
											<td>{{ $row->keterangan }}</td>
										</tr>
										<tr>
											<td style="font-weight: 600;">Harga Siang / Jam</td>
											<td style="padding: 0 5px;">:</td>
											<td>Rp. {{ number_format($row->harga_siang) }}</td>
										</tr>
										<tr>
											<td style="font-weight: 600;">Harga Malam / Jam</td>
											<td style="padding: 0 5px;">:</td>
											<td>Rp. {{ number_format($row->harga_malam) }}</td>
										</tr>
									</table>

									<div style="padding: 25px 0 10px">
										<a data-toggle="modal" href="#pesanModal" id="pesan" data-lapangan_id="{{ $row->lapangan_id }}" data-nama="{{ $row->nama }}" data-harga_siang="{{ $row->harga_siang }}" data-harga_malam="{{ $row->harga_malam }}"><span style="padding: 10px 30px !important;" class="label label-primary">Pesan</span></a>
									</div>
								</div>
							</div>
						</div>
					@endforeach
				</div>
				{{-- <div class="bs-docs-example">
					<table class="table table-striped">
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
										<a href="{{ route('booking.jadwal', [$row->lapangan_id]) }}"><span class="label label-default">Jadwal</span></a>
										<a data-toggle="modal" href="#pesanModal" id="pesan" data-lapangan_id="{{ $row->lapangan_id }}" data-harga_siang="{{ $row->harga_siang }}" data-harga_malam="{{ $row->harga_malam }}"><span class="label label-primary">Pesan</span></a>
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div> --}}
			</div>

		</div>
	</div>

	{{-- Pesan --}}
    <div class="modal fade" id="pesanModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">

					<div class="register" style="width: auto !important; margin: 0 !important;">
						<form action="{{ route('booking.store') }}" method="POST" id="booking-form">
							@csrf
							<div class="mation">
								<div>
									<input type="text" class="input @error('lapangan_id') is-invalid @enderror" name="lapangan_id" id="lapangan_id" hidden>
								</div>
								<div>
									<span>Waktu</span>
									<select name="jenis" class="input" id="jenis">
										@if ( old('jenis') == 'Siang' )
											<option value="">-- Waktu --</option>
											<option value="Siang" selected>Siang</option>
											<option value="Malam">Malam</option>
										@elseif ( old('jenis') == 'Malam' )
											<option value="">-- Waktu --</option>
											<option value="Siang">Siang</option>
											<option value="Malam" selected>Malam</option>
										@else
											<option value="">-- Waktu --</option>
											<option value="Siang">Siang</option>
											<option value="Malam">Malam</option>
										@endif
									</select>
									@error('jenis')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
								<div class="pesan-form">
									<span>Harga</span>
									<input type="text" class="input @error('harga') is-invalid @enderror" value="{{ old('harga') }}" name="harga" id="harga" readonly>
									@error('harga')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
								<div>
									<span>Tanggal Pesan</span>
									<input type="date" class="input @error('tanggal_pesan') is-invalid @enderror" value="{{ old('tanggal_pesan') }}" name="tanggal_pesan">
									@error('tanggal_pesan')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
								<div>
									<span>Jam Mulai</span>
									<input type="time" class="input @error('jam_mulai') is-invalid @enderror" value="{{ old('jam_mulai') }}" name="jam_mulai">
									@error('jam_mulai')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
								<div class="pesan-form">
									<span>Lama Bermain / Jam</span>
									<input type="number" min="1" max="10" class="input @error('lama_bermain') is-invalid @enderror" value="{{ old('lama_bermain') }}" id="lama_bermain" name="lama_bermain">
									@error('lama_bermain')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
								<div class="pesan-form">
									<span>Total Harga</span>
									<input type="text" readonly class="input @error('total_harga') is-invalid @enderror" value="{{ old('total_harga') }}" id="total_harga" name="total_harga">
									@error('total_harga')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
							</div>
						</form>
					</div>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="{{ route('booking.store') }}" onclick="event.preventDefault(); document.getElementById('booking-form').submit();">Pesan</a>
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
	
	<script>

		$(document).on('click', '#pesan', function () {
			var lapangan_id = $(this).data('lapangan_id')
			var nama = $(this).data('nama')
			var harga_siang = $(this).data('harga_siang')
			var harga_malam = $(this).data('harga_malam')

			$('#lapangan_id').val(lapangan_id)
			$('#exampleModalLabel').text('Pesan ' + nama)
			$(function () {
				$('#jenis').change(function () {
					var displayHarga = $('#jenis option:selected').val();
					if (displayHarga == 'Siang') {
						var harga = harga_siang

						var number_string 	= harga.toString(),
						sisa  				= number_string.length % 3,
						rupiah				= number_string.substr(0, sisa),
						ribuan				= number_string.substr(sisa).match(/\d{3}/gi)

						if (ribuan) {
							separator = sisa ? '.' : ''
							rupiah += separator + ribuan.join('.')
						}
						$('#harga').val("Rp. " + rupiah)

						$('#lama_bermain').click(function () {
							var total = 0
							var x = harga_siang
							var y = Number($('#lama_bermain').val())
							var total = x * y

							var harga = total

							var number_string 	= harga.toString(),
							sisa  				= number_string.length % 3,
							rupiah				= number_string.substr(0, sisa),
							ribuan				= number_string.substr(sisa).match(/\d{3}/gi)

							if (ribuan) {
								separator = sisa ? '.' : ''
								rupiah += separator + ribuan.join('.')
							}

							$('#total_harga').val("Rp. " + rupiah)
						})
						
						$('#lama_bermain').keyup(function () {
							var total = 0
							var x = harga_siang
							var y = Number($('#lama_bermain').val())
							var total = x * y

							var harga = total

							var number_string 	= harga.toString(),
							sisa  				= number_string.length % 3,
							rupiah				= number_string.substr(0, sisa),
							ribuan				= number_string.substr(sisa).match(/\d{3}/gi)

							if (ribuan) {
								separator = sisa ? '.' : ''
								rupiah += separator + ribuan.join('.')
							}

							$('#total_harga').val("Rp. " + rupiah)
						})
						
					} else if (displayHarga == 'Malam') {
						var harga = harga_malam
						
						var number_string 	= harga.toString(),
						sisa  				= number_string.length % 3,
						rupiah				= number_string.substr(0, sisa),
						ribuan				= number_string.substr(sisa).match(/\d{3}/gi)
						
						if (ribuan) {
							separator = sisa ? '.' : ''
							rupiah += separator + ribuan.join('.')
						}
						$('#harga').val("Rp. " + rupiah)

						$('#lama_bermain').click(function () {
							var total = 0
							var x = harga_malam
							var y = Number($('#lama_bermain').val())
							var total = x * y

							var harga = total

							var number_string 	= harga.toString(),
							sisa  				= number_string.length % 3,
							rupiah				= number_string.substr(0, sisa),
							ribuan				= number_string.substr(sisa).match(/\d{3}/gi)

							if (ribuan) {
								separator = sisa ? '.' : ''
								rupiah += separator + ribuan.join('.')
							}

							$('#total_harga').val("Rp. " + rupiah)
						})
						
						$('#lama_bermain').keyup(function () {
							var total = 0
							var x = harga_malam
							var y = Number($('#lama_bermain').val())
							var total = x * y

							var harga = total

							var number_string 	= harga.toString(),
							sisa  				= number_string.length % 3,
							rupiah				= number_string.substr(0, sisa),
							ribuan				= number_string.substr(sisa).match(/\d{3}/gi)

							if (ribuan) {
								separator = sisa ? '.' : ''
								rupiah += separator + ribuan.join('.')
							}

							$('#total_harga').val("Rp. " + rupiah)
						})
					}
				})
			})
		})

		function image1(d) {
			console.log('test1')
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
	</script>

@endsection	