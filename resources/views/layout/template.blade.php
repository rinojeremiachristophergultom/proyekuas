<!--A Design by W3layouts 
Author: W3layout
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE html>
<html>
<head>
<title>@yield('title')</title>
<link href="{{asset('assets2/css/bootstrap.css')}}" rel="stylesheet" type="text/css" media="all" />
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="{{ asset('/assets/vendor/jquery/jquery.js') }}"></script>
<!-- Custom Theme files -->
<!--theme-style-->
<link href="{{asset('assets2/css/style.css')}}" rel="stylesheet" type="text/css" media="all" />	
<!--//theme-style-->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="I wear Responsive web template, Bootstrap Web Templates, Flat Web Templates, Andriod Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyErricsson, Motorola web design" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<script type="text/javascript" src="{{ asset('assets2/js/html2canvas.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets2/js/move-top.js')}}"></script>
<script type="text/javascript" src="{{asset('assets2/js/easing.js')}}"></script>
<!--fonts-->
<link href='{{url('fonts.googleapis.com/css?family=Lato:100,300,400,700,900')}}' rel='stylesheet' type='text/css'>
<link href='{{url('fonts.googleapis.com/css?family=Montez')}}' rel='stylesheet' type='text/css'>
<link href="{{ asset('/assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
<!--//fonts-->
<!-- start menu -->
<!--//slider-script-->
<script src="{{asset('assets2/js/easyResponsiveTabs.js')}}" type="text/javascript"></script>
		    <script type="text/javascript">
			    $(document).ready(function () {
			        $('#horizontalTab').easyResponsiveTabs({
			            type: 'default', //Types: default, vertical, accordion           
			            width: 'auto', //auto or any width like 600px
			            fit: true   // 100% fit in a container
			        });
			    });
				
</script>	
		  		 <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
	<!-- js -->
		 <script src="{{asset('assets2/js/bootstrap.js')}}"></script>
	<!-- js -->
<script src="{{asset('assets2/js/simpleCart.min.js')}}"> </script>
<link href="{{asset('assets2/css/memenu.css')}}" rel="stylesheet" type="text/css" media="all" />
<!-- start menu -->
<script type="text/javascript" src="{{asset('assets2/js/memenu.js')}}"></script>
<script>$(document).ready(function(){$(".memenu").memenu();});</script>	
<!-- /start menu -->
</head>
<body>
	<!--header-->
	<div class="header-info">
		<div class="container">
			<div class="header-top-in">

				<ul class="support">
					<li><a href="https://wa.me/+6282273226414"><i class="fab fa-whatsapp-square"></i>Whatsapp</a></li>
				</ul>
				<ul class=" support-right">
					@if (Auth::check())
						<li><a href="{{ route('dashboard') }}"><i class="glyphicon glyphicon-user" class="men"> </i>{{ Auth::user()->name }}</a></li>
						<li><a href="{{ route('user.keluar') }}" onclick="event.preventDefault(); document.getElementById('keluar').submit();"><i class="glyphicon glyphicon-arrow-right" class="men"> </i>Logout</a></li>
						<form action="{{ route('user.keluar') }}" method="POST" id="keluar">
							@csrf
						</form>
					@else
						<li><a href="{{ route('masuk') }}"><i class="glyphicon glyphicon-user" class="men"> </i>Masuk</a></li>
						<li><a href="{{ route('daftar') }}"><i class="glyphicon glyphicon-lock" class="tele"> </i>Daftar</a></li>
					@endif
				</ul>
				<div class="clearfix"> </div>
			</div>
		</div>
	</div>
	<div class="header @yield('header5')">
		<div class="header-top">

			<div class="header-bottom">
				<div class="container">
					<div class="logo">
						<h1><a href="{{ route('index') }}">Badminton<span>Polonia</span></a></h1>
					</div>
					<!---->

					<div class="top-nav">
						<ul class="memenu skyblue">
							<li class="@yield('active-home')"><a href="{{ route('index') }}">Home</a></li>
							<li class="@yield('active-tentang')" class="grid"><a href="{{ route('tentang') }}">About</a></li>
							<li class="@yield('active-cara-pemesanan')" class="grid"><a href="{{ route('cara-pemesanan') }}">How To Order</a></li>
							<li class="@yield('active-booking')" class="grid"><a href="{{ route('booking') }}">Order</a></li>
							<li class="@yield('active-jadwal')" class="grid"><a href="{{ route('jadwal') }}">Schedule</a></li>
							@if (Auth::check())
								<li class="@yield('active-dashboard')" class="grid"><a href="{{ route('dashboard') }}">Dashboard</a></li>
							@endif
						</ul>
						<div class="clearfix"> </div>
					</div>
					<!---->

					<div class="clearfix"> </div>
					<!---->
				</div>
				<div class="clearfix"> </div>
			</div>
		</div>

        @yield('content-header')

		<div class="clearfix"> </div>
	</div>
	<!---->
	<!---->

    @yield('content')
	
	<!---->
	<div class="footer">
		<div class="container">
			<div class="clearfix"> </div>
			<p class="footer-class">
				Copyrights ©DEL Badminton|Design by Jeremia
			</p>
		</div>
	</div>
	<!---->
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function () {
			/*
			var defaults = {
			containerID: 'toTop', // fading element id
			containerHoverID: 'toTopHover', // fading element hover id
			scrollSpeed: 1200,
			easingType: 'linear' 
			};
			*/
			$().UItoTop({ easingType: 'easeOutQuart' });
		});
	</script>
	<a href="#to-top" id="toTop" style="display: block;"> <span id="toTopHover" style="opacity: 1;"> </span></a>
	<!---->
	@yield('js')
	<!---->
</body>
</html>