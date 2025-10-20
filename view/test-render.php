<?php
// Archivo de prueba para verificar que el template se renderice

require_once __DIR__ . '/../vendor/autoload.php';

// Cargar variables de entorno
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

// Configurar Twig
$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../templates');
$twig = new \Twig\Environment($loader, [
    'cache' => false,
    'auto_reload' => true,
    'debug' => true
]);
$twig->addExtension(new \Twig\Extension\DebugExtension());

// Variables globales para Twig
$baseUrl = rtrim($_ENV['APP_URL'] ?? 'https://biblioges.ucn.cl', '/');
$frontendUrl = rtrim($_ENV['APP_URL_FRONTEND'] ?? 'https://biblioges.ucn.cl', '/');
$twig->addGlobal('app_url', $frontendUrl);
$twig->addGlobal('admin_url', $frontendUrl . '/biblioges');
$twig->addGlobal('assets_url', $frontendUrl . '/assets');

// Datos de prueba
$sedes = [
    ['id' => '1', 'nombre' => 'Antofagasta', 'codigo' => 'ANF'],
    ['id' => '2', 'nombre' => 'Coquimbo', 'codigo' => 'COQ']
];

$carreras = [
    [
        'id' => 1,
        'nombre' => 'Ingeniería Civil',
        'tipo_programa' => 'P',
        'imagen_url' => 'uploads/imagenes_carreras/default.jpg',
        'cantidad_semestres' => 12,
        'sedes_nombres' => ['Antofagasta', 'Coquimbo'],
        'sedes_ids' => ['1', '2'],
        'sede_id' => '1'
    ],
    [
        'id' => 2,
        'nombre' => 'Ingeniería Comercial',
        'tipo_programa' => 'P',
        'imagen_url' => 'uploads/imagenes_carreras/default.jpg',
        'cantidad_semestres' => 10,
        'sedes_nombres' => ['Antofagasta'],
        'sedes_ids' => ['1'],
        'sede_id' => '1'
    ],
    [
        'id' => 3,
        'nombre' => 'Psicología',
        'tipo_programa' => 'P',
        'imagen_url' => 'uploads/imagenes_carreras/default.jpg',
        'cantidad_semestres' => 10,
        'sedes_nombres' => ['Coquimbo'],
        'sedes_ids' => ['2'],
        'sede_id' => '2'
    ]
];

try {
    $html = $twig->render('frontend/index.twig', [
        'carreras' => $carreras,
        'sedes' => $sedes,
        'sede_filtro' => null
    ]);
    
    echo $html;
} catch (Exception $e) {
    echo "<h1>Error al renderizar template</h1>";
    echo "<p>" . $e->getMessage() . "</p>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}
?>

