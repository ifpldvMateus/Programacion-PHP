<html>
    <head>
        <title>EJ5A – Unir arrays</title>
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

            function unir_solitario(&$destino, $array) {
                foreach ($array as $m) {
                    $destino[] = $m; // En PHP no hace falta guardar el último índice para colocar los elementos correctamente, PHP puede hacerlo por sí mismo
                }
            }

            $modulos1 = ["Bases de datos", "Entornos Desarrollo", "Programación"];
            $modulos2 = ["Sistemas Informáticos", "FOL", "Mecanizado"];
            $modulos3 = ["Desarrollo Web ES", "Desarrollo Web EC", "Despliegue", "Desarrollo Interfaces", "Inglés"];

            $unido_manual = []; unir_solitario($unido_manual, $modulos1); unir_solitario($unido_manual, $modulos2); unir_solitario($unido_manual, $modulos3);
            $unido_merge = array_merge($modulos1, $modulos2, $modulos3);
            $unido_push = []; array_push($unido_push, ...$modulos1, ...$modulos2, ...$modulos3); // El operador "..." extrae los elementos del array, así evito hacer bucles (NO SÉ SI ESTÁ PERMITIDO USARLO)

            mostrar_tabla($unido_manual, "Sin funciones");
            mostrar_tabla($unido_merge, "Por array_merge()");
            mostrar_tabla($unido_push, "Por array_push()");
        ?>
    </body>
</html>
