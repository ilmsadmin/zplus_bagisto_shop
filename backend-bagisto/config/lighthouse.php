<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Route configuration
    |--------------------------------------------------------------------------
    |
    | Controls the HTTP route that your GraphQL server responds to.
    | You may set `route` => false, to disable the default route
    | registration and take full control.
    |
    */

    'route' => [
        /*
         * The URI the endpoint responds to, e.g. mydomain.com/graphql.
         */
        'uri' => '/graphql',

        /*
         * Lighthouse creates a named route for convenient URL generation and redirects.
         */
        'name' => 'graphql',

        /*
         * Beware that middleware defined here runs before the GraphQL execution phase,
         * make sure to return spec-compliant responses in case an error is thrown.
         */
        'middleware' => [
            \Nuwave\Lighthouse\Http\Middleware\AcceptJson::class,
            // Uncomment to enable CORS middleware
            // \Fruitcake\Cors\HandleCors::class,
        ],

        /*
         * The `prefix` and `domain` configuration options are optional.
         */
        // 'prefix' => '',
        // 'domain' => '',
    ],

    /*
    |--------------------------------------------------------------------------
    | Schema declaration
    |--------------------------------------------------------------------------
    |
    | This is a path that points to where your GraphQL schema is located
    | relative to the application's root folder. You may also use the
    | `artisan lighthouse:print-schema` command to output the final schema.
    |
    */

    'schema' => [
        /*
         * Path to your .graphql files folder.
         */
        'register' => base_path('graphql/schema.graphql'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Schema Cache
    |--------------------------------------------------------------------------
    |
    | A large schema can be costly to parse on every request. Enable schema
    | caching to optimize performance of large schemas.
    |
    */

    'cache' => [
        /*
         * Setting to true enables schema caching.
         */
        'enable' => env('LIGHTHOUSE_CACHE_ENABLE', env('APP_ENV') !== 'local'),

        /*
         * Allowed values:
         * - "default" provided by Laravel
         * - "array" provided by Laravel, usually faster
         * - "file" provided by Laravel, persistent across requests
         * - other store defined in your Laravel cache config
         */
        'store' => env('LIGHTHOUSE_CACHE_STORE', 'default'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Namespaces
    |--------------------------------------------------------------------------
    |
    | These are the default namespaces where Lighthouse looks for classes
    | that extend functionality of the schema.
    |
    */

    'namespaces' => [
        'models' => ['App', 'App\\Models', 'Webkul\\Product\\Models', 'Webkul\\Category\\Models', 'Webkul\\Customer\\Models', 'Webkul\\Sales\\Models', 'Webkul\\Checkout\\Models'],
        'queries' => 'App\\GraphQL\\Queries',
        'mutations' => 'App\\GraphQL\\Mutations',
        'subscriptions' => 'App\\GraphQL\\Subscriptions',
        'interfaces' => 'App\\GraphQL\\Interfaces',
        'unions' => 'App\\GraphQL\\Unions',
        'scalars' => 'App\\GraphQL\\Scalars',
        'directives' => ['App\\GraphQL\\Directives'],
        'validators' => ['App\\GraphQL\\Validators'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Security
    |--------------------------------------------------------------------------
    |
    | Control how Lighthouse handles security related query validation.
    | Read more at https://lighthouse-php.com/master/security/security.html
    |
    */

    'security' => [
        'max_query_complexity' => \GraphQL\Validator\Rules\QueryComplexity::DISABLED,
        'max_query_depth' => \GraphQL\Validator\Rules\QueryDepth::DISABLED,
        'disable_introspection' => (bool) env('LIGHTHOUSE_SECURITY_DISABLE_INTROSPECTION', false),
    ],

    /*
    |--------------------------------------------------------------------------
    | Pagination
    |--------------------------------------------------------------------------
    |
    | Lighthouse uses cursor-based pagination by default, but also allows
    | offset-based pagination through the @paginate directive.
    |
    */

    'pagination' => [
        'default_count' => 10,
        'max_count' => 100,
    ],

    /*
    |--------------------------------------------------------------------------
    | Debug
    |--------------------------------------------------------------------------
    |
    | Control the debug level as described in http://webonyx.github.io/graphql-php/error-handling/
    | Debugging is only applied if the global Laravel debug config is set to true.
    |
    | When you set this value through an environment variable, use the following reference:
    | https://github.com/webonyx/graphql-php/blob/master/docs/error-handling.md#debugging-tool
    |
    | Partially debugging your schema can also be achieved by directives:
    | - @debug: Sets the debug flag for a single field.
    |
    */

    'debug' => env('LIGHTHOUSE_DEBUG', \GraphQL\Error\DebugFlag::INCLUDE_DEBUG_MESSAGE | \GraphQL\Error\DebugFlag::INCLUDE_TRACE),

    /*
    |--------------------------------------------------------------------------
    | Error Handlers
    |--------------------------------------------------------------------------
    |
    | Register error handlers that receive the Errors that occur during execution and
    | handle them. You may use this to log, filter or format the errors.
    | The classes must implement \Nuwave\Lighthouse\Execution\ErrorHandler
    |
    */

    'error_handlers' => [
        \Nuwave\Lighthouse\Execution\AuthenticationErrorHandler::class,
        \Nuwave\Lighthouse\Execution\AuthorizationErrorHandler::class,
        \Nuwave\Lighthouse\Execution\ValidationErrorHandler::class,
        \Nuwave\Lighthouse\Execution\ReportingErrorHandler::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Extensions
    |--------------------------------------------------------------------------
    |
    | Register extension classes that manipulate the AST during schema building.
    |
    */

    'extensions' => [
        // \Nuwave\Lighthouse\Schema\Extensions\ExtensionRequest::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Execution
    |--------------------------------------------------------------------------
    |
    | Control aspects of GraphQL query execution.
    |
    */

    'execution' => [
        /*
         * Lighthouse attempts to find a single resolver to call for your schema.
         * You may override this and resolve individual fields.
         */
        'single_field_resolver' => true,

        /*
         * If set to a positive number, no more than this many queries will be
         * executed in parallel in nested queries.
         */
        'max_execution_ms' => null,
    ],

    /*
    |--------------------------------------------------------------------------
    | Subscriptions
    |--------------------------------------------------------------------------
    |
    | Control the subscriptions feature of Lighthouse. This requires
    | the Pusher Channels driver to be configured in `config/broadcasting.php`.
    |
    */

    'subscriptions' => [
        /*
         * Determines if subscriptions are enabled.
         */
        'enable' => env('LIGHTHOUSE_SUBSCRIPTIONS_ENABLE', false),

        /*
         * Control the queue that subscription jobs are dispatched to.
         */
        'queue_push_subscriptions' => env('LIGHTHOUSE_QUEUE_PUSH_SUBSCRIPTIONS'),

        /*
         * Control the queue that subscription broadcasts are dispatched to.
         */
        'queue_broadcasts' => env('LIGHTHOUSE_QUEUE_BROADCASTS'),

        /*
         * Subscription update handlers that will handle updating the
         * subscriptions when mutations occur.
         */
        'update_handlers' => [
            // \App\GraphQL\Subscriptions\UpdateHandlers\YourHandler::class,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Apollo Federation
    |--------------------------------------------------------------------------
    |
    | Lighthouse can act as a federated service in an Apollo Federation setup.
    | https://www.apollographql.com/docs/federation/
    |
    */

    'federation' => [
        /*
         * Location of resolver classes when resolving the `_entities` field.
         */
        'entities_resolver_namespace' => 'App\\GraphQL\\Entities',
    ],

];