<?php
require_once 'conexion.php';

// Procesar inserción (CREATE)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion']) && $_POST['accion'] === 'crear') {
    $nombre = trim($_POST['nombre']);
    $descripcion = trim($_POST['descripcion']);
    
    if (!empty($nombre)) {
        $stmt = $pdo->prepare("INSERT INTO items (nombre, descripcion) VALUES (?, ?)");
        $stmt->execute([$nombre, $descripcion]);
        header("Location: index.php");
        exit;
    }
}

// Obtener registros (READ)
$stmt = $pdo->query("SELECT * FROM items ORDER BY id DESC");
$items = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>CRUD PHP - PaaS Namespace 1</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light container py-5">
    <h1 class="mb-4">Gestión de Inventario (Stack Clásico - PHP)</h1>
    
    <!-- Formulario de Registro -->
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <h5 class="card-title">Agregar Nuevo Item</h5>
            <form method="POST" action="index.php">
                <input type="hidden" name="accion" value="crear">
                <div class="mb-3">
                    <label class="form-label">Nombre:</label>
                    <input type="text" name="nombre" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Descripción:</label>
                    <textarea name="descripcion" class="form-control"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Guardar</button>
            </form>
        </div>
    </div>

    <!-- Tabla de Registros -->
    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title">Registros Almacenados</h5>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $item): ?>
                    <tr>
                        <td><?= $item['id'] ?></td>
                        <td><?= htmlspecialchars($item['nombre']) ?></td>
                        <td><?= htmlspecialchars($item['descripcion']) ?></td>
                        <td>
                            <a href="eliminar.php?id=<?= $item['id'] ?>" class="btn btn-danger btn-sm">Eliminar</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
