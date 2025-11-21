<html>
    <head>
        <title>EJ4A – Array de binarios invertido</title>
    </head>
    <body>
        <?php
            function mostrar_tabla($array, $titulo) {
                echo "<h2>".$titulo."</h2>";
                
                echo <<<HTML
                <table border="1" style="border-collapse: collapse;">
                <tr>
                    <th width="75">Índice</th>
                    <th width="75">Binario</th>
                    <th width="75">Octal</th>
                </tr>
                HTML;

                foreach ($array as $i => $elemento) {
                    echo "<tr>";
                    echo "<td>$i</td>";
                    echo "<td>".$elemento."</td>";
                    echo "<td>".decoct(bindec($elemento))."</td>";
                    echo "</tr>";
                }

                echo "</table><br>";
            }

            $binarios = []; for ($i = 0; $i < 20; $i++) $binarios[$i] = decbin($i);
            $invertido = array_reverse($binarios);

            mostrar_tabla($binarios, "Array normal");
            mostrar_tabla($invertido, "Array invertido");
        ?>
    </body>
</html>
