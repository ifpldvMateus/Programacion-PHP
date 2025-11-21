<?php
    /*
    Cómo funciona el Patrón PRG

    Al entrar en la página:
    - El documento se estructura así: Bloque PHP (1); HTML (2)
    - Se inicia una sesión y se muestra el formulario
    - El usuario enviará el formulario y se manejará el POST
    - Para terminar, la página se reenvía a sí misma, con los mensajes de salida guardados en la sesión
    - La página recargada (GET) muestra el formulario junto a los mensajes de la sesión

    Con esto, se evita el reenvío automático del último formulario al recargar la página
    */

    // Sugerencias de mejora:
    // - Reutilizar la misma conexión a la base de datos
    // - Mantener seleccionada la opción tras consultarla o mostrarla (mejora de UX)

    require_once "../../funciones_glob.php";
    
    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $campos = [];
        foreach ($_POST as $clave => $valor)
            $campos[$clave] = test_input($valor);

        $campos["fec_desde"] = min($campos["fec_desde"], $campos["fec_hasta"]);
        $campos["fec_hasta"] = max($campos["fec_desde"], $campos["fec_hasta"]);

        try {
            $conexion = conectar();
            
            $_SESSION["consulta"]["compras"] = consultar($conexion, "SELECT P.NOMBRE 'Producto', C.UNIDADES * P.PRECIO 'Pago' FROM COMPRA C, PRODUCTO P WHERE C.NIF=:nif AND C.ID_PRODUCTO=P.ID_PRODUCTO AND C.FECHA_COMPRA BETWEEN :fec_desde AND :fec_hasta", [":nif" => $campos["nif"], ":fec_desde" => $campos["fec_desde"], ":fec_hasta" => $campos["fec_hasta"]]);
            
            $_SESSION["consulta"]["total"] = consultar($conexion, "SELECT SUM(C.UNIDADES * P.PRECIO) 'total' FROM COMPRA C, PRODUCTO P WHERE C.NIF=:nif AND C.ID_PRODUCTO=P.ID_PRODUCTO AND C.FECHA_COMPRA BETWEEN :fec_desde AND :fec_hasta", [":nif" => $campos["nif"], ":fec_desde" => $campos["fec_desde"], ":fec_hasta" => $campos["fec_hasta"]])[0]["total"];

        } catch(PDOException $e) {
            $_SESSION["error"] = "PDOException: ".$e->getMessage();
        }

        $conexion = null;
        prg_redirect();
    }

    try {
        $conexion = conectar();
        $nifs = array_column(consultar($conexion, "SELECT NIF FROM CLIENTE"), "NIF");

    } catch(PDOException $e) {
        $_SESSION["critico"] = "No se pudo cargar el formulario: ".$e->getMessage();
    }
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <style>
            body {
                margin-left: 50px;
            }

            .fila {
                display: flex;
                align-items: center;
                margin-bottom: 10px;
            }

            .fila label {
                width: 80px;
            }

            .botones {
                margin-top: 15px;
            }

            table {
                border-collapse: collapse;
                text-align: center;
                margin: 20px 0;
            }

            td, th {
                text-align: center;
                border: 1px solid black;
            }

            td {
                padding: 5px;  
            }

            th {
                padding: 0 40px;
            }

            .error {
                color: red;
                font-weight: bold;
            }

            .advertencia {
                color: #ff5500;
                font-weight: bold;
            }

        </style>

    </head>
    <body>
        <h3>Consultar compras de un cliente</h3>

        <?php
            if (isset($_SESSION["consulta"])) {
                if (empty($_SESSION["consulta"]["compras"])) {
                    echo "<p class='advertencia'>Este cliente no ha realizado ninguna compra</p>";

                } else {
                    echo "<table>";

                    echo "<tr>";
                    foreach (array_keys($_SESSION["consulta"]["compras"][0]) as $campo) {
                        echo "<th>$campo</th>";
                    }
                    echo "</tr>";

                    foreach ($_SESSION["consulta"]["compras"] as $fila) {
                        echo "<tr>";

                        foreach ($fila as $valor) {
                            echo "<td>$valor</td>";
                        }

                        echo "</tr>";
                    }

                    echo "</table>";

                    echo "<p>Suma total: {$_SESSION['consulta']['total']} €</p>";
                }

                unset($_SESSION["consulta"]);
            }

            if (isset($_SESSION["error"])) {
                echo "<p class='error'>".$_SESSION["error"]."</p>";
                unset($_SESSION["error"]);
            }

            if (isset($_SESSION["critico"])) {
                echo "<p class='error'>".$_SESSION["critico"]."</p>";

                unset($_SESSION["critico"]);
                exit;
            }
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">

            <div class="fila">
                <label for="nif">NIF:</label>
                <select name="nif" id="nif" required>
                    <option value="" disabled selected>-- Selecciona --</option>
                    <?php
                        foreach ($nifs as $nif) {
                            echo "<option value='$nif'>$nif</option>";
                        }
                    ?>
                </select>
            </div>

            <div class="fila">
                <label for="fec_desde">Desde el:</label>
                <input type="date" id="fec_desde" name="fec_desde" required>
            </div>

            <div class="fila">
                <label for="fec_hasta">Hasta el:</label>
                <input type="date" id="fec_hasta" name="fec_hasta" required>
            </div>

             <div class="botones">
                <input type="submit" value="Consultar">
                <input type="reset" value="Limpiar">
            </div>
            
        </form>
    </body>
</html>