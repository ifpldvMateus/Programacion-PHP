<html>
    <head>
        <title>EJ1-Conversion IP Decimal a Binario</title>
    </head>
    <body>
    <?php
        $ip="192.18.16.204";
        //$ip="10.33.161.2";

        $pos1 = strpos($ip, ".");
        $pos2 = strpos($ip, ".", $pos1 + 1);
        $pos3 = strpos($ip, ".", $pos2 + 1);

        echo "La IP $ip se representa en binario como: "
            .str_pad(decbin(substr($ip, 0, $pos1)), 8, "0", STR_PAD_LEFT)."."
            .str_pad(decbin(substr($ip, $pos1 + 1, ($pos2 - $pos1) - 1)), 8, "0", STR_PAD_LEFT)."."
            .str_pad(decbin(substr($ip, $pos2 + 1, ($pos3 - $pos2) - 1)), 8, "0", STR_PAD_LEFT)."."
            .str_pad(decbin(substr($ip, $pos3 + 1)), 8, "0", STR_PAD_LEFT);
    ?>
    </body>
</html>
