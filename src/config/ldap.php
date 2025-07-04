<?php

return [
    'host' => $_ENV['LDAP_HOST'] ?? '146.83.118.18',
    'port' => $_ENV['LDAP_PORT'] ?? 389,
    'bind_dn' => $_ENV['LDAP_BIND_DN'] ?? 'adminbidoc',
    'bind_password' => $_ENV['LDAP_BIND_PASSWORD'] ?? 'H_205p#M',
    'base_dn' => $_ENV['LDAP_BASE_DN'] ?? 'DC=biblioteca,DC=ucn,DC=cl',
    'timeout' => $_ENV['LDAP_TIMEOUT'] ?? 10,
    'protocol_version' => $_ENV['LDAP_PROTOCOL_VERSION'] ?? 3,
    'referrals' => $_ENV['LDAP_REFERRALS'] ?? 0,
    'user_filter' => $_ENV['LDAP_USER_FILTER'] ?? '(sAMAccountName={rut})',
    'attributes' => [
        'displayname',
        'cn',
        'mail',
        'sAMAccountName'
    ]
]; 