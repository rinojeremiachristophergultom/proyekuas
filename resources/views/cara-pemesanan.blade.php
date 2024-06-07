@extends('layout.template')

@section('title', 'Basket Viladelima')

@section('header5', 'header5')

@section('active-cara-pemesanan', 'active')

@section('content')
    
    <!---->
	<div class="back">
		<h2>Cara Pemesanan</h2>
	</div>
	<!---->
	<div class="container">
		<div class="contact">
            
			<div class=" contact-top-in">
				<h3>Cara Pemesanan Lapangan :</h3>

					<div style="margin-bottom: 10px; display: flex; justify-content: center; align-items:center;">
					<img src="{{ asset('lapangan/daftar.jpg') }}" class="img-responsive" style="width: 500px; height:300px;" alt="" />
					</div>
					<p style="text-align: center; font-size: 15px; margin-bottom: 20px">(Pertama user melakukan daftar)</p>
					
					<div style="margin-bottom: 10px; display: flex; justify-content: center; align-items:center;">
					<img src="{{ asset('lapangan/login.jpg') }}" class="img-responsive" style="width: 500px; height:300px;" alt="" />
					</div>
					<p style="text-align: center; font-size: 15px; margin-bottom: 20px">(Apabila user sudah mendaftar langsung halaman masuk)</p>

					<div style="margin-bottom: 10px; display: flex; justify-content: center; align-items:center;">
					<img src="{{ asset('lapangan/booking.jpg') }}" class="img-responsive" style="width: 500px; height:300px;" alt="" />
					</div>
					<p style="text-align: center; font-size: 15px; margin-bottom: 20px">(Selanjutnya user masuk kehalam booking, lalu pilih lapangan yang diinginkan, Waktu Siang : 08:00 - 15:00 Waktu Malam 16:00 - 24:00)</p>

					<div style="margin-bottom: 10px; display: flex; justify-content: center; align-items:center;">
					<img src="{{ asset('lapangan/pembayaran.jpg') }}" class="img-responsive" style="width: 500px; height:300px;" alt="" />
					</div>
					<p style="text-align: center; font-size: 15px; margin-bottom: 20px">(Selanjutnya user melakukan pembayaran di form " Bayar " yang ada dihalaman dashboard dan apabila ingin membatalkan langsung klik " Batal ")</p>

					<div style="margin-bottom: 10px; display: flex; justify-content: center; align-items:center;">
					<img src="{{ asset('lapangan/cetak.jpg') }}" class="img-responsive" style="width: 500px; height:300px;" alt="" />
					</div>
					<p style="text-align: center; font-size: 15px; margin-bottom: 20px">(Selanjutnya apabila user sudah mentransfer sesuai yang ada di form pembayaran, user menunggu konfirmasi dari admin, apabila sudah benar user bisa screenshot bukti)</p>
			</div>
		</div>
	</div>

@endsection