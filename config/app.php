<?php

return [
    'app_url' => $_ENV['APP_URL'] ?? 'https://biblioges.ucn.cl',
    'app_env' => $_ENV['APP_ENV'] ?? 'production',
    'app_debug' => $_ENV['APP_DEBUG'] ?? false,
    'session_lifetime' => $_ENV['SESSION_LIFETIME'] ?? 120,
]; 