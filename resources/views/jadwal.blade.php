@extends('layout.template')

@section('title', 'Basket Viladelima')

@section('header5', 'header5')

@section('active-jadwal', 'active')

@section('content')
    
    <!---->
	<div class="back">
		<h2>Jadwal</h2>
	</div>
	<!---->
	<div class="container">
		<div class="contact" style="margin-bottom: 30px;">
			@foreach ($lapangan as $lapangan)	
				<div class="typrography">
					<h3>Jadwal Lapangan {{ $loop->iteration }}</h3>
					<div class="bs-docs-example">
						<table class="table table-striped">
							<thead>
								<tr>
									<th>Tanggal Main</th>
									<th>Lama Main</th>
									<th>Jam Main</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($jadwal as $row)
									@if ( $row->lapangan_id == $lapangan->lapangan_id )	
										<tr>
											<td>{{ $row->tanggal }}</td> 
											<td>{{ $row->lama_mulai }}</td>  
											<td>{{ $row->jam_mulai . '-' . $row->jam_habis }}</td>  
										</tr>
									@endif	
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			@endforeach
			
		</div>
	</div>

@endsection

@section('js')

@endsection