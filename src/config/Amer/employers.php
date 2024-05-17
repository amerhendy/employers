<?php
$sources=[
    'images'=>'images',
];

return [
    'route_prefix' => 'Employers',
    'routeName_prefix'=>'Employers',
    'web_middleware' => 'web',
    'view_namespace' => 'Employers::',
    'root_disk_name' => 'employers',
    'package_path'=>base_path().'\\vendor\Amerhendy\Employers\src\\',
        'auth'=>[
            'model'=>\Amerhendy\Employers\App\Models\Base\Employers::class,
            'middleware_key'=>'Employers',
            'middleware_class'=>[
                \Amerhendy\Employers\App\Http\Middleware\CheckIfAdmin::class,
                \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
                \Amerhendy\Employers\App\Http\Middleware\AuthenticateSession::class,
            ],
        ],
    'nameSpace'=>'Amerhendy\Employers',
    'Controllers'=>'Amerhendy\Employers\App\Http\Controllers',
    'guard' => 'Employers',

];