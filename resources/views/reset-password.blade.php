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
				
				@if (session('message_fail'))
					<ol class="breadcrumb" style="background-color: #ff5d56; color: #fff;">
						<li class="">{{ session('message_fail') }}</li>
					</ol>
				@endif
				<form action="{{ route('password.update') }}" method="POST">
                    @csrf

                    <input type="hidden" name="token" value="{{ request()->token }}">
					<div>
						<span>Email</span>
						<input type="email" class="input" name="email" placeholder="Masukkan Email" value="{{ $request->email }}">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
					<div>
						<span>Password Baru</span>
						<input type="password" class="input" name="password" placeholder="Masukkan Password Baru">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
					<div>
						<span>Konfirmasi Password Baru</span>
						<input type="password" class="input" name="password_confirmation" placeholder="Masukkan Konfirmasi Password Baru">
                        @error('password_confirmation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
					<input type="submit" value="Ubah">
				</form>
			</div>

		</div>

	</div>
	<!---->

@endsection