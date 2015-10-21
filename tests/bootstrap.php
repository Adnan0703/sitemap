<?php
/**
 * Test suite bootstrap for Sitemap.
 *
 * This function is used to find the location of CakePHP whether CakePHP
 * has been installed as a dependency of the plugin, or the plugin is itself
 * installed as a dependency of an application.
 */
 /*
$findRoot = function ($root) {
    do {
        $lastRoot = $root;
        $root = dirname($root);
        if (is_dir($root . '/vendor/cakephp/cakephp')) {
            return $root;
        }
    } while ($root !== $lastRoot);

    throw new Exception("Cannot find the root of the application, unable to run tests");
};
$root = $findRoot(__FILE__);
unset($findRoot);

chdir($root);
require $root . '/config/bootstrap.php';
*/

if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}
define('ROOT', dirname(__DIR__) . DS); // ROOT = /sitemap/
define('CAKE_CORE_INCLUDE_PATH', ROOT . 'vendor' . DS . 'cakephp' . DS . 'cakephp');
// CAKE_CORE_INCLUDE_PATH = /sitemap/vendor/cakephp/cakephp
define('CORE_PATH', ROOT . 'vendor' . DS . 'cakephp' . DS . 'cakephp' . DS);
// CORE_PATH = /sitemap/vendor/cakephp/cakephp/
define('CAKE', CORE_PATH . 'src' . DS);
// CAKE = /sitemap/vendor/cakephp/cakephp/src/
define('TESTS', ROOT . 'tests');
// TESTS = /sitemap/tests
define('APP', ROOT . 'tests' . DS . 'TestApp' . DS);
// APP = /sitemap/tests/TestApp/
define('APP_DIR', 'TestApp');
// APP_DIR = TestApp
define('WEBROOT_DIR', 'webroot');
// WEBROOT_DIR = webroot
define('WWW_ROOT', APP . 'webroot' . DS);
// WWW_ROOT = /sitemap/tests/TestApp/webroot/
define('TMP', sys_get_temp_dir() . DS);
define('CONFIG', APP . 'config' . DS);
// CONFIG = /sitemap/tests/TestApp/config/
define('CACHE', TMP);
define('LOGS', TMP);


require ROOT . '/vendor/autoload.php';
require CORE_PATH . 'config/bootstrap.php';

mb_internal_encoding('UTF-8');
date_default_timezone_set('UTC');

$Tmp = new Cake\Filesystem\Folder(TMP);
$Tmp->create(TMP . 'cache/models', 0770);
$Tmp->create(TMP . 'cache/persistent', 0770);
$Tmp->create(TMP . 'cache/views', 0770);

$cache = [
	'default' => [
		'engine' => 'File',
		'path' => CACHE
	],
	'_cake_core_' => [
		'className' => 'File',
		'prefix' => 'crud_myapp_cake_core_',
		'path' => CACHE . 'persistent/',
		'serialize' => true,
		'duration' => '+10 seconds'
	],
	'_cake_model_' => [
		'className' => 'File',
		'prefix' => 'crud_my_app_cake_model_',
		'path' => CACHE . 'models/',
		'serialize' => 'File',
		'duration' => '+10 seconds'
	]
];

Cake\Cache\Cache::config($cache);
Cake\Core\Configure::write('debug', true);
Cake\Core\Configure::write('App', [
    'namespace' => 'TestApp',
    'encoding' => 'UTF-8',
    'base' => false,
    'baseUrl' => false,
    'dir' => APP_DIR,
    'webroot' => 'webroot',
    'wwwRoot' => WWW_ROOT,
    'fullBaseUrl' => 'http://localhost',
    'imageBaseUrl' => 'img/',
    'jsBaseUrl' => 'js/',
    'cssBaseUrl' => 'css/'
]);

// Ensure default test connection is defined
if (!getenv('db_class')) {
	putenv('db_class=Cake\Database\Driver\Sqlite');
	putenv('db_dsn=sqlite::memory:');
}

Cake\Datasource\ConnectionManager::config('test', [
	'className' => 'Cake\Database\Connection',
	'driver' => getenv('db_class'),
	'dsn' => getenv('db_dsn'),
	'database' => getenv('db_database'),
	'username' => getenv('db_username'),
	'password' => getenv('db_password'),
	'timezone' => 'UTC',
	'quoteIdentifiers' => true,
	'cacheMetadata' => true,
]);
