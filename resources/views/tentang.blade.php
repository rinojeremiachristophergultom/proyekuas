@extends('layout.template')

@section('title', 'Basket Viladelima')

@section('header5', 'header5')

@section('active-tentang', 'active')

@section('content')
    <div class="back">
        <h2>About</h2>
    </div>
    <div class="sap_tabs">
        <div class="container">

            <div style="display: flex; justify-content: center; align-items:center;">

                <img src="{{ asset('assets2/images/tentang1.jpeg') }}" class="img-responsive" style="width: 400px; height:300px;" alt="" />
                <img src="{{ asset('assets2/images/Badminton_court.jpeg') }}" class="img-responsive" style="width: 400px; height:300px;" alt="" />
                <img src="{{ asset('assets2/images/tentang2.jpeg') }}" class="img-responsive" style="width: 400px; height:300px;" alt="" />
                
            </div>

        </div>
    </div>
    <!---->
	<!---->
	<div class="container" style="margin-bottom: 30px;">
		<div class="contact">
            
			<div class=" contact-top-in">
				<h3>View On Map</h3>
				<div class="map">
				<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1661.6121343882344!2d106.7814339011061!3d-6.308874417565333!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69ee2f97f1a405%3A0x5850d66a792bc9a!2sVilla%20Delima!5e0!3m2!1sid!2sid!4v1644981890360!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
						frameborder="0" style="border:0" allowfullscreen></iframe>

				</div>

				<p><i class="far fa-map"></i> Lb. Bulus, Kec. Cilandak, Kota Jakarta Selatan, Daerah Khusus Ibukota Jakarta </p>

			</div>
		</div>
	</div>

@endsection