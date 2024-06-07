@extends('layout.template')

@section('title', 'Basket Viladelima')

@section('active-home', 'active')

@section('content-header')	

    <div class="banner">
        <div class="banner-top">
            <h2>Badminton Polonia</h2>
        </div>
        <div class="now">
            <a class="morebtn" href="{{ route('booking') }}">Order Sekarang</a>
            <div class="clearfix"> </div>
        </div>
    </div>

@endsection

@section('content')
    <div class="sap_tabs">
        <div class="container">

            <div style="margin-bottom: 10px; display: flex; justify-content: center; align-items:center;">

                <img src="{{ asset('assets2/images/beranda1.jpeg') }}" class="img-responsive" style="width: 500px; height:300px;" alt="error" /> 
            </div>
            <p style="text-align: center; text-transform: uppercase; font-size: 20px; font-weight: 600;">Lapangan 1</p>
            <p style="text-align: center; font-size: 18px; margin-bottom: 20px">( INDOOR )</p>
            
            <div style="margin-bottom: 10px; display: flex; justify-content: center; align-items:center;">
                
                <img src="{{ asset('assets2/images/beranda2.jpeg') }}" class="img-responsive" style="width: 500px; height:300px;" alt="" />
                
            </div>
            <p style="text-align: center; text-transform: uppercase; font-size: 20px; font-weight: 600;">Lapangan 2</p>
            <p style="text-align: center; font-size: 18px; margin-bottom: 20px">( OUTDOOR )</p>
            
           

        </div>
    </div>


@endsection