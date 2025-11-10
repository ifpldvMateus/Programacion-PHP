<html>
    <head>
        <style>
            body {
                margin-top: 40px;
                margin-left: 80px;
            }

            table {
                border-collapse: collapse;
                text-align: center;
                margin-bottom: 40px;
            }

            td, th {
                text-align: center;
                border: 1px solid black;
            }

            td {
                padding: 5px;    
            }

            th {
                padding: 0 40px;
            }

            td img {
                /* 1/3 */
                width: 56px;
                height: 77px;
            }

            .resultado {
                margin: 20px 0;
            }

            .resultado p {
                margin: 0;
            }

        </style>
    </head>
    <body>
        <?php
            require ("pokerldv_fun.php");

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $campos = [];

                foreach ($_POST as $clave => $valor) {
                    $campos[$clave] = test_input($valor);

                    if (strlen($campos[$clave]) == 0) {
                        echo "<p>Todos los campos son obligatorios. Intenta de nuevo</p>";
                        exit;
                    }

                    if ($clave == "bote") { // "bote" es el único campo numérico a comprobar
                        if (!ctype_digit($campos[$clave])) {
                            echo "<p>Valor numérico no admitido: {$campos[$clave]}</p>";
                            exit;
                        }
                    }
                }

                $nombres = [];
                foreach ($campos as $clave => $valor) {
                    if (substr($clave, 0, 6) == "nombre") {
                        $nombres[] = $valor;
                    }
                }

                $jugadores = reparto($nombres);
                $partida = jugar($jugadores);

                mostrar_manos($jugadores);
                mostrar_jugadas($partida);
                
                $resultado = resultados_partida($partida, $campos["bote"]);
                mostrar_resultado($resultado);
            }
        ?>
    </body>
</html>