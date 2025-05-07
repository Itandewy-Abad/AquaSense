<?php
//echo '<link href="index.css" type="text/css" rel="stylesheet">';
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Si se envió el formulario, actualizar los valores
    $ano = $_POST["ano"];
    $mes = $_POST["mes"];
    $dia = $_POST["dia"];
}

function humedad_diaria($ano, $mes, $dia, $con){
    $resultadotemp = "SELECT UNIX_TIMESTAMP(fecha), humedad FROM valorsensores WHERE year(`fecha`)= '$ano' AND month(`fecha`) = '$mes' and day(`fecha`) = '$dia'";
    $redes = mysqli_query($con, $resultadotemp);

    while($row=mysqli_fetch_array($redes)){
        echo"[";
        echo $row[0]*1000;
        echo ",";
        echo $row[1];
        echo "],";
    }   
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>aquasense | LECTURAS</title>
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="bootstrap.min.css">
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
</head>
<body>
<header>
        <div class="contenedor">
            <p class="logo"><img height="80px" src="multimedia/aquasense-logo.png" alt=""></p>
            <nav>
                <a href="index.html">INICIO</a>
                <a href="pruebasgraficas.php">LECTURAS</a>
                <a href="modomanual.html">MODO MANUAL</a>
                <a href="configuraciones.html">CONFIGURACIONES</a>
                <a href="index.html#lugares">PRODUCTOS</a>
                <a href="nosotros.html">NOSOTROS</a>
            </nav>
        </div>
    </header>
    
    <section class="lec-graficas">
        <br><br><br>
        <h1><b>REPRESENTACIÓN GRÁFICA DE LOS DATOS CAPTURADOS POR EL "AQUAV-3"</b></h1>
        <p>Dentro de este apartado se visualizan las gráficas generadas correspondientes a la fecha indicada.</p>
        <form method="post" action="">

            <label for="ano">Año:</label>
            <input type="text" name="ano" id="ano" value="" required><br><br>

            <label for="mes">Mes:</label>
            <input type="text" name="mes" id="mes" value="" required><br><br>

            <label for="dia">Día:</label>
            <input type="text" name="dia" id="dia" value="" required><br><br>

            <input type="submit" class="d-grid gap-2 col-2 mx-auto btn btn-danger" value="HUMEDAD">
            <br>
        </form>

        <input type="submit" class="d-grid gap-2 col-2 mx-auto btn btn-danger" value="TEMPERATURA">

        <figure class="highcharts-figure">  <br><br> <!--EDIT-->

            <div id="container"></div>
        </figure>
    </section>

    <script>
        Highcharts.chart('container', {
            title: {
                text: 'Humedad del Día',
                align: 'left'
            },

            subtitle: {
                text: '',
                align: 'left'
            },

            yAxis: {
                title: {
                    text: 'Humedad Relativa'
                }
            },

            xAxis: {
                title: {
                    text: 'Tiempo'
                },
                type: 'datetime',
            },

            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle'
            },

            series: [{
                name: 'Humedad Relativa',
                data: [<?php humedad_diaria($ano, $mes, $dia, $con); ?>]
            }]
        });
    </script>
</body>
</html>
