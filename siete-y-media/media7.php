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

            function nueva_baraja() {
                $baraja_francesa = [
                    "C" => [],
                    "D" => [],
                    "P" => [],
                    "T" => []
                ];
                $valores = [1, 2, 3, 4, 5, 6, 7, "J", "K", "Q"];

                foreach ($baraja_francesa as $clave => $valor) {
                    for ($j = 0; $j < count($valores); $j++) {
                        $baraja_francesa[$clave][] = $valores[$j];
                    }
                }

                return $baraja_francesa;
            }

            function reparto($num_cartas, $num_jugadores, &$baraja) {
                $num_cartas = min($num_cartas, 40 / $num_jugadores);
                
                $palos = array_keys($baraja);
                $mano = [];

                for ($i = 0; $i < $num_cartas; $i++) {
                    $p_indice = rand(0, count($palos) - 1);
                    $palo = $palos[$p_indice];

                    $v_indice = rand(0, count($baraja[$palo]) - 1);
                    $valor = $baraja[$palo][$v_indice];

                    unset($baraja[$palo][$v_indice]);
                    $baraja[$palo] = array_values($baraja[$palo]); // Reindexar para evitar "huecos"

                    if (count($baraja[$palo]) == 0) {
                        unset($palos[$p_indice]);
                        $palos = array_values($palos);
                    }

                    $mano[] = $palo.$valor; // Pensar si usar un array asociativo llamado carta
                }

                return $mano;
            }

            $num_cartas = test_input($_POST["numcartas"]);
            $apuesta = test_input($_POST["apuesta"]);


            $jugadores = [];
            $baraja_partida = nueva_baraja();
            foreach ($_POST as $clave => $valor) {
                if (substr($clave, 0, 6) == "nombre") {
                    $jugadores[test_input($valor)] = reparto($num_cartas, 4, $baraja_partida);
                }
            }

            print_r($jugadores);
        ?>
    </body>
</html>