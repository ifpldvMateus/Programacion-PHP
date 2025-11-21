<html>
    <head>
        <title>EJ8AM – Operaciones con matrices 3x3</title>
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

            $matriz1 = $matriz2 = [];
            for ($i = 0; $i < 3; $i++) {
                for ($j = 0; $j < 3; $j++) {
                    $matriz1[$i][$j] = rand(1, 10); // Evitar ceros es mejor
                    $matriz2[$i][$j] = rand(1, 10);
                }
            }

            $suma = [];
            for ($i = 0; $i < 3; $i++) {
                for ($j = 0; $j < 3; $j++) {
                    $suma[$i][$j] = $matriz1[$i][$j] + $matriz2[$i][$j];
                }
            }

            $producto = [];
            for ($i = 0; $i < 3; $i++) {
                for ($j = 0; $j < 3; $j++) {
                    $producto[$i][$j] = 0;
                    for ($k = 0; $k < 3; $k++) {
                        $producto[$i][$j] += $matriz1[$i][$k] * $matriz2[$k][$j];
                    }
                }
            }

            mostrar_matriz($matriz1, "Matriz 1: ");
            mostrar_matriz($matriz2, "Matriz 2: ");

            mostrar_matriz($suma, "Suma: ");
            mostrar_matriz($producto, "Producto: ");

        ?>
    </body>
</html>