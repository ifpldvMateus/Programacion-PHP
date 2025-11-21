<html>
    <head>
        <title>EJ2A – Números impares en una tabla y medias</title>
    </head>
    <body>
        <?php
            echo <<<HTML
            <table border="1" style="border-collapse: collapse;">
            <tr>
                <th width="75">Índice</th>
                <th width="75">Valor</th>
                <th width="75">Suma</th>
            </tr>
            HTML;

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

            echo "</table><br>";

            $media_pares = 0;
            $media_impares = 0;
            for ($i = 0; $i < 20; $i++) {
                if ($i % 2 == 0) $media_pares += $impares[$i];
                else $media_impares += $impares[$i];            
            }

            $media_pares /= 10;
            $media_impares /= 10;

            echo "Media en posiciones pares: $media_pares<br>";
            echo "Media en posiciones impares: $media_impares";
        ?>
    </body>
</html>
