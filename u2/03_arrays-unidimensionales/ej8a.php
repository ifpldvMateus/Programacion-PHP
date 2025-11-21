<html>
    <head>
        <title>EJ8A – Arrays asociativos 2</title>
    </head>
    <body>
        <?php
            $notas = [
                "Ana" => 8,
                "Carlos" => 3,
                "Luis" => 7,
                "Pedro" => 10,
                "María" => 4
            ];

            $max_nota = max($notas);
            $min_nota = min($notas);

            echo "Alumno con mayor nota: ".array_search($max_nota, $notas)." ($max_nota)<br>";
            echo "Alumno con menor nota: ".array_search($min_nota, $notas)." ($min_nota)<br>";
            echo "Media de notas: ".array_sum($notas) / count($notas)."<br>";
        ?>
    </body>
</html>
