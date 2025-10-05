<html>
    <head>
        <title>EJ2AM – Suma por filas y columnas</title>
        <style>
            div {
                display: flex;
                align-items: flex-start;
                margin-bottom: 20px;
            }

            table {
                border-collapse: collapse;
            }

            span {
                margin-right: 20px;
            }

            td {
                width: 70px;
                height: 20px;
                text-align: center;
                border: 1px solid black;
            }
        </style>
    </head>
    <body>
        <?php
            function array_mostrar_tabla($array, $titulo, $nfilas, $ncolumnas) {

                echo "<div>";
                echo "<span>".$titulo."</span>";
                echo "<table>";

                $indice = 0;

                for ($i = 0; $i < $nfilas; $i++) {
                    echo "<tr>";

                    for ($j = 0; $j < $ncolumnas; $j++) {
                        if ($indice > count($array) - 1) $indice = 0;

                        echo "<td>".$array[$indice]."</td>";
                        $indice++;
                    }

                    echo "</tr>";
                }

                echo "</table>";
                echo "</div>";
            }


            $multiplos = [];
            $multiplo = 2;
            $cont = 1;

            $suma_filas = array_fill(0, 3, 0);
            $suma_columnas = array_fill(0, 3, 0);

            for ($i = 0; $i < 3; $i++) {
                for ($j = 0; $j < 3; $j++) {
                    $multiplos[$i][$j] = $multiplo * $cont;

                    $suma_filas[$i] += $multiplos[$i][$j];
                    $suma_columnas[$j] += $multiplos[$i][$j];

                    $cont++;
                }
            }
            
            array_mostrar_tabla($suma_filas, "SUMA POR FILAS:", 3, 1);
            array_mostrar_tabla($suma_columnas, "SUMA POR COLUMNAS:", 1, 3);
        ?>
    </body>
</html>