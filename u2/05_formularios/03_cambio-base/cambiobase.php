<html>
    <head>
        <title>Conversor numérico</title>
        <style>
            h1, p {
                text-align: center;
            }

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

            table {
                margin: auto;
                text-align: center;
            }

            td {
                padding: 5px 10px; 
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

            function convertir($numero, $sistema) {
                
                if ($sistema == "Todos") {
                    return [
                        "Binario" => decbin($numero),
                        "Octal" => decoct($numero),
                        "Hexadecimal" => dechex($numero)
                    ];
                }
                else {
                    switch ($sistema) {
                        case "Binario":
                            return [$sistema => decbin($numero)];
                        case "Octal":
                            return [$sistema => decoct($numero)];
                        case "Hexadecimal":
                            return [$sistema => dechex($numero)];
                    }
                }
            }

            function mostrar($array) {
                echo "<table border='1'>";

                foreach ($array as $clave => $valor) {
                    echo "<tr>";
                    echo "<td>$clave</td>";
                    echo "<td>$valor</td>";
                    echo "</tr>";
                }

                echo "</table>";
            }

            echo "<h1>CONVERSOR NUMÉRICO</h1>";

            if (!isset($_POST["sistema"]) || $_POST["numero"] == "") {
                echo "<p>Debes completar todos los campos</p>";
                exit;
            }

            $numero = $_POST["numero"];
            $sistema = $_POST["sistema"];

            echo "<form>";

            echo "<div class='campo'><label for='entrada'>Número Decimal: </label>";
            echo "<input type='text' id='entrada' value='".$numero."' readonly></div>";

            echo "</form>";

            mostrar(convertir($numero, $sistema));
        ?>
    </body>
</html>