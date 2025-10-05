<html>
    <head>
        <title>EJ7AM – Notas de alumnos</title>
        <style>
            table {
                border-collapse: collapse;
                text-align: center;
                margin-bottom: 40px;
            }

            td, th {
                width: 70px;
                height: 20px;
                text-align: center;
                border: 1px solid black;
            }
        </style>
    </head>
    <body>
        <?php
            function mostrar_matriz($matriz) {
                echo "<table>";

                echo "<tr>";
                echo "<th></th>";
                foreach (array_keys($matriz) as $clave) {
                    echo "<th>$clave</th>";
                }
                echo "</tr>";

                foreach (array_keys(reset($matriz)) as $clave) {
                    echo "<tr>";
                    echo "<th>$clave</th>";
                    foreach ($matriz as $array) {
                        echo "<td>{$array[$clave]}</td>";
                    }
                    echo "</tr>";
                }

                echo "</table>";
            }

            function imprimir_array($array, $titulo) {
                echo "<br>$titulo<br><br>";

                foreach ($array as $clave => $valor) {
                    echo "$clave: $valor<br>";
                }

                echo "<br>";
            }

            $asignaturas = ["Python", "DWEC", "DWES", "DIW"];
            $alumnos = ["Carlos", "Fernando", "Isabel", "Juan", "Carla", "Adrián", "Alba", "María", "Marcos", "Ana"];

            $notas = [];

            foreach ($asignaturas as $asig) {
                $fila = [];
                foreach ($alumnos as $alumno) {
                    $fila[$alumno] = round(rand(300, 1000) / 100, 1);
                }
                $notas[$asig] = $fila;
            }

            mostrar_matriz($notas);


            $asig_maximas = $asig_minimas = $asig_media = [];
            foreach (array_keys($notas) as $asig) {
                $max = $min = key($notas[$asig]);
                $media = 0;
                foreach ($notas[$asig] as $alumno => $nota) {
                    if ($nota > $notas[$asig][$max]) $max = $alumno;
                    if ($nota < $notas[$asig][$min]) $min = $alumno;
                    $media += $nota;
                }

                $asig_maximas[$asig] = $max;
                $asig_minimas[$asig] = $min;
                $asig_media[$asig] = round($media / count($notas[$asig]), 1);
            }

            $alu_maximas = $alu_minimas = $alu_media = [];
            foreach (array_keys(reset($notas)) as $alumno) { // arrays_keys() es para obtener sólo las claves, ya que no me interesa el valor
                $max = $min = key($notas);
                $media = 0;
                foreach ($notas as $asig => $notas_alumno) {
                    if ($notas_alumno[$alumno] > $notas[$max][$alumno]) $max = $asig;
                    if ($notas_alumno[$alumno] < $notas[$min][$alumno]) $min = $asig;
                    $media += $notas_alumno[$alumno];
                }

                $alu_maximas[$alumno] = $max;
                $alu_minimas[$alumno] = $min;
                $alu_media[$alumno] = round($media / count($notas), 1);
            }

            
            imprimir_array($asig_maximas, "Alumno con mejor nota de cada asignatura: ");
            imprimir_array($asig_minimas, "Alumno con peor nota de cada asignatura: ");
            imprimir_array($asig_media, "Media de notas por asignatura de todos los alumnos: ");

            imprimir_array($alu_maximas, "Asignatura con mejor nota de cada alumno: ");
            imprimir_array($alu_minimas, "Asignatura con peor nota de cada alumno: ");
            imprimir_array($alu_media, "Media de notas por alumno de todas las asignatura: ");

        ?>
    </body>
</html>