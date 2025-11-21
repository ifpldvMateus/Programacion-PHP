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

    function alta_producto($conexion, $nombre, $precio, $id_categoria_selec) {
        $id = "P".str_pad(num_obtener_ultimo_id($conexion, "PRODUCTO", "ID_PRODUCTO", 2) + 1, 4, "0", STR_PAD_LEFT);

        // $categorias = array_column(consultar($conexion, "SELECT NOMBRE FROM CATEGORIA"), "NOMBRE");

        $stmt = $conexion->prepare("INSERT INTO PRODUCTO (ID_PRODUCTO, NOMBRE, PRECIO, ID_CATEGORIA) VALUES (:id, :nombre, :precio, :id_cat)");
        $stmt->execute([
            ":id" => $id,
            ":nombre" => $nombre,
            ":precio" => $precio,
            ":id_cat" => $id_categoria_selec
        ]);

        return "Insertado: $id - $nombre - $precio - $id_categoria_selec";
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

            if ($clave == "precio") { // "precio" es el único campo numérico a comprobar
                $campos[$clave] = str_replace(',', '.', $campos[$clave]);
                if (!is_numeric($campos[$clave]) || $campos[$clave] < 0) {
                    $_SESSION["error"] = "Valor numérico no admitido: {$campos[$clave]}";
                    prg_redirect();
                }

                // De las demás validaciones se puede encargar la lógica de negocio en la base de datos, aunque es recomendable validar lo posible aquí y dejar sólo lo crítico a la base de datos
            }
        }

        try {
            $conexion = conectar();

            $_SESSION["mensaje"] = alta_producto($conexion, $campos["nombre"], $campos["precio"], $campos["categoria"]);

        } catch(PDOException $e) {
            $_SESSION["error"] = "PDOException: ".$e->getMessage();
        }

        $conexion = null;
        prg_redirect();
    }

    try {
        $conexion = conectar();
        $categorias = consultar($conexion, "SELECT ID_CATEGORIA, NOMBRE FROM CATEGORIA");
        // En PHP no existe el ámbito de bloque, sólo en funciones/métodos y clases

    } catch(PDOException $e) {
        $_SESSION["critico"] = "No se pudieron cargar las categorías: ".$e->getMessage();
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

        <h3>Dar de alta a un nuevo producto</h3>

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
                <label for="nombre">Nombre:</label>
                <input type="text" placeholder="Ej: Pan" id="nombre" name="nombre">
            </div>

            <div class="fila">
                <label for="precio">Precio:</label>
                <input type="text" placeholder="Ej: 25" id="precio" name="precio">
            </div>

             <div class="fila">
                <label for="categoria">Categoría:</label>
                <select name="categoria" id="categoria" required>
                    <option value="" disabled selected>-- Selecciona --</option>
                    <?php
                        foreach ($categorias as $categoria) {
                            echo "<option value='{$categoria['ID_CATEGORIA']}'>{$categoria['NOMBRE']}</option>";
                        }
                    ?>
                </select>
            </div>

            <div class="botones">
                <input type="submit" value="Alta">
                <input type="reset" value="Limpiar">
            </div>

        </form>

    </body>
</html>