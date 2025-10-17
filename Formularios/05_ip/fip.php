<html>
    <head>
        <style>
            body {
                margin-left: 50px;
            }

            .botones {
                margin-top: 15px;
            }

            .campo {
                margin-bottom: 20px;
            }

            #resultado {
                width: 300px;
            }
        </style>

    </head>
    <body>
        <h1>IPs</h1>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
            <label for="ip">IP notación decimal: </label>
            <input type="text" placeholder="Ej: 192.168.0.1" id="ip" name="ip">

            <div class="botones">
                <input type="submit" value="Notación Binaria">
                <input type="reset" value="Borrar">
            </div>
        </form>

        <?php
            // NOTA: sé que en el ejercicio anterior hice muchas comprobaciones y en este no hice ninguna, pero realmente es para no invertir tanto tiempo en eso, ya que el enunciado tampoco es que lo pida e imagino que no es algo importante para estos ejercicios

            // https://www.w3schools.com/php/php_form_validation.asp
            function test_input($data) {
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);

                return $data;
            }

            function ip_decimal2bin($ip) {
                $pos1 = strpos($ip, ".");
                $pos2 = strpos($ip, ".", $pos1 + 1);
                $pos3 = strpos($ip, ".", $pos2 + 1);

                return
                    str_pad(decbin(substr($ip, 0, $pos1)), 8, "0", STR_PAD_LEFT).".".
                    str_pad(decbin(substr($ip, $pos1 + 1, ($pos2 - $pos1) - 1)), 8, "0", STR_PAD_LEFT).".".
                    str_pad(decbin(substr($ip, $pos2 + 1, ($pos3 - $pos2) - 1)), 8, "0", STR_PAD_LEFT).".".
                    str_pad(decbin(substr($ip, $pos3 + 1)), 8, "0", STR_PAD_LEFT);
            }
            
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $ip_decimal = test_input($_POST["ip"]);

                echo "<form>";

                echo "<div class='campo'><label for='entrada'>IP notación decimal: </label>";
                echo "<input type='text' id='entrada' value='".$ip_decimal."' readonly></div>";

                echo "<div class='campo'><label for='resultado'>IP notación binaria: </label>";
                echo "<input type='text' id='resultado' value='".ip_decimal2bin($ip_decimal)."' readonly></div>";

                echo "</form>";
            }
        ?>
    </body>
</html>