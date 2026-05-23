<?php
// Lógica interna: Definimos las localidades del festival y sus precios
$localidades = [
    "general" => [
        "nombre" => "General (La Zona del Perreo)",
        "precio" => 150000,
        "descripcion" => "Acceso a la pista general, barras de bebidas y zonas de experiencia."
    ],
    "vip" => [
        "nombre" => "VIP (En el Elemento)",
        "precio" => 350000,
        "descripcion" => "Ubicación preferencial cerca al escenario, ingreso exclusivo y baño privado."
    ],
    "palco" => [
        "nombre" => "Palco Cris MJ (Ultra VIP)",
        "precio" => 1200000,
        "descripcion" => "Espacio privado para 1 persona (compartido), servicio de mesero y kit del festival."
    ]
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perreo Urban Fest 2026 - Preventa</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <header>
        <h1>🔥 PERREO URBAN FEST 2026 🔥</h1>
        <p>Asegura tus entradas para la noche más intensa del año en Bogotá</p>
    </header>

    <main class="contenedor">
        <h2>Localidades Disponibles</h2>
        <div class="grid-localidades">
            <?php foreach($localidades as $id => $zona): ?>
                <div class="tarjeta-zona">
                    <h3><?php echo $zona['nombre']; ?></h3>
                    <p class="precio">$<?php echo number_format($zona['precio'], 0, ',', '.'); ?> COP</p>
                    <p><?php echo $zona['descripcion']; ?></p>
                </div>
            <?php endforeach; ?>
        </div>

        <section class="formulario-seccion">
            <h2>Simula tu Compra de Boletas</h2>
            <form action="logica.php" method="POST">
                <div class="grupo">
                    <label for="nombre">Nombre del Comprador:</label>
                    <input type="text" id="nombre" name="nombre" required placeholder="Tu nombre para el ticket">
                </div>

                <div class="grupo">
                    <label for="localidad">Selecciona tu Zona:</label>
                    <select id="localidad" name="localidad" required>
                        <?php foreach($localidades as $id => $zona): ?>
                            <option value="<?php echo $id; ?>"><?php echo $zona['nombre']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="grupo">
                    <label for="cantidad">Cantidad de Entradas (Máx. 4):</label>
                    <input type="number" id="cantidad" name="cantidad" min="1" max="4" required placeholder="1">
                </div>

                <div class="grupo">
                    <label for="codigo">Código de Descuento (Opcional):</label>
                    <input type="text" id="codigo" name="codigo" placeholder="Ej: CRISPACK">
                </div>

                <button type="submit" class="btn-enviar">Generar Reserva Virtual ⚡</button>
            </form>
        </section>
    </main>
</body>
</html>