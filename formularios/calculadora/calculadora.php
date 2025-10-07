<html>
    <head>
        <title>Calculadora</title>
        <style>
        </style>
    </head>
    <body>
        <?php

            // https://www.w3schools.com/php/php_form_validation.asp
            function test_input($data) {
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);

                return $data;
            } // No se usa en este ejercicio porque el formulario no usa campos de texto
            
            echo "<h1>CALCULADORA</h1>";

            $operadores = [
                "suma" => "+",
                "resta" => "-",
                "prod" => "*",
                "div" => "/"
            ];

            $operacion = $_POST['operacion'];
            $op1 = $_POST['op1'];
            $op2 = $_POST['op2'];

            $resultado =
                ($operacion == "suma") ? $op1 + $op2 :
                ($operacion == "resta") ? $op1 - $op2 :
                ($operacion == "prod") ? $op1 * $op2 :
                ($operacion == "div" && $op2 != 0) ? $op1 / $op2 :
                "indefinido";

            echo "$op1 {$operadores[$operacion]} $op2 = $resultado";
        ?>
    </body>
</html>
