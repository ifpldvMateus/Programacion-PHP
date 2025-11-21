<html>
    <head>
        <title>EJ9AM – Matriz traspuesta</title>
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
            function mostrar_matriz($matriz, $titulo) {
                echo "$titulo<br>";
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
            for ($i = 0; $i < 3; $i++) {
                for ($j = 0; $j < 4; $j++) {
                    $matriz[$i][$j] = rand(1, 10);
                }
            }

            $traspuesta = [];
            for ($i = 0; $i < 3; $i++) {
                for ($j = 0; $j < 4; $j++) {
                    $traspuesta[$j][$i] = $matriz[$i][$j];
                }
            }

            mostrar_matriz($matriz, "Matriz original (3x4):");
            mostrar_matriz($traspuesta, "Matriz traspuesta (4x3):");
        ?>
    </body>
</html>