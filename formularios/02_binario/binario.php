<html>
    <head>
        <title>Conversor a binario</title>
        <style>
            form {
                max-width: 300px;
                margin: auto;
                text-align: left;
            }

            .campo {
                margin-bottom: 40px;
            }

            label {
                margin-right: 10px;
            }

            input[type="text"] {
                width: 150px;
            }

            h1 {
                text-align: center;
            }


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

            // Sé que existe la función "decbin", pero supongo que no tendría gracia usarla
            function decimal2bin($numero) {
                $cociente = $numero;
                $resultado = "";

                while ($cociente != 0) {
                    $resto = $cociente % 2;
                    $cociente = (int)($cociente / 2);

                    $resultado = $resto.$resultado;
                }

                return $resultado;
            }
            
            echo "<h1>CONVERSOR BINARIO</h1>";
            $numero = $_POST['decimal'];


            echo "<form>";

            echo "<div class='campo'><label for='entrada'>Número Decimal: </label>";
            echo "<input type='text' id='entrada' value='".$numero."' readonly></div>";

            echo "<div class='campo'><label for='resultado'>Número Binario: </label>";
            echo "<input type='text' id='resultado' value='".decimal2bin($numero)."' readonly></div>";

            echo "</form>";
        ?>
    </body>
</html>