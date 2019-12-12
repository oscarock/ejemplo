<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <title>Historial</title>
</head>
<body>
    <div class="container">
    <h1 class="text-center mt-2">Registros del Clima</h1>
    <table class="table table-striped ">
  <thead>
    <tr>
      <th class="text-center">#</th>
      <th class="text-center">Pais</th>
      <th class="text-center">Ciudad</th>
      <th class="text-center">Humedad (F)</th>
      <th class="text-center">Visibilidad</th>
      <th class="text-center">Presión</th>
      <th class="text-center">Reporte del dia</th>
    </tr>
  </thead>
  <tbody>
    @foreach($cities as $city)
        <tr>
            <td class="text-center">{{ $city->id }}</td>
            <td class="text-center">{{ $city->country }}</td>
            <td class="text-center">{{ $city->city }}</td>
            <td class="text-center">{{ $city->humidity }}</td>
            <td class="text-center">{{ $city->visibility }}</td>
            <td class="text-center">{{ $city->pressure }}</td>
            <td class="text-center">{{ $city->created_at }}</td>
        </tr>
    @endforeach
  </tbody>
</table>
    
    <a href="/">Volver</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>