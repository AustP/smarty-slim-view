# smarty-slim-view
View that allows you to use Smarty with Slim

## Installation

    composer require austp/smarty-slim-view

As a note, you will still need to require Slim and Smarty yourself. This view just integrates the two.

## Configuration
You need to define your template, compile, and cache directories upon initializing the View.
You can also optionally define a plugin directory.

    public function __construct($template_dir, $compile_dir, $cache_dir, $plugin_dir = '');

## Use

    <?php
    
    require('vendor/autoload.php');
    
    $app = new \Slim\Slim([
        'view' => new \Slim\View\Smarty(
            __DIR__ . '/templates',
            __DIR__ . '/templates/compile',
            __DIR__ . '/templates/cache
        );
    ]);
    
    $app->get('/', function () use ($app) {
        $view = $app->view();
        $view->assign('title', 'Hello World');
        
        $view->display('base.tpl');
    });
    
    $app->run();
