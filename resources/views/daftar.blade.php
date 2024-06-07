@extends('layout.template')

@section('title', 'Basket Viladelima')

@section('header5', 'header5')

@section('content')
    
    <!---->
	<div class="back">
		<h2>Register</h2>
	</div>
	<!---->
	<div class="container">
		<div class="register">
			<h3>PERSONAL INFORMATION</h3>
			<form action="{{ route('user.daftar') }}" method="POST">
                @csrf
				<div class="mation">
					<div>
						<span>Nama</span>
						<input type="text" class="input @error('nama') is-invalid @enderror" value="{{ old('nama') }}" name="nama" placeholder="Masukkan Nama">
						@error('nama')
							<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>
					<div>
                        <span>Nomor Handphone</span>
						<input type="text" class="input @error('no_hp') is-invalid @enderror" value="{{ old('no_hp') }}" name="no_hp" placeholder="Masukkan Nomer Handphone">
						@error('no_hp')
							<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>
					<div>
                        <span>Jenis Kelamin</span>
						<select name="jk" id="jk" class="input @error('jk') is-invalid @enderror" value="{{ old('jk') }}">
							@if ( old('jk') == 'Laki-Laki')
								<option value="">-- Jenis Kelamin --</option>
								<option value="Laki-Laki" selected>Laki-Laki</option>
								<option value="Perempuan">Perempuan</option>
							@elseif ( old('jk') == 'Perempuan' )
								<option value="">-- Jenis Kelamin --</option>
								<option value="Laki-Laki">Laki-Laki</option>
								<option value="Perempuan" selected>Perempuan</option>
							@else
								<option value="">-- Jenis Kelamin --</option>
								<option value="Laki-Laki">Laki-Laki</option>
								<option value="Perempuan">Perempuan</option>
							@endif
						</select>
						@error('jk')
							<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>
                    <div>
                        <span>Alamat</span>
						<textarea name="alamat" placeholder="Masukkan Alamat" class="input @error('alamat') is-invalid @enderror" id="alamat">{{ old('alamat') }}</textarea>
						@error('alamat')
							<div class="invalid-feedback">{{ $message }}</div>
						@enderror
                    </div>
                    <div>
                        <span>Username</span>
                        <input type="text" class="input @error('username') is-invalid @enderror" value="{{ old('username') }}" name="username" placeholder="Masukkan Username">
						@error('username')
							<div class="invalid-feedback">{{ $message }}</div>
						@enderror
                    </div>
					<div>
						<span>Email Address</span>
						<input type="email" class="input @error('email') is-invalid @enderror" value="{{ old('email') }}" class="input" name="email" placeholder="Masukkan Email Address">
						@error('email')
							<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>
					<div>
						<span>Password</span>
						<input type="password" class="input @error('password') is-invalid @enderror" value="{{ old('password') }}" name="password" placeholder="Masukkan Password">
						@error('password')
							<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>
					<div>
						<span>Konfirmasi Password</span>
						<input type="password" class="input @error('password_confirmation') is-invalid @enderror" value="{{ old('password_confirmation') }}" name="password_confirmation" placeholder="Masukkan Konfirnasi Password">
						@error('password_confirmation')
							<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>
				</div>
				<input type="submit" value="submit">
			</form>
		</div>
	</div>
	<!---->

@endsection