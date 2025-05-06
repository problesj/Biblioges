<?php
$host = 'localhost';
$dbname = 'biblioges';
$username = 'webadm';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Mostrar la estructura de la tabla
    echo "Estructura de la tabla usuarios:\n";
    foreach($pdo->query("DESCRIBE usuarios") as $row) {
        print_r($row);
    }
    
    echo "\nDatos del usuario:\n";
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt->execute(['admin@example.com']);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user) {
        foreach($user as $key => $value) {
            echo "$key: $value\n";
        }
    } else {
        echo "Usuario no encontrado\n";
    }
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
} 