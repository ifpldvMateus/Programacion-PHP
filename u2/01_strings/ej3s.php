<html>
    <head>
        <title>EJ2-Direccion Red – Broadcast y Rango</title>
    </head>
    <body>
    <?php

        // $ip = "192.168.16.100/16";
        // $ip = "192.168.16.100/21";
        $ip = "10.33.15.100/8";


        $masc = substr($ip, strpos($ip, "/") + 1);
        $ip_sin_masc = substr($ip, 0, strpos($ip, "/"));

        // Extraer octetos
        $pos1 = strpos($ip_sin_masc, ".");
        $pos2 = strpos($ip_sin_masc, ".", $pos1 + 1);
        $pos3 = strpos($ip_sin_masc, ".", $pos2 + 1);

        $octeto1 = substr($ip_sin_masc, 0, $pos1);
        $octeto2 = substr($ip_sin_masc, $pos1 + 1, ($pos2 - $pos1) - 1);
        $octeto3 = substr($ip_sin_masc, $pos2 + 1, ($pos3 - $pos2) - 1);
        $octeto4 = substr($ip_sin_masc, $pos3 + 1);

        // Convertir IP a binario
        $ipbin = 
            str_pad(decbin($octeto1), 8, "0", STR_PAD_LEFT).
            str_pad(decbin($octeto2), 8, "0", STR_PAD_LEFT).
            str_pad(decbin($octeto3), 8, "0", STR_PAD_LEFT).
            str_pad(decbin($octeto4), 8, "0", STR_PAD_LEFT);

        // Obtener dirección de red y broadcast en binario
        $red_bin = str_pad(substr($ipbin, 0, $masc), 32, "0", STR_PAD_RIGHT);
        $broad_bin = str_pad(substr($ipbin, 0, $masc), 32, "1", STR_PAD_RIGHT);

        // Obtener rango de direcciones
        $rango1_bin = substr_replace($red_bin, "1", 31, 1);
        $rango2_bin = substr_replace($broad_bin, "0", 31, 1);

        // Convertir de binario a IP
        $red = bindec(substr($red_bin, 0, 8)).".".bindec(substr($red_bin, 8, 8)).".".bindec(substr($red_bin, 16, 8)).".".bindec(substr($red_bin, 24, 8));
        $broad = bindec(substr($broad_bin, 0, 8)).".".bindec(substr($broad_bin, 8, 8)).".".bindec(substr($broad_bin, 16, 8)).".".bindec(substr($broad_bin, 24, 8));
        $rango1 = bindec(substr($rango1_bin, 0, 8)).".".bindec(substr($rango1_bin, 8, 8)).".".bindec(substr($rango1_bin, 16, 8)).".".bindec(substr($rango1_bin, 24, 8));
        $rango2 = bindec(substr($rango2_bin, 0, 8)).".".bindec(substr($rango2_bin, 8, 8)).".".bindec(substr($rango2_bin, 16, 8)).".".bindec(substr($rango2_bin, 24, 8));

        
        echo "IP: $ip</br>";
        echo "Máscara: $masc</br>";
        echo "Dirección de red: $red</br>";
        echo "Dirección de broadcast: $broad</br>";
        echo "Rango: $rango1 - $rango2";



        /*
        
        === HECHO CON BUCLES Y "function" ===
        // Esto es lo que hice inicialmente para resolver el problema, pero usando bucles y funciones, que presupongo que no está permitido


        function ip2bin($ip) {
            $pos1 = strpos($ip, ".");
            $pos2 = strpos($ip, ".", $pos1 + 1);
            $pos3 = strpos($ip, ".", $pos2 + 1);

            return
                str_pad(decbin(substr($ip, 0, $pos1)), 8, "0", STR_PAD_LEFT).
                str_pad(decbin(substr($ip, $pos1 + 1, ($pos2 - $pos1) - 1)), 8, "0", STR_PAD_LEFT).
                str_pad(decbin(substr($ip, $pos2 + 1, ($pos3 - $pos2) - 1)), 8, "0", STR_PAD_LEFT).
                str_pad(decbin(substr($ip, $pos3 + 1)), 8, "0", STR_PAD_LEFT);
        }

        function bin2ip($numero) {
            $resultado = "";

            for ($i = 0; $i < 32; $i++) {
                if ($i % 8 == 0) {
                    $resultado = $resultado.bindec(substr($numero, $i, 8));
                    if ($i + 8 != strlen($numero)) $resultado = $resultado.".";
                }
            }

            return $resultado;
        }


        // $ip = "192.168.16.100/16";
        // $ip = "192.168.16.100/21";
        $ip = "10.33.15.100/8";

        $masc = substr($ip, strpos($ip, "/") + 1);
        $red = bin2ip(str_pad(substr(ip2bin($ip), 0, $masc), 32, "0", STR_PAD_RIGHT));
        $broad = bin2ip(str_pad(substr(ip2bin($ip), 0, $masc), 32, "1", STR_PAD_RIGHT));
        $rango1 = bin2ip(substr_replace(str_pad(substr(ip2bin($ip), 0, $masc), 32, "0", STR_PAD_RIGHT), "1", 31, 1));
        $rango2 = bin2ip(substr_replace(str_pad(substr(ip2bin($ip), 0, $masc), 32, "1", STR_PAD_RIGHT), "0", 31, 1));

        echo "IP: $ip</br>";
        echo "Máscara: $masc</br>";
        echo "Dirección de red: $red</br>";
        echo "Dirección de broadcast: $broad</br>";
        echo "Rango: $rango1 - $rango2";
        
        */
    ?>
    </body>
</html>
