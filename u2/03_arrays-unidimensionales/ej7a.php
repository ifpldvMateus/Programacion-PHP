<html>
    <head>
        <title>EJ7A – Arrays asociativos</title>
    </head>
    <body>
        <?php
            $alumnos = [
                "Ana" => 22,
                "Carlos" => 30,
                "Luis" => 17,
                "Pedro" => 18,
                "María" => 20
            ];

            foreach ($alumnos as $nombre => $edad) {
                echo "$nombre tiene $edad años<br>";
            }

            reset($alumnos);
            next($alumnos);
            echo "<br>Valor en la segunda posición: ".current($alumnos);

            next($alumnos);
            echo "<br>Valor en la siguiente posición: ".current($alumnos);

            end($alumnos);
            echo "<br>Valor en la última posición: ".current($alumnos)."<br>";



            asort($alumnos);

            reset($alumnos);
            echo "<br>Primera posición del array asociativo ordenado ascendentemente por valor: ".current($alumnos);
            end($alumnos);
            echo "<br>Última posición del array asociativo ordenado ascendentemente por valor: ".current($alumnos); 
        ?>
    </body>
</html>
