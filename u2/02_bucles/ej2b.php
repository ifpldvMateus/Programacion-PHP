<html>
    <head>
        <title>EJ2B – Conversor Decimal a base n</title>
    </head>
    <body>
    <?php
        $numero = 48;
        $base = 8;
        $cociente = $numero;
        $resultado = "";

        while ($cociente != 0) {
            $resto = $cociente % $base;
            $cociente = (int)($cociente / $base);

            $resultado = $resto.$resultado;
        }
        
        echo "El número $numero en base $base es: $resultado";
    ?>
    </body>
</html>
