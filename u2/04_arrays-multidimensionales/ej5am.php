<html>
    <head>
        <title>EJ5AM – Matriz con suma de índices</title>
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

            $matriz = [];
            for ($i = 0; $i < 5; $i++) {
                for ($j = 0; $j < 3; $j++) {
                    $matriz[$i][$j] = $i + $j;
                }
            }

            mostrar_matriz($matriz);

            echo "RECORRIDO POR COLUMNA: <br><br>";
            for ($i = 0; $i < count($matriz[0]); $i++) {
                for ($j = 0; $j < count($matriz); $j++) {
                    printf("(%d, %d) = %d<br>", $j + 1, $i + 1, $matriz[$j][$i]);
                }

                echo "<br>";
            }
        ?>
    </body>
</html>