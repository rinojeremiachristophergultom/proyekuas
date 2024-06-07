@extends('layout.template')

@section('title', 'Basket Viladelima')

@section('header5', 'header5')

@section('active-dashboard', 'active')

@section('content')
    
    <!---->
	<div class="back">
		<h2>Dashboard</h2>
	</div>
	<!---->
	<div class="container">
		<div class="contact" style="margin-bottom: 30px;">
			<div class="typrography">
				<h3>List Booking</h3>
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

				@foreach ($errors->all() as $error)
					<ol class="breadcrumb" style="background-color: #ff5d56; color: #fff;">
						<li class="">{{ $error }}</li>
					</ol>
				@endforeach

				<div class="bs-docs-example">
					<table class="table table-striped">
						<thead>
							<tr>
								<th>ID Booking</th>
								<th>ID Lapangan</th>
								<th>Jam Pesan</th>
								<th>Tanggal Main</th>
								<th>Lama Main</th>
								<th>Jam Mulai</th>
								<th>Jam Selesai</th>
								<th>Harga / Jam</th>
								<th>Total Harga</th>
								<th>Status</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($booking_data as $row)	
								<tr>
									<td>{{ $row->booking_id }}</td>
									<td>{{ $row->lapangan_id }}</td>
									<td>{{ date('d-m-Y', strtotime($row->created_at)) }}</td>
									<td>{{ date('d-m-Y', strtotime($row->tanggal)) }}</td>
									<td>{{ $row->lama_mulai }}</td>
									<td>{{ date('H:i A', strtotime($row->jam_mulai)) }}</td>
									<td>{{ date('H:i A', strtotime($row->jam_habis)) }}</td>
									<td>Rp. {{ number_format($row->harga_lapangan) }}</td>
									<td>Rp. {{ number_format($row->total) }}</td>
									<td>{{ $row->status }}</td>
									<td>
										@if ( $row->status == 'Belum Bayar' )
											<a data-toggle="modal" href="#bayarModal" id="bayar-btn" data-booking_id="{{ $row->booking_id }}" data-tanggal="{{ date('d M Y', strtotime($row->tanggal)) }}" data-lama_main="{{ $row->lama_mulai }}" data-jam_mulai="{{ date('H:i A', strtotime($row->jam_mulai)) }}" data-jam_habis="{{ date('H:i A', strtotime($row->jam_habis)) }}" data-harga_total="Rp. {{ number_format($row->total) }}"><span class="label label-default">Bayar</span></a>
											<a href="javascript:void(0);" class="batal-btn" data-id="{{ $loop->iteration }}"><span class="label label-primary">Batal</span></a>
											<form action="{{ route('booking.delete', [$row->booking_id]) }}" method="POST" id="batal{{ $loop->iteration }}">
												@csrf
												@method('PATCH')
											</form>
										@elseif ($row->status == 'Pending')
											@php
												$bukti_tf = collect(DB::select("select * from user__bayars where booking_id = '" . $row->booking_id . "'"))->first();
											@endphp
											<a href="{{ asset($bukti_tf->bukti_tf) }}" target="__blank"><span class="label label-primary">Lihat</span></a>
										@elseif ($row->status == 'Sudah Bayar')
											<a data-toggle="modal" href="#cetakModal" id="cetak-btn" data-booking_id="{{ $row->booking_id }}" data-lapangan_id="{{ $row->lapangan_id }}" data-tanggal_pesan="{{ date('d M Y', strtotime($row->created_at)) }}" data-tanggal_main="{{ date('d M Y', strtotime($row->tanggal)) }}" data-lama_main="{{ $row->lama_mulai }}" data-jam_mulai="{{ date('H:i A', strtotime($row->jam_mulai)) }}" data-jam_habis="{{ date('H:i A', strtotime($row->jam_habis)) }}" data-harga_lapangan="Rp. {{ number_format($row->harga_lapangan) }}" data-harga_total="Rp. {{ number_format($row->total) }}" data-status="{{ $row->status }}"><span class="label label-primary"><i class="fas fa-print"></i> Cetak</span></a>
										@elseif ($row->status == 'Error')
											<a data-toggle="modal" href="#bayarModal" id="bayar-btn" data-booking_id="{{ $row->booking_id }}" data-tanggal="{{ date('d M Y', strtotime($row->tanggal)) }}" data-lama_main="{{ $row->lama_mulai }}" data-jam_mulai="{{ date('H:i A', strtotime($row->jam_mulai)) }}" data-jam_habis="{{ date('H:i A', strtotime($row->jam_habis)) }}" data-harga_total="Rp. {{ number_format($row->total) }}"><span class="label label-default">Bayar</span></a>
											<a href="javascript:void(0);" class="batal-btn" data-id="{{ $loop->iteration }}"><span class="label label-primary">Batal</span></a>
											<form action="{{ route('booking.delete', [$row->booking_id]) }}" method="POST" id="batal{{ $loop->iteration }}">
												@csrf
												@method('PATCH')
											</form>
										@endif
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
			<div class="typrography">
				<h3>History Booking</h3>

				<div class="bs-docs-example">
					<table class="table table-striped">
						<thead>
							<tr>
								<th>ID Booking</th>
								<th>ID Lapangan</th>
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
						<tbody>
							@foreach ($history_booking_data as $row)	
								<tr>
									<td>{{ $row->booking_id }}</td>
									<td>{{ $row->lapangan_id }}</td>
									<td>{{ date('d-m-Y', strtotime($row->created_at)) }}</td>
									<td>{{ date('d-m-Y', strtotime($row->tanggal)) }}</td>
									<td>{{ $row->lama_mulai }}</td>
									<td>{{ date('H:i A', strtotime($row->jam_mulai)) }}</td>
									<td>{{ date('H:i A', strtotime($row->jam_habis)) }}</td>
									<td>Rp. {{ number_format($row->harga_lapangan) }}</td>
									<td>Rp. {{ number_format($row->total) }}</td>
									<td>{{ $row->status }}</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>

		</div>
	</div>

	{{-- Pesan --}}
    <div class="modal fade" id="bayarModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Pesan Lapangan</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

				<ol class="breadcrumb" style="background-color: #ebc634; color: #fff;">
					<li class="">Perhatikan baik-baik Nama dan Nomer Rekening saat mentransfer!</li>
				</ol>

                <div class="modal-body">

					<div class="register" style="width: auto !important; margin: 0 !important;">
						<form action="{{ route('booking.payment') }}" enctype="multipart/form-data" method="POST" id="booking-form">
							@csrf
							@method('PATCH')
							<div class="mation">
								<input type="text" name="booking_id" id="booking_id" style="display: none !important;">
								<div>
									<span>Tanggal Main</span>
									<input type="text" class="input @error('tanggal_main') is-invalid @enderror" name="tanggal_main" id="tanggal_main" readonly>
									@error('tanggal_main')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
								<div>
									<span>Lama Main</span>
									<input type="text" class="input @error('lama_main') is-invalid @enderror" name="lama_main" id="lama_main" readonly>
									@error('lama_main')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
								<div>
									<span>Jam Main</span>
									<input type="text" class="input @error('jam_main') is-invalid @enderror" name="jam_main" id="jam_main" readonly>
									@error('jam_main')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
								<div>
									<span>Total Harga</span>
									<input type="text" class="input @error('total_harga') is-invalid @enderror" name="total_harga" id="total_harga" readonly>
									@error('total_harga')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
								@php
									$rekening_check = collect(DB::select('select * from rekenings'));
									// $rekening_data = $rekening_check->get();
								@endphp
								<div>
									<span>Metode Pembayaran</span>
									@error('nama_rekening')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
									<select class="input @error('nama_rekening') is-invalid @enderror" name="nama_rekening" id="nama_rekening">
										@foreach ($rekening_check as $row)
											<option value="{{ $row->nama_rekening }} - {{ $row->nomer_rekening }}">{{ $row->nama_rekening }} - {{ $row->nomer_rekening }}</option>
										@endforeach
									</select>
								</div>
								{{-- <div>
									<span>Nomer Rekening</span>
									<input type="text" value="{{ $rekening_data->nomer_rekening }}" class="input @error('nomer_rekening') is-invalid @enderror" name="nomer_rekening" id="nomer_rekening" readonly>
									@error('nomer_rekening')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div> --}}
								<div>
									<span>Bukti Pembayaran</span>
									<input type="file" class="input @error('bukti_pembayaran') is-invalid @enderror" name="bukti_pembayaran" id="bukti_pembayaran" style="border:none !important;" readonly>
									@error('bukti_pembayaran')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
							</div>
						</form>
					</div>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="{{ route('booking.payment') }}" onclick="event.preventDefault(); document.getElementById('booking-form').submit();">Submit</a>
                </div>
            </div>
        </div>
    </div>

	{{-- Cetak --}}
    <div class="modal fade" id="cetakModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" style="width: 20% !important;" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cetak Bukti Pembayaran!</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <div class="modal-body">

					<div class="register" style="width: auto !important; margin: 0 !important;">
						<form action="{{ route('booking.payment') }}" enctype="multipart/form-data" method="POST" id="booking-form">
							@csrf
							@method('PATCH')
							<div class="mation">
								<table>
									<tr>
										<td style="font-weight: 600;">ID Booking</td>
										<td style="padding: 5px !important;">:</td>
										<td id="booking_id-cetak"></td>
									</tr>
									<tr>
										<td style="font-weight: 600;">ID Lapangan</td>
										<td style="padding: 5px !important;">:</td>
										<td id="lapangan_id-cetak"></td>
									</tr>
									<tr>
										<td style="font-weight: 600;">Tanggal Pesan</td>
										<td style="padding: 5px !important;">:</td>
										<td id="tanggal_pesan-cetak"></td>
									</tr>
									<tr>
										<td style="font-weight: 600;">Tanggal Main</td>
										<td style="padding: 5px !important;">:</td>
										<td id="tanggal_main-cetak"></td>
									</tr>
									<tr>
										<td style="font-weight: 600;">Lama Main</td>
										<td style="padding: 5px !important;">:</td>
										<td id="lama_main-cetak"></td>
									</tr>
									<tr>
										<td style="font-weight: 600;">Jam Main</td>
										<td style="padding: 5px !important;">:</td>
										<td id="jam_main-cetak"></td>
									</tr>
									<tr>
										<td style="font-weight: 600;">Harga / Jam</td>
										<td style="padding: 5px !important;">:</td>
										<td id="harga_lapangan-cetak"></td>
									</tr>
									<tr>
										<td style="font-weight: 600;">Total Harga</td>
										<td style="padding: 5px !important;">:</td>
										<td id="total_harga-cetak"></td>
									</tr>
									<tr>
										<td style="font-weight: 600;">Status</td>
										<td style="padding: 5px !important;">:</td>
										<td><span class="label label-success" id="status-cetak"></span></td>
									</tr>
								</table>
							</div>
						</form>
					</div>

                </div>
                <div class="modal-footer">
                    <a class="btn btn-primary" id="cetak_btn">Cetak</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
	
	<script>
		$(document).on('click', '#cetak_btn', function () { 
			html2canvas($("#cetakModal"), {
				onrendered: function(canvas) {
					theCanvas = canvas;


					canvas.toBlob(function(blob) {
						saveAs(blob, "bukti-tf.png"); 
					});
				}
			});
		});

		$(document).on('click', '#bayar-btn', function () {
			var booking_id = $(this).data('booking_id')
			var tanggal = $(this).data('tanggal')
			var lama_main = $(this).data('lama_main')
			var jam_mulai = $(this).data('jam_mulai')
			var jam_habis = $(this).data('jam_habis')
			var harga_total = $(this).data('harga_total')

			$('#booking_id').val(booking_id)
			$('#tanggal_main').val(tanggal)
			$('#lama_main').val(lama_main)
			$('#jam_main').val(jam_mulai + "-" + jam_habis)
			$('#total_harga').val(harga_total)
		})

		$(document).on('click', '#cetak-btn', function () {
			var booking_id = $(this).data('booking_id')
			var lapangan_id = $(this).data('lapangan_id')
			var tanggal_pesan = $(this).data('tanggal_pesan')
			var tanggal_main = $(this).data('tanggal_main')
			var lama_main = $(this).data('lama_main')
			var jam_mulai = $(this).data('jam_mulai')
			var jam_habis = $(this).data('jam_habis')
			var harga_lapangan = $(this).data('harga_lapangan')
			var harga_total = $(this).data('harga_total')
			var status = $(this).data('status')

			$('#booking_id-cetak').text(booking_id)
			$('#lapangan_id-cetak').text(lapangan_id)
			$('#tanggal_pesan-cetak').text(tanggal_pesan)
			$('#tanggal_main-cetak').text(tanggal_main)
			$('#lama_main-cetak').text(lama_main)
			$('#jam_main-cetak').text(jam_mulai + "-" + jam_habis)
			$('#harga_lapangan-cetak').text(harga_lapangan)
			$('#total_harga-cetak').text(harga_total)
			$('#status-cetak').text(status)
		})

		$(".batal-btn").click(function () {
            var id = $(this).data('id')

            swal({
                title: "Yakin mau batalin?",
                text: "jika anda membatalkan pesanan, maka anda harus pesan ulang lagi!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    swal("berhasil! Kamu berhasil membatalkan pesanan!", {
                        icon: "success",
                    });
                    $("#batal" + id).submit();
                }
            });
        })
	</script>

@endsection