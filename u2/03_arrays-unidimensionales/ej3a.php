<html>
    <head>
        <title>EJ3A – Array de binarios</title>
    </head>
    <body>
        <table border="1" style="border-collapse: collapse;">
            <tr>
                <th width="75">Índice</th>
                <th width="75">Binario</th>
                <th width="75">Octal</th>
            </tr>
            <?php
                $binarios = [];

                for ($i = 0; $i < 20; $i++) {
                    $binarios[$i] = decbin($i);

                    echo "<tr>";
                    echo "<td>$i</td>";
                    echo "<td>".$binarios[$i]."</td>";
                    echo "<td>".decoct(bindec($binarios[$i]))."</td>";
                    echo "</tr>";
                }
            ?>
        </table>
    </body>
</html>
