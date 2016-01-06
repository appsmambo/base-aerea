@extends('layouts.login')
@section('contenido')
<div class="container">
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<div class="login-panel panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">
						Control de acceso
					</h3>
				</div>
				<div class="panel-body">
					<form role="form" method="post" action="{{url('login')}}">
						<fieldset>
							<div class="form-group">
								<input class="form-control" placeholder="E-mail" name="email" type="email" autofocus data-validation="required|email">
							</div>
							<div class="form-group">
								<input class="form-control" placeholder="Contraseña" name="password" type="password" value="" autofocus data-validation="required">
							</div>
							<input type="submit" class="btn btn-lg btn-primary pull-right" value="Entrar al sistema">
						</fieldset>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@stop