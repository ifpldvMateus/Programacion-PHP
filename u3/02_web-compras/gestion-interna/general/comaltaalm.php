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
    session_start();

    function alta_almacen($conexion, $localidad) {
        $num = num_obtener_ultimo_id($conexion, "ALMACEN", "NUM_ALMACEN") + 1;

        $stmt = $conexion->prepare("INSERT INTO ALMACEN (NUM_ALMACEN, LOCALIDAD) VALUES (:num, :localidad)");
        $stmt->execute([":num" => $num, ":localidad" => $localidad]);

        return "Insertado: $num - $localidad";
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $localidad = test_input($_POST["localidad"]);
        if (empty($localidad)) {
            $_SESSION["error"] = "No has introducido ninguna localidad";
            prg_redirect();
        }

        try {
            $conexion = conectar();
            $_SESSION["mensaje"] = alta_almacen($conexion, $localidad);

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
        <h3>Dar de alta a un nuevo almacén</h3>

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
            <label for="localidad">Localidad del nuevo almacén:</label>
            <input type="text" placeholder="Ej: Toledo" id="localidad" name="localidad">

            <div class="botones">
                <input type="submit" value="Alta">
                <input type="reset" value="Limpiar">
            </div>
        </form>

    </body>
</html>