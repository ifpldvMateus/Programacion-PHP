<html>
    <head>
        <title>EJ3B – Conversor Decimal a base 16</title>
    </head>
    <body>
    <?php
        $numero = 48;

        $cociente = $numero;
        $resultado = "";

        while ($cociente != 0) {
            $resto = $cociente % 16;
            $cociente = (int)($cociente / 16);

            if ($resto >= 10) { // Evitar procesamiento innecesario
                if ($resto == 10) $resto = "A";
                elseif ($resto == 11) $resto = "B";
                elseif ($resto == 12) $resto = "C";
                elseif ($resto == 13) $resto = "D";
                elseif ($resto == 14) $resto = "E";
                elseif ($resto == 15) $resto = "F";
            }

            $resultado = $resto.$resultado;
        }

        echo "El número $numero en hexadecimal es: $resultado";
    ?>
    </body>
</html>
