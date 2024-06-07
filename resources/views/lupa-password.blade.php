@extends('layout.template')

@section('title', 'Basket Viladelima')

@section('header5', 'header5')

@section('content')
    
    <!---->
	<div class="back">
		<h2>Lupa Password</h2>
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

				@if (session('status'))
					<ol class="breadcrumb" style="background-color: green; color: #fff;">
						<li class="">{{ session('status') }}</li>
					</ol>
				@endif
				
				@if (session('message_fail'))
					<ol class="breadcrumb" style="background-color: #ff5d56; color: #fff;">
						<li class="">{{ session('message_fail') }}</li>
					</ol>
				@endif
				<form action="{{ route('password.email') }}" method="POST">
                    @csrf
					<div>
						<span>Email</span>
						<input type="email" class="input" name="email" placeholder="Masukkan Email">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
					<a class="forgot" href="{{ route('masuk') }}">Sudah mempunyai akun? Masuk!</a>
					<input type="submit" value="Kirim">
				</form>
			</div>
			<div class=" login-left">
				<h3>NEW CUSTOMERS</h3>
				<p>By creating an account with our store, you will be able to move through the checkout process faster,
					store multiple shipping addresses, view and track your orders in your account and more.</p>
				<a class="acount-btn" href="{{ route('daftar') }}">Create an Account</a>
			</div>

		</div>

	</div>
	<!---->

@endsection