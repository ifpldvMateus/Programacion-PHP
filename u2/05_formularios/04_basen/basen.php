<html>
    <head>
        <style>
            p {
                margin-top: 40px;
                text-align: center;
            }

        </style>
    </head>
    <body>
        <?php

            define("DIGITOS", "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ");

            // https://www.w3schools.com/php/php_form_validation.asp
            function test_input($data) {
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);

                return $data;
            }

            function extraer_base($formato) {
                $separador = strpos($formato, "/");
                if (!$separador) return null; // "/" no debería estar al inicio, y también debe estar en la cadena

                $formato = strtoupper(trim($formato));
                $numero = substr($formato, 0, $separador);
                $base = (int)substr($formato, $separador + 1);

                return (!is_numeric($base) || ($base < 2 || $base > 36) || strlen($numero) != strspn($numero, substr(DIGITOS, 0, $base))) ? null : ["num" => $numero, "base" => $base];
                // 'base' solo llega a substr() si ya se comprobó que es válido, por el short-circuit de PHP
                // Por esa misma razón primero se comprueba que 'base' sea un número. Después ya se puede comprobar si está en el rango esperado y demás
            }

            function convertir_b10($numero, $base_origen) {
                if ($base_origen == 10) return $numero;

                $numero = strrev($numero);
                $resultado = 0;

                for ($i = 0; $i < strlen($numero); $i++) {
                    $resultado += strpos(DIGITOS, $numero[$i]) * ($base_origen ** $i);
                }

                return $resultado;
            }

            function convertir($numero, $base_origen, $base_destino) {
                if ($base_origen == $base_destino || $numero == 0) return $numero;
                if ($base_destino < 2 || $base_destino > 36) return null;

                $cociente = convertir_b10($numero, $base_origen);
                $resultado = "";

                while ($cociente != 0) {
                    $resto = $cociente % $base_destino;
                    $cociente = (int)($cociente / $base_destino);

                    // Dejé de usar esto porque en la tabla ASCII los números y letras no están juntos (algo que necesitaba para la función convertir_b10), por lo que pensé en aprovechar para todas las funciones una string constante global con todos los dígitos necesarios
                    // if ($resto >= 10) $resto = chr(65 + ($resto - 10));

                    $resultado = DIGITOS[$resto].$resultado;
                }

                return $resultado;
            }

            if ($_POST["numero"] == "" || $_POST["base"] == "") {
                echo "<p>Debes completar todos los campos</p>";
                exit;
            }

            $formato = test_input($_POST["numero"]);
            $nueva_base = (int)$_POST["base"];

            $componentes = extraer_base($formato);
            if ($componentes == null) {
                echo "<p>Formato inválido: $formato<br>Asegúrate de que los dígitos del número especificado correspondan con su base de origen y que la base de origen sea válida</p>";
                exit;
            }

            $resultado = convertir($componentes["num"], $componentes["base"], $nueva_base);
            if ($resultado == null) {
                echo "<p>Base de destino inválida</p>";
                exit;
            }

            echo "<p>Número {$componentes['num']} en base {$componentes['base']} = $resultado en base $nueva_base</p>";
        ?>
    </body>
</html>