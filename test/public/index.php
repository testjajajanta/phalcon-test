<?php
declare(strict_types=1);

use Phalcon\Di\FactoryDefault;
use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Application;
use Phalcon\Url;
use Phalcon\Db\Adapter\Pdo\Mysql;

error_reporting(E_ALL);

// Define some absolute path constants to aid in locating resources
define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');

// オートローダーの登録
$loader = new Loader();
$loader->registerDirs(
    [
        APP_PATH . '/controllers/',
        APP_PATH . '/models/',
    ]
);
$loader->register();

// Create a DI
$container = new FactoryDefault();
$container->set(
    'view',
    function () {
        $view = new View();
        $view->setViewsDir(APP_PATH . '/views/');

        return $view;
    }
);
$container->set(
    'url',
    function () {
        $url = new Url();
        $url->setBaseUri('/phalcon-test/test/');

        return $url;
    }
);
$container->set(
    'db',
    function () {
        return new Mysql(
            [
                'host'     => '127.0.0.1',
                'username' => 'root',
                'password' => '',
                'dbname'   => 'test',
            ]
        );
    }
);
$application = new Application($container);

try {
    // Handle the request
    $response = $application->handle(
        $_GET['_url'] ?? '/'
    );

    $response->send();
} catch (\Exception $e) {
    echo 'Exception: ', $e->getMessage();
}






// try {
//     /**
//      * The FactoryDefault Dependency Injector automatically registers
//      * the services that provide a full stack framework.
//      */
//     $di = new FactoryDefault();

//     /**
//      * Read services
//      */
//     include APP_PATH . '/config/services.php';

//     /**
//      * Handle routes
//      */
//     include APP_PATH . '/config/router.php';

//     /**
//      * Get config service for use in inline setup below
//      */
//     $config = $di->getConfig();

//     /**
//      * Include Autoloader
//      */
//     include APP_PATH . '/config/loader.php';

//     /**
//      * Handle the request
//      */
//     $application = new \Phalcon\Mvc\Application($di);

//     echo $application->handle($_GET['_url'] ?? '/')->getContent();


// } catch (\Exception $e) {
//     echo $e->getMessage() . '<br>';
//     echo '<pre>' . $e->getTraceAsString() . '</pre>';
// }
