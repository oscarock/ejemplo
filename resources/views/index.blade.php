<!DOCTYPE html>
<html>
  <head>
    <title>Simple Map</title>
    <meta name="viewport" content="initial-scale=1.0">
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
      #map {
        height: 100%;
      }
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
    </style>
  </head>
    <body>
        <div class="container">
            <h1 class="text-center">Consulta del Clima</h1>
            <hr>
            <div class="col-sm-6 offset-md-3 p-3">
                <select class="form-control" id="citySelect">
                    <option>--Seleccione--</option>
                    <option value="miami">Miami</option>
                    <option value="orlando">Orlando</option>
                    <option value="new york">New York</option>
                </select>
            </div>
            <div class="row">
                <div class="col-sm-8">
                <div id="map"></div>
            </div>

            <div class="col-sm-4" id="contact2">
                <h3 id="country_city">Pais - Ciudad</h3>
                <hr align="left" width="50%">
                <h4 class="pt-2">Datos</h4>
                <span><b>Latitud: </b></span><span id="lat">---</span><br> 
                <span><b>Longitud: </b></span><span id="long">---</span><br> 
                <span><b>Humedad: </b></span><span id="humidity">---</span><br>  
                <span><b>Visibilidad: </b></span><span id="visibility">---</span><br>
                <span><b>Presión: </b></span><span id="pressure">---</span>
                <hr>
                <a href="history">Ver Historial</a>
            </div>
        </div>

        
        <script src="https://maps.googleapis.com/maps/api/js?keyAIzaSyBF3V4xCIROJCK_Y3chhbZOnh0T2chUgt4&callback=initMap" async defer></script>
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

        <script>
            var map;
            function initMap() {
                map = new google.maps.Map(document.getElementById('map'), {
                    center: {lat: 25.782551, lng: -80.221748},
                    zoom: 8
                });
            }

            function rederMap(latitud,longitud){
                map = new google.maps.Map(document.getElementById('map'), {
                    center: {lat: latitud, lng:longitud},
                    zoom: 8
                });
            }

            $("#citySelect").change(function(){
                $.ajax({
                    method: "POST",
                    url: 'api',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        city: $(this).val()
                    },
                }).done(function(response){
                   var json = JSON.parse(response);+
                   rederMap(json.lat,json.long)
                   $("#country_city").html(json.country + ' - ' + json.city)
                   $("#lat").html(json.lat)
                   $("#long").html(json.long)
                   $("#humidity").html(json.humidity)
                   $("#visibility").html(json.visibility)
                   $("#pressure").html(json.pressure)
                })
            })
        </script>
    </body>
</html>

