<html>
    <head>
        <title>EJ5A – Invertir arrays unidos y eliminar elemento</title>
    </head>
    <body>
        <?php

            function mostrar_tabla($array, $titulo) {
                echo "<h2>".$titulo."</h2>";
                
                echo <<<HTML
                <table border="1" style="border-collapse: collapse;">
                <tr>
                    <th width="75">Índice</th>
                    <th width="75">Valor</th>
                </tr>
                HTML;

                foreach ($array as $i => $elemento) {
                    echo "<tr>";
                    echo "<td>".$i."</td>";
                    echo "<td>".$elemento."</td>";
                    echo "</tr>";
                }

                echo "</table><br>";
            }

            $modulos1 = ["Bases de datos", "Entornos Desarrollo", "Programación"];
            $modulos2 = ["Sistemas Informáticos", "FOL", "Mecanizado"];
            $modulos3 = ["Desarrollo Web ES", "Desarrollo Web EC", "Despliegue", "Desarrollo Interfaces", "Inglés"];

            $unido = array_reverse(array_merge($modulos1, $modulos2, $modulos3));
            unset($unido[array_search("Mecanizado", $unido)]);
            $unido = array_values($unido); // Reordenar los índices internos del array

            mostrar_tabla($unido, "Array sin el módulo \"Mecanizado\" e invertido");
        ?>
    </body>
</html>
