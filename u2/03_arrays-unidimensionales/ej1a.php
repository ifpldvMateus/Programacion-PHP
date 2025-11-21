<html>
    <head>
        <title>EJ1A – Números impares en una tabla</title>
    </head>
    <body>
        <table border="1" style="border-collapse: collapse;">
            <tr>
                <th width="75">Índice</th>
                <th width="75">Valor</th>
                <th width="75">Suma</th>
            </tr>
            <?php
                $impares = [];

                $impar = 1;
                $cont = 0;
                $suma = 0;

                while ($cont != 20) {
                    $impares[$cont] = $impar;
                    $suma += $impares[$cont];

                    echo "<tr>";
                    echo "<td>$cont</td>";
                    echo "<td>".$impares[$cont]."</td>";
                    echo "<td>$suma</td>";
                    echo "</tr>";

                    $impar += 2;
                    $cont++;
                }
            ?>
        </table>
    </body>
</html>
