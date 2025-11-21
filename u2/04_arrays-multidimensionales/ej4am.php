<html>
    <head>
        <title>EJ4AM – Número máximo en matriz</title>
        <style>
            table {
                border-collapse: collapse;
                text-align: center;
                margin-bottom: 20px;
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


            $matriz = [
                [2, 4, 6, 9, 7],
                [8, 10, 12, 1, 12],
                [14, 16, 88, 3, 15]
            ];

            mostrar_matriz($matriz);

            $max = $fila = $columna = 0;
            for ($i = 0; $i < count($matriz); $i++) {
                for ($j = 0; $j < count($matriz[0]); $j++) {
                    if ($matriz[$i][$j] > $max) {
                        $max = $matriz[$i][$j];
                        $fila = $i + 1;
                        $columna = $j + 1;
                    }
                }
            }

            echo "Elemento Mayor: $max - fila $fila columna $columna";

        ?>
    </body>
</html>