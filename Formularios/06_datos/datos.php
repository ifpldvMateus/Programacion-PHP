<html>
    <head>
        <style>
            body {
                margin-top: 40px;
                margin-left: 80px;
            }

            table {
                margin: 20px 0;
            }

            th, td {
                padding: 2px 20px;
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
            }

            function mostrar($array) {
                echo "<table border='1'>";
                
                echo "<tr>";
                foreach (array_keys($array) as $clave) {
                    echo "<th>".$clave."</th>";
                }
                echo "</tr>";

                echo "<tr>";
                foreach ($array as $valor) {
                    echo "<td>".$valor."</td>";
                }
                echo "</tr>";

                echo "</table>";
            }

            function generar_txt($array, $nombre_archivo, $mensaje) {
                $archivo = fopen($nombre_archivo, "a");

                foreach ($array as $clave => $valor) {
                    fwrite($archivo, $clave.": ".$valor."\n");
                }

                fwrite($archivo, "\n-------------------------\n\n");
                fclose($archivo);

                echo "<a href='datos.txt'>$mensaje</a>";
            }
            
            echo "<h1>Datos Alumnos</h1>";

            // No uso 'required' en el formulario directamente porque label no lo admite, por lo que comprobaré todos los campos aquí por consistencia
            $obligatorios = ["nombre", "correo", "sexo"];
            foreach ($obligatorios as $campo) {
                if (empty($_POST[$campo])) {
                    echo "Completa todos los campos obligatorios";
                    exit;
                }
            }

            $persona = [
                "Nombre" => test_input($_POST["nombre"]),
                "Apellidos" => test_input($_POST["ape1"])." ".test_input($_POST["ape2"]),
                "Email" => test_input($_POST["correo"]),
                "Sexo" => test_input($_POST["sexo"])
            ];

            mostrar($persona);
            generar_txt($persona, "datos.txt", "Ver archivo de texto");
        ?>
    </body>
</html>