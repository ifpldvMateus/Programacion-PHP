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

    function aprovisionar_producto($conexion, $num_almacen_selec, $id_producto_selec, $cantidad) {

        $stmt = $conexion->prepare("INSERT INTO ALMACENA (NUM_ALMACEN, ID_PRODUCTO, CANTIDAD) VALUES (:almacen, :producto, :cantidad)");
        $stmt->execute([
            ":almacen" => $num_almacen_selec,
            ":producto" => $id_producto_selec,
            ":cantidad" => $cantidad
        ]);

        return "Insertado: $num_almacen_selec - $id_producto_selec - $cantidad";
    }

    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $campos = [];
        foreach ($_POST as $clave => $valor) {
            $campos[$clave] = test_input($valor);

            if (strlen($campos[$clave]) == 0) { // Mejor usar strlen si se admiten valores numéricos que puedan ser 0
                $_SESSION["error"] = "Todos los campos son obligatorios";
                prg_redirect();
            }

            if ($clave == "cantidad") { // "cantidad" es el único campo numérico a comprobar
                if (!ctype_digit($campos[$clave])) {
                    $_SESSION["error"] = "Valor numérico no admitido: {$campos[$clave]}";
                    prg_redirect();
                }

                // De las demás validaciones se puede encargar la lógica de negocio en la base de datos, aunque es recomendable validar lo posible aquí y dejar sólo lo crítico a la base de datos
            }
        }

        try {
            $conexion = conectar();

            $_SESSION["mensaje"] = aprovisionar_producto($conexion, $campos["almacen"], $campos["producto"], $campos["cantidad"]);

        } catch(PDOException $e) {
            $_SESSION["error"] = "PDOException: ".$e->getMessage();
        }

        $conexion = null;
        prg_redirect();
    }

    try {
        $conexion = conectar();

        $productos = consultar($conexion, "SELECT ID_PRODUCTO, NOMBRE FROM PRODUCTO");
        $almacenes = array_column(consultar($conexion, "SELECT NUM_ALMACEN FROM ALMACEN"), "NUM_ALMACEN");

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

            .error {
                color: red;
                font-weight: bold;
            }

        </style>

    </head>
    <body>
        <h3>Aprovisionar un producto a un almacén</h3>

        <?php
            if (isset($_SESSION["mensaje"])) {
                echo "<p>".$_SESSION["mensaje"]."</p>";
                unset($_SESSION["mensaje"]);
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
                <label for="almacen">Almacén:</label>
                <select name="almacen" id="almacen" required>
                    <option value="" disabled selected>-- Selecciona --</option>
                    <?php
                        foreach ($almacenes as $almacen) {
                            echo "<option value='$almacen'>$almacen</option>";
                        }
                    ?>
                </select>
            </div>

            <div class="fila">
                <label for="producto">Producto:</label>
                <select name="producto" id="producto" required>
                    <option value="" disabled selected>-- Selecciona --</option>
                    <?php
                        foreach ($productos as $producto) {
                            echo "<option value='{$producto['ID_PRODUCTO']}'>{$producto['NOMBRE']}</option>";
                        }
                    ?>
                </select>
            </div>

            <div class="fila">
                <label for="cantidad">Cantidad:</label>
                <input type="text" placeholder="Ej: 20" id="cantidad" name="cantidad">
            </div>

            <div class="botones">
                <input type="submit" value="Alta">
                <input type="reset" value="Limpiar">
            </div>

        </form>
    </body>
</html>