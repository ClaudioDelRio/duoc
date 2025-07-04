<?php
// Verificamos la sesión
session_start();
if (!isset($_SESSION['u_id'])) {
    header('Location: ../index.php');
    exit;
}

require_once '../clases/config.php';
require_once '../clases/db.php';

// Consulta para obtener los usuarios
$sql = "SELECT u_id, u_nombre, u_username, u_rut, u_created_at, u_updated_at FROM usuarios";
// Crear instancia de la clase db con parámetros de conexión
$db = new db($dbhost, $dbuser, $dbpass, $dbname);
$result = $db->query($sql);
$usuarios = $result->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios | Family Lunch SpA</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body class="admin-body">
    <header class="admin-header">
        <a href="opciones.php" class="btn-back" title="Volver a opciones">
            <i class="bi bi-arrow-left-circle"></i>
        </a>
        <h1 class="admin-title" style="display:inline;">
            <i class="bi bi-people-fill"></i> Gestión de Usuarios
        </h1>
        <div class="admin-user-bar">
            <span class="admin-user-welcome">
                <i class="bi bi-person-circle"></i> Bienvenido,
            </span>
            <span class="admin-user-name">
                <?php echo isset($_SESSION['u_nombre']) ? htmlspecialchars($_SESSION['u_nombre']) : 'Usuario'; ?>
            </span>
            <button onclick="window.location.href='../clases/cerrar_sesion.php'" class="btn-orange admin-logout-btn">
                <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
            </button>
        </div>
    </header>
    <main class="main_usuarios">
        <section class="usuarios-header-section">
            <h2 class="usuarios-header-title">Listado de Usuarios</h2>
            <a href="insertar_usuario.php" class="btn-orange btn-insertar-usuario">Insertar Usuario</a>
            <table class="admin-table">
                <thead>
                    <tr>
                        
                        <th class="col-nombre">Nombre</th>
                        <th>Username</th>
                        <th>RUT</th>
                        <th class="col-fecha">Creado</th>
                        <th class="col-fecha">Actualizado</th>
                        <th>Acciones</th> <!-- Nueva columna -->
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($usuarios)): ?>
                        <?php foreach($usuarios as $row): ?>
                            <tr>
                                
                                <td class="col-nombre"><?php echo htmlspecialchars($row['u_nombre']); ?></td>
                                <td><?php echo htmlspecialchars($row['u_username']); ?></td>
                                <td><?php echo htmlspecialchars($row['u_rut']); ?></td>
                                <td class="col-fecha"><?php echo htmlspecialchars($row['u_created_at']); ?></td>
                                <td class="col-fecha"><?php echo htmlspecialchars($row['u_updated_at']); ?></td>
                                <td>
                                    <a href="editar_usuario.php?id=<?php echo $row['u_id']; ?>" class="btn-editar-usuario" title="Editar">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <a href="eliminar_usuario.php?id=<?php echo $row['u_id']; ?>" class="btn-eliminar-usuario" title="Eliminar"
                                       onclick="return confirm('¿Estás seguro de que deseas eliminar este usuario?');">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="6">No hay usuarios registrados.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>
    </main>
    <footer class="admin-footer">
        &copy; <?php echo date('Y'); ?> Family Lunch SpA | Panel de Administración
    </footer>
</body>
</html>
