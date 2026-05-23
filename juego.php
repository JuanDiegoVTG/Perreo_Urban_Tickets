<?php
// Iniciamos la sesión para recordar los intentos sin usar bases de datos
session_start();

// Configuración inicial del juego
$max_intentos = 3;

// Si el usuario presiona "Reiniciar" o es la primera vez que entra
if (isset($_POST['reiniciar']) || !isset($_SESSION['numero_secreto'])) {
    $_SESSION['numero_secreto'] = rand(1, 10); // Número aleatorio entre 1 y 10
    $_SESSION['intentos_restantes'] = $max_intentos;
    $_SESSION['mensaje'] = "¡El juego ha comenzado! Tienes 3 intentos para adivinar un número del 1 al 10.";
    $_SESSION['gano'] = false;
}

// Procesar el intento del usuario
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['numero_usuario']) && !$_SESSION['gano'] && $_SESSION['intentos_restantes'] > 0) {
    $numero_usuario = intval($_POST['numero_usuario']);
    $_SESSION['intentos_restantes']--;

    if ($numero_usuario === $_SESSION['numero_secreto']) {
        $_SESSION['gano'] = true;
        $_SESSION['mensaje'] = "¡BRUTAL! 🔥 Descifraste el código del Backstage. Tu premio es el código de descuento: <strong>CRISPACK</strong> (Usa este código en el simulador para un 15% de descuento).";
    } else {
        if ($_SESSION['intentos_restantes'] > 0) {
            if ($numero_usuario < $_SESSION['numero_secreto']) {
                $_SESSION['mensaje'] = "El número secreto es MÁS ALTO. ¡Te quedan " . $_SESSION['intentos_restantes'] . " intentos!";
            } else {
                $_SESSION['mensaje'] = "El número secreto es MÁS BAJO. ¡Te quedan " . $_SESSION['intentos_restantes'] . " intentos!";
            }
        } else {
            $_SESSION['mensaje'] = "❌ Te quedaste sin intentos. El código secreto era el " . $_SESSION['numero_secreto'] . ". ¡Inténtalo de nuevo!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Desafío VIP - Perreo Urban Fest</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <header>
        <h1>🎮 DESAFÍO BACKSTAGE VIP 🎮</h1>
        <p>Adivina el número secreto del 1 al 10 y gana descuentos reales para tus boletas</p>
    </header>

    <main class="contenedor">
        <div class="resultado-caja">
            <h2>Estado del Desafío:</h2>
            <p class="notificacion-juego"><?php echo $_SESSION['mensaje']; ?></p>

            <?php if (!$_SESSION['gano'] && $_SESSION['intentos_restantes'] > 0): ?>
                <form action="juego.php" method="POST" class="form-juego">
                    <div class="grupo">
                        <label for="numero_usuario">Ingresa tu número (1 al 10):</label>
                        <input type="number" id="numero_usuario" name="numero_usuario" min="1" max="10" required>
                    </div>
                    <button type="submit" class="btn-enviar">Probar Suerte ⚡</button>
                </form>
            <?php else: ?>
                <form action="juego.php" method="POST">
                    <button type="submit" name="reiniciar" class="btn-enviar btn-reiniciar">Jugar de Nuevo 🔄</button>
                </form>
            <?php endif; ?>

            <div class="acciones" style="margin-top: 2rem; text-align: center;">
                <a href="index.php" class="btn-volver" style="color: #00f0ff;">← Volver al Simulador de Boletas</a>
            </div>
        </div>
    </main>
</body>
</html>