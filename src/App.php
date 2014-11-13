<?php
/**
 * Created by PhpStorm.
 * User: sonbv
 * Date: 13/11/2014
 * Time: 14:22
 */

namespace SonBV;

use SonBV\Environment\EnvironmentInterface;
use SonBV\Environment\Factory;
use SonBV\Git;

ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);
include dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor/autoload.php';
include __DIR__ .DIRECTORY_SEPARATOR . 'config.php';

class App {

    /**
     * @var EnvironmentInterface
     * */
    private static $_environment;

    /**
     * @var Git
     * */
    private static $_git;

    public static function run()
    {
        self::$_environment = Factory::getInstance();
        self::$_git = new Git(self::$_environment, GIT_DIR);
    }

    /**
     * @return Git
     */
    public static function getGit()
    {
        return self::$_git;
    }

    /**
     * @return EnvironmentInterface
     */
    public static function getEnvironment()
    {
        return self::$_environment;
    }

    public static function clearCache($code)
    {
        $command = 'rm -rf /var/www/clients/client1/web60/web/'
            . $code . '/var/cache/*;';
        self::getEnvironment()->run($command);
        return 'Clear all cache';
    }
} 