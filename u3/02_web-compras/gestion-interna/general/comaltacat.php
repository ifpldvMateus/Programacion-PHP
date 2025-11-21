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

    require_once "../../funciones_glob.php";

    function alta_categoria($conexion, $categoria) {
        $id = "C-".str_pad(num_obtener_ultimo_id($conexion, "CATEGORIA", "ID_CATEGORIA", 3) + 1, 3, "0", STR_PAD_LEFT);

        // Más seguro que exec() para evitar inyecciones SQL
        $stmt = $conexion->prepare("INSERT INTO CATEGORIA (ID_CATEGORIA, NOMBRE) VALUES (:id, :nombre)");
        $stmt->execute([":id" => $id, ":nombre" => $categoria]);

        return "Insertado: $id - $categoria";
    }

    session_start(); // Iniciamos una sesión para guardar mensajes que sobrevivan a prg_redirect() (cookie PHPSESSID)

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $categoria = test_input($_POST["categoria"]);
        if (empty($categoria)) {
            $_SESSION["error"] = "No has introducido ninguna categoría";
            prg_redirect();
        }

        try {
            $conexion = conectar();

            // Begin a transaction, turning off autocommit
            // $conexion->beginTransaction(); // Comentado, debido a que las tablas usan el motor de almacenamiento MyISAM, que no soporta transacciones

            $_SESSION["mensaje"] = alta_categoria($conexion, $categoria);

            // $conexion->rollBack();

        } catch(PDOException $e) {
            $_SESSION["error"] = "PDOException: ".$e->getMessage();
        }

        $conexion = null;
        prg_redirect();
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
        <h3>Dar de alta a una nueva categoría de producto</h3>

        <?php
            if (isset($_SESSION["mensaje"])) {
                echo "<p>".$_SESSION["mensaje"]."</p>";
                unset($_SESSION["mensaje"]);
            }

            if (isset($_SESSION["error"])) {
                echo "<p class='error'>".$_SESSION["error"]."</p>";
                unset($_SESSION["error"]);
            }
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
            <label for="categoria">Nueva categoría de producto:</label>
            <input type="text" placeholder="Ej: Alimentación" id="categoria" name="categoria">

            <div class="botones">
                <input type="submit" value="Alta">
                <input type="reset" value="Limpiar">
            </div>
        </form>

    </body>
</html>