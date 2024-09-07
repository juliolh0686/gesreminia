@extends('layouts.app')

@section('content')

		<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100 p-t-85 p-b-20">
				<form class="login100-form validate-form" method="POST" action="{{ route('login') }}">
				@csrf
					<span class="login100-form-title p-b-70">
					Acceso a la Aplicación
					</span>
					<span class="login100-form-avatar">
						<img src="loguin/images/avatar-01.jpg" alt="AVATAR">
					</span>

					<div class="wrap-input100 validate-input m-t-85 m-b-35">
						<input class="input100 {{ $errors->has('username') ? ' is-invalid' : '' }}" type="username" id="username" name="username" value="{{ old('username') }}" required autofocus>
						<span class="focus-input100" data-placeholder="Usuario"></span>
						@if ($errors->has('username'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('username') }}</strong>
                        </span>
                        @endif
					</div>

					<div class="wrap-input100 validate-input m-b-50" data-validate="Enter password">
						<input class="input100 {{ $errors->has('password') ? ' is-invalid' : '' }}" type="password" id="password" name="password">
						<span class="focus-input100" data-placeholder="Contraseña"></span>
						@if ($errors->has('password'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                        @endif
					</div>

					<div class="container-login100-form-btn">
						<button class="login100-form-btn" type="submit">
							Ingresar
						</button>
					</div>

					<ul class="login-more p-t-50">
						<li class="m-b-8">
							<a href="{{ route('password.request') }}" class="txt2">
							Recuperar Usuario / Contraseña
							</a>
						</li>

						<li>
							<a href="{{ route('register') }}" class="txt2">
								Registrarme
							</a>
						</li>
					</ul>
				</form>
			</div>
		</div>
	</div>
	

	<div id="dropDownSelect1"></div>

@endsection
