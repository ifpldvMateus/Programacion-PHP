<html>
    <head>
        <title>Conversor a binario</title>
        <style>

            h1 {
                text-align: center;
            }

            form {
                max-width: 300px;
                margin: auto auto 40px auto;
                text-align: left;
            }

            label {
                display: inline-block;
                width: 120px;
            }

            input[type="number"], input[type="text"] {
                display: inline-block;
                width: 150px;
            }

            .botones {
                text-align: left;
                margin-top: 15px;
            }

            .campo {
                margin-bottom: 40px;
            }

            .campo label {
                margin-right: 10px;
            }

            .campo input[type="text"] {
                width: 150px;
            }
        </style>

    </head>
    <body>
        <h1>CONVERSOR BINARIO</h1>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
            <label for="decimal">Número decimal: </label>
            <input type="number" id="decimal" name="decimal">

            <div class="botones">
                <input type="submit" value="Calcular">
                <input type="reset" value="Borrar">
            </div>
        </form>
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
            
            if ($_SERVER["REQUEST_METHOD"] == "POST") { 
                $numero = $_POST['decimal'];

                echo "<form>";

                echo "<div class='campo'><label for='entrada'>Número Decimal: </label>";
                echo "<input type='text' id='entrada' value='".$numero."' readonly></div>";

                echo "<div class='campo'><label for='resultado'>Número Binario: </label>";
                echo "<input type='text' id='resultado' value='".decimal2bin($numero)."' readonly></div>";

                echo "</form>";
            }
        ?>
    </body>
</html>