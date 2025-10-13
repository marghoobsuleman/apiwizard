<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Model Namespace
    |--------------------------------------------------------------------------
    |
    | The default namespace for generated models.
    |
    */
    'model_namespace' => 'App\\Models',

    /*
    |--------------------------------------------------------------------------
    | Controller Namespace
    |--------------------------------------------------------------------------
    |
    | The default namespace for generated controllers.
    |
    */
    'controller_namespace' => 'App\\Http\\Controllers\\API',

    /*
    |--------------------------------------------------------------------------
    | Model Path
    |--------------------------------------------------------------------------
    |
    | The default path where models will be generated.
    |
    */
    'model_path' => app_path('Models'),

    /*
    |--------------------------------------------------------------------------
    | Controller Path
    |--------------------------------------------------------------------------
    |
    | The default path where controllers will be generated.
    |
    */
    'controller_path' => app_path('Http/Controllers/API'),

    /*
    |--------------------------------------------------------------------------
    | Routes File
    |--------------------------------------------------------------------------
    |
    | The file where API routes will be added.
    |
    */
    'routes_file' => base_path('routes/api.php'),

    /*
    |--------------------------------------------------------------------------
    | Default Pagination
    |--------------------------------------------------------------------------
    |
    | Default number of items per page for API responses.
    |
    */
    'pagination' => 15,
];
