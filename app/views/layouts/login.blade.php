<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="Gestor de recursos">
		<meta name="author" content="Juan Carlos Quintanilla">
		<title>Administrador - Control de acceso</title>
		<link type="text/css" rel="stylesheet" href="{{url('bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
		<link type="text/css" rel="stylesheet" href="{{url('bower_components/metisMenu/dist/metisMenu.min.css')}}">
		<link type="text/css" rel="stylesheet" href="{{url('bower_components/font-awesome/css/font-awesome.min.css')}}">
		<link type="text/css" rel="stylesheet" href="{{url('bower_components/form-validator/theme-default.css')}}">
		<link type="text/css" rel="stylesheet" href="{{url('css/sb-admin-2.css')}}">
		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	<body>
		<h1 class="hidden">
			Administrador - Control de acceso
		</h1>
		@yield('contenido')
		<script src="{{url('bower_components/jquery/dist/jquery.min.js')}}"></script>
		<script src="{{url('bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
		<script src="{{url('bower_components/metisMenu/dist/metisMenu.min.js')}}"></script>
		<script src="{{url('bower_components/form-validator/jquery.form-validator.min.js')}}"></script>
		<script src="{{url('bower_components/form-validator/lang/es.js')}}"></script>
		<script src="{{url('js/sb-admin-2.js')}}"></script>
		<script>
			$.validate({
				lang:'es'
			});
		</script>
	</body>
</html>