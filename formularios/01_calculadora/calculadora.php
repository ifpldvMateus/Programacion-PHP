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


            // Usaría funciones flecha, pero la versión de PHP del servidor es más antigua 
            function suma($a, $b) { return $a + $b; }
            function resta($a, $b) { return $a - $b; }
            function prod($a, $b) { return $a * $b; }
            function div($a, $b) { return ($b != 0) ? $a / $b : "indefinido"; }
            
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

            if ($operacion == "suma") $resultado = suma($op1, $op2);
            elseif ($operacion == "resta") $resultado = resta($op1, $op2);
            elseif ($operacion == "prod") $resultado = prod($op1, $op2);
            elseif ($operacion == "div") $resultado = div($op1, $op2);

            if (isset($operadores[$operacion])) echo "$op1 {$operadores[$operacion]} $op2 = $resultado";
        ?>
    </body>
</html>