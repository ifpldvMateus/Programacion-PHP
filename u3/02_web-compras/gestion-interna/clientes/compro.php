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

    // Sugerencia de mejora: reutilizar la misma conexión a la base de datos

    require_once "../../funciones_glob.php";

    function comprar_producto($conexion, $nif, $producto, $unidades) {

        // MyISAM no aplica restricciones de clave extranjera, por lo que se puede poner una clave extranjera que no exista como primaria
        // Como le damos libertad al usuario para escribir su NIF, para no exponer a los demás usuarios, tendremos que verificar la relación nosotros mismos
        if (empty(consultar($conexion, "SELECT NIF FROM CLIENTE WHERE NIF=:nif", [":nif" => $nif]))) {
            $_SESSION["error"] = "Cliente no registrado: $nif";
            return;
        }

        // Por si el usuario ha seleccionado más unidades de las que hay
        $unidades_disponibles = consultar($conexion, "SELECT SUM(CANTIDAD) 'disponible' FROM ALMACENA WHERE ID_PRODUCTO=:producto", [":producto" => $producto])[0]["disponible"] ?? 0;
        // Detener la compra si ya no hay stock. Aunque pareciera no ser posible, porque se seleccionan sólo los productos disponibles en el formulario, podría darse el caso de que varios usuarios compren de forma concurrente ese producto y se agote antes de llegar aquí
        if ($unidades_disponibles == 0) {
            $_SESSION["error"] = "¡El producto se acaba de agotar ahora mismo!";
            return;
        }

        $unidades = min($unidades, $unidades_disponibles);

        // Registrar compra
        $compra = [":nif" => $nif, ":producto" => $producto, ":fecha" => date("Y-m-d"), ":unidades" => $unidades];
        $conexion->prepare("INSERT INTO COMPRA (NIF, ID_PRODUCTO, FECHA_COMPRA, UNIDADES) VALUES (:nif, :producto, :fecha, :unidades)")->execute($compra);
        $_SESSION["msg"]["insert"][] = "Compra registrada: ".implode(" / ", $compra);


        // Restar unidades compradas del stock disponible
        $almacenamiento = consultar($conexion, "SELECT * FROM ALMACENA WHERE ID_PRODUCTO=:producto", [":producto" => $producto]);
        $pendientes = $unidades;
        foreach ($almacenamiento as $fila) {
            if ($pendientes <= 0) break;

            $restar = min($fila["CANTIDAD"], $pendientes); // Lo que le podemos restar a un almacén
            $restante = $fila["CANTIDAD"] - $restar; // La cantidad con la que se queda el almacén

            // $_SESSION["debug"][] = "[DEBUG]: restar = $restar / restante = $restante / CANTIDAD = {$fila['CANTIDAD']} / pendientes = $pendientes";

            if ($restante == 0) { // Si el almacén se queda sin el producto, eliminamos el registro
                $conexion->prepare("DELETE FROM ALMACENA WHERE NUM_ALMACEN = :almacen AND ID_PRODUCTO = :producto")->execute([":almacen" => $fila["NUM_ALMACEN"], ":producto" => $fila["ID_PRODUCTO"]]);
                $_SESSION["msg"]["delete"][] = "El almacén {$fila['NUM_ALMACEN']} se ha quedado sin stock del producto seleccionado ({$fila['ID_PRODUCTO']}): registro eliminado";

            } else { // Si no, actualizamos sus unidades
                $conexion->prepare("UPDATE ALMACENA SET CANTIDAD = :n_unidades WHERE NUM_ALMACEN = :almacen AND ID_PRODUCTO = :producto")->execute([":n_unidades" => $restante, ":almacen" => $fila["NUM_ALMACEN"], ":producto" => $fila["ID_PRODUCTO"]]);
                $_SESSION["msg"]["update"][] = "El almacén {$fila['NUM_ALMACEN']} se ha quedado ahora con $restante unidades del producto seleccionado ({$fila['ID_PRODUCTO']})";
            }

            $pendientes -= $restar;
        }
    }

    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $campos = [];
        foreach ($_POST as $clave => $valor) {
            $campos[$clave] = test_input($valor);

            if ($clave == "nif") {
                if (!nif_valido($campos[$clave])) {
                    $_SESSION["error"] = "NIF inválido: {$campos[$clave]}";
                    prg_redirect();
                }
            }

            if ($clave == "unidades") {
                if (!ctype_digit($campos[$clave]) || empty($campos[$clave])) {
                    $_SESSION["error"] = "Cantidad no admitida: {$campos[$clave]}";
                    prg_redirect();
                }
            }
        }

        try {
            $conexion = conectar();
            comprar_producto($conexion, $campos["nif"], $campos["producto"], $campos["unidades"]);

        } catch(PDOException $e) {
            $_SESSION["error"] = "PDOException: ".$e->getMessage();
        }

        $conexion = null;
        prg_redirect();
    }

    try {
        $conexion = conectar();

        $productos = consultar($conexion, "SELECT DISTINCT A.ID_PRODUCTO 'id', P.NOMBRE 'nombre' FROM ALMACENA A, PRODUCTO P WHERE A.ID_PRODUCTO=P.ID_PRODUCTO");

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
                margin: 0 10px;
            }

            .botones {
                margin-top: 15px;
            }

            .error {
                color: red;
                font-weight: bold;
            }

        </style>

    </head>
    <body>
        <h3>Compra de productos</h3>

        <?php
            if (isset($_SESSION["critico"])) {
                echo "<p class='error'>".$_SESSION["critico"]."</p>";

                unset($_SESSION["critico"]);
                exit;

            } else if (isset($_SESSION["error"])) {
                echo "<p class='error'>".$_SESSION["error"]."</p>";
                unset($_SESSION["error"]);

            } else if (isset($_SESSION["msg"])) {
                foreach ($_SESSION["msg"] as $categoria) {
                    foreach ($categoria as $mensajes) {
                        echo "<p>$mensajes</p>";
                    }
                }

                unset($_SESSION["msg"]);
            }
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">

             <div class="fila">
                <label for="nif">NIF de cliente:</label>
                <input type="text" id="nif" name="nif">
            </div>

            <div class="fila">
                <label for="producto">Selecciona un producto disponible:</label>
                <select name="producto" id="producto" required>
                    <option value="" disabled selected>-- Selecciona --</option>
                    <?php
                        foreach ($productos as $producto) {
                            echo "<option value='{$producto['id']}'>{$producto['nombre']}</option>";
                        }
                    ?>
                </select>
            </div>

            <div class="fila">
                <label for="unidades">Unidades:</label>
                <input type="text" id="unidades" name="unidades">
            </div>

            <div class="botones">
                <input type="submit" value="Comprar">
                <input type="reset" value="Limpiar">
            </div>

        </form>
    </body>
</html>