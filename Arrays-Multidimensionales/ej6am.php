<html>
    <head>
        <title>EJ6AM – Máximos y promedios por fila de matriz aleatoria</title>
        <style>
            table {
                border-collapse: collapse;
                text-align: center;
                margin-bottom: 40px;
            }

            td {
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

                for ($i = 0; $i < count($matriz); $i++) {
                    echo "<tr>";
                    for ($j = 0; $j < count($matriz[0]); $j++) {
                        echo "<td>".$matriz[$i][$j]."</td>";
                    }
                    echo "</tr>";
                }

                echo "</table>";
            }

            function imprimir_array($array, $titulo) {
                echo $titulo;

                for ($i = 0; $i < count($array); $i++) {
                    echo "{$array[$i]}";

                    if ($i < count($array) - 1) echo ", "; 
                }

                echo "<br>";
            }

            $matriz = $maximos = $promedios = [];
            for ($i = 0; $i < 3; $i++) {
                $promedio = $max = 0;
                for ($j = 0; $j < 3; $j++) {
                    $matriz[$i][$j] = rand(0, 100);
                    
                    if ($matriz[$i][$j] > $max) $max = $matriz[$i][$j];
                    $promedio += $matriz[$i][$j];
                }
                
                $maximos[$i] = $max;
                $promedios[$i] = round($promedio / 3);
            }

            mostrar_matriz($matriz);
            imprimir_array($maximos, "Máximos por fila: ");
            imprimir_array($promedios, "Promedios por fila: ");

        ?>
    </body>
</html>