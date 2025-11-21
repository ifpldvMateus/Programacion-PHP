<?php
    function conectar($SERVERNAME = "localhost", $USERNAME = "root", $PASSWORD = "rootroot", $DBNAME = "comprasweb") {
        $conexion = new PDO(sprintf("mysql:host=%s;dbname=%s", $SERVERNAME, $DBNAME), $USERNAME, $PASSWORD);
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // set the PDO error mode to exception

        return $conexion;
    }

    // Consultas con uso de parámetros para proteger contra inyección SQL
    function consultar($conexion, $consulta_sql, $params = []) {
        $stmt = $conexion->prepare($consulta_sql);
        $stmt->execute($params);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function num_obtener_ultimo_id($conexion, $tabla, $columna, $offset = 1) { // PROBLEMA: Si borramos registros intermedios, no detecta esos huecos
        return consultar($conexion, "SELECT MAX(SUBSTR($columna, :offset)) 'ultimo_id' FROM $tabla ORDER BY $columna DESC", [":offset" => $offset])[0]["ultimo_id"] ?? 0;
    }

    // https://www.w3schools.com/php/php_form_validation.asp
    // Protección contra inyección JS y HTML (XSS)
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);

        return $data;
    }

    // Patrón PRG
    // Evita que al recargar la página se reenvíe automáticamente el último formulario, lo que da problemas no deseados de duplicación
    // Debemos usarla cada vez que terminemos de manejar un POST y antes de cualquier mínimo HTML
    function prg_redirect() {
        header("Location: ".$_SERVER["PHP_SELF"]);
        exit;
    }

    function nif_valido($nif) {
        return (strlen($campos[$clave]) != 9 || !ctype_digit(substr($campos[$clave], 0, 8)) || !ctype_alpha(substr($campos[$clave], -1)));
    }
?>