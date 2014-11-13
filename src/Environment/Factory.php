<?php
/**
 * Created by PhpStorm.
 * User: sonbv
 * Date: 13/11/2014
 * Time: 10:38
 */

namespace SonBV\Environment;


use SonBV\Environment\Factory\Local;
use SonBV\Environment\Factory\SSH;

class Factory {

    /**
     * @var EnvironmentInterface
     * */
    private static $_environment;

    /**
     * @return EnvironmentInterface
     * */
    public static function getInstance($server = null)
    {
        if (!isset(self::$_environment)) {
            self::_initEnvironment($server);
        }
        return self::$_environment;
    }

    /**
     * @param $server
     */
    protected static function _initEnvironment($server)
    {
        if (!isset($server)) {
            if (defined('SERVER')) {
                $server = SERVER;
            } else {
                $server = 'local';
            }
        }

        switch ($server) {
            case 'remote':
                self::$_environment = new SSH();
                break;
            default:
                self::$_environment = new Local();
        }
    }


} 