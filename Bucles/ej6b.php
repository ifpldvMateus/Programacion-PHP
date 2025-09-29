<html>
    <head>
        <title>EJ6B – Factorial</title>
    </head>
    <body>
    <?php
        $numero = 5;
        $resultado = 1;

        for ($i = 1; $i <= $numero; $i++) $resultado = $resultado * $i;

        echo "El factorial de $numero es: $resultado";
    ?>
    </body>
</html>
