<html>
    <head>
        <title>EJ3AM – Recorrido por fila y por columna</title>
        <style>
            table {
                border-collapse: collapse;
                text-align: center;
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

            echo "<br><br>RECORRIDO POR FILA: <br><br>";
            for ($i = 0; $i < count($matriz); $i++) {
                for ($j = 0; $j < count($matriz[0]); $j++) {
                    printf("(%d, %d) = %d<br>", $i + 1, $j + 1, $matriz[$i][$j]);
                }

                echo "<br>";
            }

            echo "<br><br>RECORRIDO POR COLUMNA: <br><br>";

            for ($i = 0; $i < count($matriz[0]); $i++) {
                for ($j = 0; $j < count($matriz); $j++) {
                    printf("(%d, %d) = %d<br>", $j + 1, $i + 1, $matriz[$j][$i]);
                }

                echo "<br>";
            }
        ?>
    </body>
</html>