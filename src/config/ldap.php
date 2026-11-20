<?php

// Configuración LDAP: todos los valores vienen del .env (LDAP_*). No escribir credenciales aquí.
return [
    'host' => $_ENV['LDAP_HOST'] ?? '',
    'port' => $_ENV['LDAP_PORT'] ?? 389,
    'bind_dn' => $_ENV['LDAP_BIND_DN'] ?? '',
    'bind_password' => $_ENV['LDAP_BIND_PASSWORD'] ?? '',
    'base_dn' => $_ENV['LDAP_BASE_DN'] ?? '',
    'timeout' => $_ENV['LDAP_TIMEOUT'] ?? 10,
    'protocol_version' => $_ENV['LDAP_PROTOCOL_VERSION'] ?? 3,
    'referrals' => $_ENV['LDAP_REFERRALS'] ?? 0,
    'user_filter' => $_ENV['LDAP_USER_FILTER'] ?? '',
    'attributes' => [
        'displayname',
        'cn',
        'mail',
        'sAMAccountName'
    ]
];
