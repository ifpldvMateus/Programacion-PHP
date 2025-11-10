<?php
    // https://www.w3schools.com/php/php_form_validation.asp
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);

        return $data;
    }

    function mostrar_manos($jugadores) {
        echo "<table>";

        foreach ($jugadores as $c_nombre => $mano) {
            echo "<tr>";
            echo "<th>$c_nombre</th>";
            foreach ($mano as $carta) {
                echo "<td><img src='images/".$carta["valor"].$carta["id"].".PNG'></td>";
            }

            echo "</tr>";
        }

        echo "</table>";
    }

    function mostrar_jugadas($partida) {
        echo "<table>";

        foreach ($partida as $nombre => $valor_jugada) {
            echo "<tr>";
            echo "<th>$nombre</th>";
            echo "<td>".obtener_jugada($valor_jugada)."</td>";
            echo "</tr>";
        }

        echo "</table>";
    }

    function mostrar_resultado($resultado) {
        echo "<div class='resultado'>";

        echo "====";
        echo "<p>Bote: {$resultado['bote']}</p><br>";
        echo "<br><p>Mejor jugada: {$resultado['jugada']}<p><br>";

        if (!empty($resultado["ganadores"])) {
            foreach ($resultado["ganadores"] as $nombre)
                echo "<p>$nombre ha ganado la partida</p>";
        }
        else {
            echo "<p>NO hay ganadores</p>";
        }

        echo "<br><p>Se han repartido ".$resultado["premio"]."€ de premio a cada ganador<p>";

        echo "</div>";
    }

    function nueva_baraja() {
        $palos = ["C", "D", "P", "T"];
        $valores = ["1", "J", "K", "Q"];

        $baraja_especial = [];
        foreach ($palos as $palo) {
            for ($i = 1; $i <= 2; $i++) {
                $baraja_especial[$palo.$i] = $valores;
            }
        }

        return $baraja_especial;
    }

    function reparto($nombres) {
        $baraja = nueva_baraja();

        $jugadores = [];
        foreach ($nombres as $nombre) {
            $mano = [];
            for ($i = 0; $i < 4; $i++) {
                $id = array_rand($baraja);
                $valor = array_rand($baraja[$id]);

                $mano[] = ["id" => $id, "valor" => $baraja[$id][$valor]]; // Carta

                unset($baraja[$id][$valor]);
                $baraja[$id] = array_values($baraja[$id]); // Reindexar para evitar "huecos"
                if (empty($baraja[$id]))
                    unset($baraja[$id]);
            }

            $jugadores[$nombre] = $mano;
        }
        
        return $jugadores;
    }

    function obtener_valor_jugada($coincidencias) {
        $contador = array_count_values($coincidencias);
        
        $resultado = 0;
        if (isset($contador[2])) $resultado = ($contador[2] == 2) ? 2 : 1;
        if (isset($contador[3])) $resultado = 3;
        if (isset($contador[4])) $resultado = 4;

        return $resultado;
    }

    function jugar($jugadores) {
        $partida = [];
        foreach ($jugadores as $nombre => $mano) {
            $coincidencias_jugador = [
                "1" => 0,
                "J" => 0,
                "K" => 0,
                "Q" => 0
            ];

            foreach ($mano as $carta) {
                $coincidencias_jugador[$carta["valor"]]++;
            }

            $partida[$nombre] = obtener_valor_jugada($coincidencias_jugador);
        }

        return $partida;
    }

    // Podríamos usar una constante global (define)
    function obtener_jugada($valor) {
        $jugadas = ["N/A", "Pareja", "Doble Pareja", "Trío", "Póker"];
        
        return $jugadas[$valor];
    }

    function resultados_partida($partida, $bote) {
        $porcentajes = [0, 0, 0.5, 0.7, 1];

        $max_jugada = max($partida);
        $nombres = [];
        if ($max_jugada > 0)
            $nombres = array_keys(array_filter($partida, function($v) use ($max_jugada) { return $v == $max_jugada; }));

        return [
            "bote" => $bote,
            "premio" => ($bote * $porcentajes[$max_jugada]) / count($nombres),
            "jugada" => obtener_jugada($max_jugada),
            "ganadores" => $nombres
        ];
    }
?>