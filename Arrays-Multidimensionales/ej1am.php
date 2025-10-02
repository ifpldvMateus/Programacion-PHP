<html>
    <head>
        <title>EJ1AM – Matriz 3x3 con múltiplos de 2</title>
        <style>
            .borde {
                border: 1px solid black;
            }
            td {
                width: 50px;
                height: 20px;
                text-align: center;
            }
        </style>
    </head>
    <body>
        <?php
            $multiplos = [];
            $multiplo = 2;
            $cont = 1;

            echo "<table style=\"border-collapse: collapse;\">";
            echo "<tr>";
            echo "<td/>";
            echo "<td>Col 1</td>";
            echo "<td>Col 2</td>";
            echo "<td>Col 3</td>";
            echo "</tr>";

            for ($i = 0; $i < 3; $i++) {
                echo "<tr>";
                echo "<td>Fila ".($i + 1)."</td>";
                for ($j = 0; $j < 3; $j++) {
                    $multiplos[$i][$j] = $multiplo * $cont;
                    $cont++;

                    echo "<td class=\"borde\">".$multiplos[$i][$j]."</td>";
                }
                echo "</tr>";
            }

            echo "</table>";
        ?>
    </body>
</html>
