<html>
    <head>
        <title>EJ1B – Conversor decimal a binario</title>
    </head>
    <body>
    <?php
        $numero = 168;
        $cociente = $numero;
        $resultado = "";

        while ($cociente != 0) {
            $resto = $cociente % 2;
            $cociente = (int)($cociente / 2);

            $resultado = $resto.$resultado;
        }
        
        echo "El número $numero en binario es: $resultado";
    ?>
    </body>
</html>
