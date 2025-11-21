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

        printf("La IP $ip se representa en binario como: %08b.%08b.%08b.%08b",
            substr($ip, 0, $pos1),
            substr($ip, $pos1 + 1, ($pos2 - $pos1) - 1),
            substr($ip, $pos2 + 1, ($pos3 - $pos2) - 1),
            substr($ip, $pos3 + 1)
        );
    ?>
    </body>
</html>
