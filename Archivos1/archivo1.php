<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <style>
            form {
                max-width: 300px;
                margin: 15px auto auto;
                text-align: left;
            }

            label, input[type="text"], input[type="date"] {
                display: block;
                width: 100%;
                margin: 10px 0;
            }

            h3, p {
                text-align: center;
                margin: 20px auto;
            }
        </style>

    </head>
    <body>

        <h3>Escribe tus datos</h3>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required>

            <label for="base">Primer apellido:</label>
            <input type="text" id="apellido1" name="apellido1" required>

            <label for="apellido2">Segundo apellido:</label>
            <input type="text" id="apellido2" name="apellido2" required>

            <label for="nacimiento">Fecha de nacimiento:</label>
            <input type="date" id="nacimiento" name="nacimiento" required>

            <label for="localidad">Localidad:</label>
            <input type="text" id="localidad" name="localidad" required>

            <input type="submit" value="Enviar datos">
            <input type="reset" value="Borrar">
        </form>

        <?php
            define("nombre_archivo", "alumnos1.txt");
            // https://www.w3schools.com/php/php_form_validation.asp
            function test_input($data) {
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);

                return $data;
            }

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                
                $datos = [];
                $posiciones = [
                    "nombre" => ["inicio" => 1,   "fin" => 40],
                    "apellido1" => ["inicio" => 41,  "fin" => 81],
                    "apellido2" => ["inicio" => 82,  "fin" => 123],
                    "nacimiento" => ["inicio" => 124, "fin" => 133],
                    "localidad" => ["inicio" => 134, "fin" => 160]
                ];
				
                $archivo = fopen(nombre_archivo, "a+");

                foreach ($_POST as $clave => $valor) {
                    $longitud_col = $posiciones[$clave]["fin"] - $posiciones[$clave]["inicio"] + 1;
                    $datos[$clave] = substr(test_input($valor), 0, $longitud_col);

                    fwrite($archivo, str_pad($datos[$clave], $longitud_col));
                }
                
                fwrite($archivo, "\n");
                fclose($archivo);
            }
        ?>
    </body>
</html>
