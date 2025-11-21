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
                echo "<td><img src='images/".$carta["valor"].$carta["palo"].".PNG'></td>";
            }

            echo "</tr>";
        }

        echo "</table>";
    }

    function mostrar_resultado($resultado) {
        echo "<div class='resultado'>";

        if (!empty($resultado["ganadores"])) {
            foreach ($resultado["ganadores"] as $nombre) {
                echo "<p>$nombre ha ganado la partida con ".$resultado["max"]." puntos</p>";
            }

            echo "<p>Los ganadores han obtenido ".$resultado["premio"]."€ de premio<p>";
        }
        else {
            echo "<p>NO hay ganadores el bote acumulado es de {$resultado['apuesta']}</p>";
        }

        echo "</div>";
    }

    function guardar_partida($puntuaciones, $resultado) {
        
        $carpeta = "registros";
        if (!file_exists($carpeta)) {
            mkdir($carpeta);
        }

        $archivo = fopen($carpeta."/apuestas_".date("dmyHis").".txt", "w");

        foreach ($puntuaciones as $nombre => $puntuacion) {
            $premio = 0;
            if (in_array($nombre, $resultado["ganadores"]))
                $premio = $resultado["premio"];

            fwrite($archivo, extraer_iniciales($nombre)."#$puntuacion#$premio\n");
        }

        $num_ganadores = count($resultado["ganadores"]);
        fwrite($archivo, "TOTALPREMIOS#$num_ganadores#".$num_ganadores * $resultado["premio"]);

        fclose($archivo);
    }

    function extraer_iniciales($nombre) {
        $iniciales = "";
        foreach (explode(" ", $nombre) as $unidad) {
            $iniciales = $iniciales.$unidad[0];
        }

        return $iniciales;
    }

    function nueva_baraja() {
        $baraja_francesa = [
            "C" => [],
            "D" => [],
            "P" => [],
            "T" => []
        ];
        $valores = ["1", "2", "3", "4", "5", "6", "7", "J", "K", "Q"];

        foreach ($baraja_francesa as $clave => $valor) {
            for ($j = 0; $j < count($valores); $j++) {
                $baraja_francesa[$clave][] = $valores[$j];
            }
        }

        return $baraja_francesa;
    }

    function reparto($nombres, $num_cartas) {
        $num_cartas = max(min($num_cartas, 40 / count($nombres)), 1);
        $baraja = nueva_baraja();
        
        $jugadores = [];
        foreach ($nombres as $nombre) {
            $mano = [];
            for ($i = 0; $i < $num_cartas; $i++) {
                $palo = array_rand($baraja);
                $valor = array_rand($baraja[$palo]);

                $mano[] = ["palo" => $palo, "valor" => $baraja[$palo][$valor]]; // Carta

                unset($baraja[$palo][$valor]);
                $baraja[$palo] = array_values($baraja[$palo]); // Reindexar para evitar "huecos"
                if (empty($baraja[$palo]))
                    unset($baraja[$palo]);
            }

            $jugadores[$nombre] = $mano;
        }
        
        return $jugadores;
    }

    function jugar_partida($jugadores) {
        $puntuaciones = [];
        foreach ($jugadores as $nombre => $mano) {
            $puntuaciones[$nombre] = 0;

            foreach ($mano as $carta) {
                $puntuaciones[$nombre] += (ctype_digit($carta["valor"])) ? $carta["valor"] : 0.5;
            }
        }

        return $puntuaciones;
    }

    function resultado_partida($puntuaciones, $apuesta) {
        /* $resultado = [
            "premio" => null,
            "max" => null,
            "ganadores" => []
        ]; */

        $premio = 0;
        $max = null;
        $parte_ganadora = [];

        arsort($puntuaciones);

        foreach ($puntuaciones as $jugador => $valor) {
            if ($valor <= 7.5) {
                if ($max === null)
                    $max = $valor;

                if ($valor == $max)
                    $parte_ganadora[] = $jugador;
            }
        }

        if ($max !== null)
            $premio = ($apuesta * (($max == 7.5) ? 0.8 : 0.5)) / count($parte_ganadora);

        /*
        // No me termina de convencer porque se hacen bastantes recorridos internos

        $parte_ganadora = array_filter($puntuaciones, function($v) { return $v <= 7.5; });
        if (empty($parte_ganadora)) return $resultado; // $resultado empieza con las tres claves sin valor

        $max = max($parte_ganadora);
        $parte_ganadora = array_keys(array_filter($parte_ganadora, function($v) use ($max) { return $v == $max; }));
        */

        return [
            "premio" => $premio,
            "apuesta" => $apuesta,
            "max" => $max,
            "ganadores" => $parte_ganadora
        ];
    }
?>