@extends('layout.template')

@section('title', 'Basket Viladelima')

@section('header5', 'header5')

@section('content')
    
    <!---->
	<div class="back">
		<h2>Login</h2>
	</div>
	<!---->
	<div class="container">

		<div class="account_grid">
			<div class=" login-right">
				<h3>REGISTERED CUSTOMERS</h3>
				<p>If you have an account with us, please log in.</p>
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
				<form action="{{ route('user.masuk') }}" method="POST">
                    @csrf
					<div>
						<span>Username / Email</span>
						<input type="text" class="input" name="username" placeholder="Masukkan Username / Email">
					</div>
					<div>
						<span>Password</span>
						<input type="password" class="input" name="password" placeholder="Masukkan Password">
					</div>
					<a class="forgot" href="{{ route('password.request') }}">Forgot Your Password?</a>
					<input type="submit" value="Login">
				</form>
			</div>
			<a  class="login-right" href="{{ route('admin.login') }}">Login Admin</a>
			<div class=" login-left">
				<h3>NEW CUSTOMERS</h3>
				<a class="acount-btn" href="{{ route('daftar') }}">Create an Account</a>
			</div>

		</div>

	</div>
	<!---->

@endsection