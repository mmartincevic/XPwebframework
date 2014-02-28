<?php
/**
 * XPF
 *
 * @author      djomla <mladen.martincevic@g.com>
 * @copyright   2014 djomla
 * @link        http://github.com/mmartincevic/
 * @version     1.0
 * @package     XPF
 *
*/

$app = new \Slim\Slim(array(
    'mode' => 'production'
));

## Configure error handling ##
$app->error(function (\Exception $e) use ($app) {
    echo $e->getMessage();
    echo "mladen";
    //$app->render('error.php');
});

## Configure loging ##
$app->container->singleton('log', function () {
    $log = new \Monolog\Logger('slim-skeleton');
    $log->pushHandler(new \Monolog\Handler\StreamHandler('../logs/app.log', \Monolog\Logger::DEBUG));
    return $log;
});

## Setup configuration for different modes ##
// Only invoked if mode is "production"
$app->configureMode('production', function () use ($app) {
    $app->config(array(
        'log.level'         => \Slim\Log::EMERGENCY,
        'log.enable'        => true,
        'debug'             => false,
        'templates.path'    => '../templates/'
    ));
});

// Only invoked if mode is "development"
$app->configureMode('development', function () use ($app) {
    $app->config(array(
        'log.level'          => \Slim\Log::DEBUG,
        'log.enable'         => true,
        'debug'              => true,
        'templates.path'    => '../templates/'
    ));
});

## Configure template views ##
$app->view(new \Slim\Views\Twig());
$app->view->parserOptions = array(
    'charset' => 'utf-8',
    'cache' => realpath('../templates/cache'),
    'auto_reload' => true,
    'strict_variables' => false,
    'autoescape' => true
);
$app->view->parserExtensions = array(new \Slim\Views\TwigExtension());


if(!is_dir('../controllers/')) {
    throw new Exception(
            'Invalid controller path: ' . '../controllers/');
}

if ($cdh = opendir('../controllers')) {
    while (false !== ($file = readdir($cdh))) {
        if ($file != "." && $file != "..") {
            require_once('../controllers/' . $file);
        }
    }
    closedir($cdh);
}
