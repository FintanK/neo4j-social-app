<?php
require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/../config/db.php';

use Neoxygen\NeoClient\ClientBuilder;

ini_set('error_reporting', -1);
ini_set('display_errors', 1);
ini_set('html_errors', 1); // I use this because I use xdebug.

$app = new Silex\Application();

$app['neo'] = $app->share(function(){

    $client = ClientBuilder::create()
        ->addConnection('default', 'http','localhost', 7474, true, NEO4J_USERNAME, NEO4J_PASSWORD)
        ->setAutoFormatResponse(true)
        ->build();

    return $client;
});
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../src/views',
));
$app->register(new Silex\Provider\MonologServiceProvider(), array(
    'monolog.logfile' => __DIR__.'/../logs/social.log'
));
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());

$app->get('/', 'FintanK\\Neo4JSocialApp\\Controller\\MainController::home')
    ->bind('home');

$app->get('/user/{name}', 'FintanK\\Neo4JSocialApp\\Controller\\MainController::showUser')
    ->bind('show_user');

$app->post('/relationship/create', 'FintanK\\Neo4JSocialApp\\Controller\\MainController::createRelationship')
    ->bind('relationship_create');

$app->post('/relationship/remove', 'FintanK\\Neo4JSocialApp\\Controller\\MainController::removeRelationship')
    ->bind('relationship_remove');

$app->run();
