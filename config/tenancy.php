<?php

return [
    'tenant_model' => \App\Models\Tenant::class,
    'id_generator' => \Stancl\Tenancy\UUIDGenerator::class,

    'domain_model' => \Stancl\Tenancy\Database\Models\Domain::class,

    'central_domains' => [
    'thecommunityhelpdesk.org',
    'www.thecommunityhelpdesk.org',
    '127.0.0.1',
    'localhost',
],
    'exempt_domains' => [],

    'database' => [
        'central_connection' => env('DB_CONNECTION', 'mysql'),
        
        'template_tenant_connection' => null,

        'prefix' => 'tenant',
        'suffix' => '',

        'managers' => [
            'mysql' => \Stancl\Tenancy\Database\DatabaseManager::class,
        ],
    ],

    'cache' => [
        'tag_base' => 'tenant',
    ],

    'filesystem' => [
        'suffix_base' => 'tenant',
        'disks' => [
            'local',
            'public',
        ],
    ],

    'redis' => [
        'prefix_base' => 'tenant',
        'prefixed_connections' => [
            // 'default',
        ],
    ],

    'features' => [
        // \Stancl\Tenancy\Features\UserImpersonation::class,
        \Stancl\Tenancy\Features\TenantConfig::class,
        \Stancl\Tenancy\Features\UniversalRoutes::class,
    ],

    'bootstrappers' => [
        \Stancl\Tenancy\Bootstrappers\DatabaseTenancyBootstrapper::class,
        \Stancl\Tenancy\Bootstrappers\CacheTenancyBootstrapper::class,
        \Stancl\Tenancy\Bootstrappers\FilesystemTenancyBootstrapper::class,
        \Stancl\Tenancy\Bootstrappers\QueueTenancyBootstrapper::class,
        // \Stancl\Tenancy\Bootstrappers\RedisTenancyBootstrapper::class,
    ],

    'database_names' => [
        'template' => env('DB_DATABASE') . '_template',
    ],

    'migration_parameters' => [
        '--force' => true,
        '--path' => [database_path('migrations/tenant')],
        '--realpath' => true,
    ],

    'seeder_parameters' => [
        '--class' => 'DatabaseSeeder',
    ],
];