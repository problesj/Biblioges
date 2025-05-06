<?php
require_once __DIR__ . '/../src/Core/bootstrap.php';

use src\Models\Usuario;

$userModel = new Usuario();
$user = $userModel->findByEmail('admin@example.com');

if ($user) {
    echo "Usuario encontrado:\n";
    echo "ID: " . $user['id'] . "\n";
    echo "Email: " . $user['email'] . "\n";
    echo "Estado: " . $user['estado'] . "\n";
    echo "Rol: " . $user['rol'] . "\n";
} else {
    echo "Usuario no encontrado\n";
} 