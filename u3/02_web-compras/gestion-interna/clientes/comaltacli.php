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

    function alta_clientes($conexion, $nif, $nombre, $apellido, $cp, $direccion, $ciudad) {

        $stmt = $conexion->prepare("INSERT INTO CLIENTE (NIF, NOMBRE, APELLIDO, CP, DIRECCION, CIUDAD) VALUES (:nif, :nombre, :apellido, :cp, :direccion, :ciudad)");
        $stmt->execute([":nif" => $nif, ":nombre" => $nombre, ":apellido" => $apellido, ":cp" => $cp, ":direccion" => $direccion, ":ciudad" => $ciudad]);

        return "Insertado: $nif - $nombre - $apellido - $cp - $direccion - $ciudad";
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $campos = [];
        foreach ($_POST as $clave => $valor) {
            $campos[$clave] = test_input($valor);

            if (empty($campos[$clave])) {
                $_SESSION["error"] = "Todos los campos son obligatorios";
                prg_redirect();
            }

            if ($clave == "nif") {
                if (!nif_valido($campos[$clave])) {
                    $_SESSION["error"] = "NIF inválido: {$campos[$clave]}";
                    prg_redirect();
                }
            }
        }

        try {
            $conexion = conectar();

            $_SESSION["mensaje"] = alta_clientes($conexion, $campos["nif"], $campos["nombre"], $campos["apellido"], $campos["cp"], $campos["direccion"], $campos["ciudad"]);

        } catch(PDOException $e) {
            $_SESSION["error"] = ($e->errorInfo[1] == 1062) ? "Ya existe un cliente con ese NIF" : "PDOException: ".$e->getMessage();
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
        <h3>Dar de alta a un cliente</h3>

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

            <div class="fila">
                <label for="nif">NIF:</label>
                <input type="text" placeholder="Ej: 12345678A" id="nif" name="nif">
            </div>

            <div class="fila">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre">
            </div>

            <div class="fila">
                <label for="apellido">Apellido:</label>
                <input type="text" id="apellido" name="apellido">
            </div>

            <div class="fila">
                <label for="cp">Código postal:</label>
                <input type="text" placeholder="Ej: 12345" id="cp" name="cp">
            </div>

            <div class="fila">
                <label for="direccion">Dirección:</label>
                <input type="text" id="direccion" name="direccion">
            </div>

            <div class="fila">
                <label for="ciudad">Ciudad:</label>
                <input type="text" id="ciudad" name="ciudad">
            </div>

            <div class="botones">
                <input type="submit" value="Alta">
                <input type="reset" value="Limpiar">
            </div>

        </form>

    </body>
</html>