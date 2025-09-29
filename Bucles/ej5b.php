<html>
    <head>
        <title>EJ5B – Tabla multiplicar con TD</title>
    </head>
    <body>
        <table border="1" style="border-collapse: collapse;">
    <?php
        $numero = 8;

        for ($i = 1; $i <= 10; $i++) {
            echo "<tr>";
            echo "<td width=\"75\">$numero x $i</td>";
            echo "<td width=\"75\">".$numero * $i."</td>";
            echo "</tr>";
        }
    ?>
        </table>
    </body>
</html>
