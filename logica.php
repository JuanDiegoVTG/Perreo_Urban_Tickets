<?php
$localidades = [
    "general" => ["nombre" => "General (La Zona del Perreo)", "precio" => 150000],
    "vip" => ["nombre" => "VIP (En el Elemento)", "precio" => 350000],
    "palco" => ["nombre" => "Palco Cris MJ (Ultra VIP)", "precio" => 1200000]
];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = htmlspecialchars($_POST['nombre']);
    $localidad_id = $_POST['localidad'];
    $cantidad = intval($_POST['cantidad']);
    $codigo = strtoupper(trim($_POST['codigo']));

    if (!array_key_exists($localidad_id, $localidades)) {
        die("Error: Localidad no válida.");
    }

    $zona = $localidades[$localidad_id];
    $precio_unitario = $zona['precio'];
    
    // Regla de Negocio 1: Calcular Subtotal
    $subtotal = $precio_unitario * $cantidad;

    // Regla de Negocio 2: Aplicar descuento si usa el código correcto
    $descuento = 0;
    if ($codigo === "CRISPACK") {
        $descuento = $subtotal * 0.15; // 15% de descuento
    }

    // Regla de Negocio 3: Costo de servicio por boleta (Tuboleta Style)
    $costo_servicio = 12000 * $cantidad;

    // Total final
    $total_pagar = ($subtotal - $descuento) + $costo_servicio;
    
    // Generar un número de orden aleatorio para el diseño del ticket
    $numero_orden = rand(100000, 999999);
} else {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tu Ticket - Perreo Urban Fest</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <header>
        <h1>🎟️ ¡RESERVA GENERADA CON ÉXITO! 🎟️</h1>
        <p>Tu lugar en el festival está casi listo, <?php echo $nombre; ?>.</p>
    </header>

    <main class="contenedor">
        <div class="resultado-caja ticket-virtual">
            <div class="ticket-header">
                <h2>ORDEN DE RESERVA #<?php echo $numero_orden; ?></h2>
                <span class="badge">Pre-Aprobado</span>
            </div>
            
            <div class="ticket-cuerpo">
                <p><strong>Evento:</strong> Perreo Urban Fest 2026</p>
                <p><strong>Ubicación:</strong> Movistar Arena, Bogotá</p>
                <p><strong>Localidad:</strong> <?php echo $zona['nombre']; ?></p>
                <p><strong>Cantidad:</strong> <?php echo $cantidad; ?> boleta(s)</p>
                <hr>
                <ul class="desglose-precios">
                    <li>Subtotal Boletas: <span>$<?php echo number_format($subtotal, 0, ',', '.'); ?> COP</span></li>
                    <?php if($descuento > 0): ?>
                        <li class="text-descuento">Descuento Código (15%): <span>-$<?php echo number_format($descuento, 0, ',', '.'); ?> COP</span></li>
                    <?php endif; ?>
                    <li>Servicio de Emisión: <span>$<?php echo number_format($costo_servicio, 0, ',', '.'); ?> COP</span></li>
                    <li class="destacado">Total Estimado: <span>$<?php echo number_format($total_pagar, 0, ',', '.'); ?> COP</span></li>
                </ul>
            </div>
        </div>

        <div class="acciones">
            <a href="index.php" class="btn-volver">← Modificar mi Reserva o Volver</a>
        </div>
    </main>
</body>
</html>