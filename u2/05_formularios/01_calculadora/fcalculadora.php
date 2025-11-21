<html>
    <head>
        <title>Calculadora</title>
        <style>
            form {
                max-width: 300px;
                margin: auto;
                text-align: left;
            }

            label, input[type="number"] {
                display: block;
                width: 100%;
                margin: 10px 0;
            }

            .radio input[type="radio"] {
                margin-right: 5px;
            }

            .radio label {
                display: flex;
                align-items: center;
                margin: 2px 0;
            }

            h1, p {
                text-align: center;
                margin-top: 40px;
            }

        </style>

    </head>
    <body>
        <h1>CALCULADORA</h1>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
            <label for="op1">Operando 1</label>
            <input type="number" id="op1" name="op1">

            <label for="op2">Operando 2</label>
            <input type="number" id="op2" name="op2">

            <label>Selecciona operación:</label>
            <div class="radio">
                <label><input type="radio" name="operacion" value="suma"> Suma</label>
                <label><input type="radio" name="operacion" value="resta"> Resta</label>
                <label><input type="radio" name="operacion" value="prod"> Producto</label>
                <label><input type="radio" name="operacion" value="div"> División</label>
            </div>

            <input type="submit" value="Calcular">
            <input type="reset" value="Borrar">
        </form>

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

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

                if (isset($operadores[$operacion])) echo "<p>$op1 {$operadores[$operacion]} $op2 = $resultado</p>";
            }
        ?>
    </body>
</html>