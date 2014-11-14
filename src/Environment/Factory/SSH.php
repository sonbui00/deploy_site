<?php
/**
 * Created by PhpStorm.
 * User: sonbv
 * Date: 13/11/2014
 * Time: 10:04
 */

namespace SonBV\Environment\Factory;


use SonBV\Environment\EnvironmentInterface;
use Ssh\Authentication\Password;
use Ssh\Configuration;
use Ssh\Exec;
use Ssh\Session;

class SSH implements EnvironmentInterface {

    /* @var Exec */
    private $_connection;

    public function run($commands)
    {
        if (!isset($_connection)) {

            $configuration = new Configuration(HOSTNAME);
            $authentication = new Password(USERNAME, PASSWORD);

            $session = new Session($configuration, $authentication);

            $this->_connection = $session->getExec();
        }

        $output = $this->_connection->run($commands);
        return explode("\n", $output);
    }

    public function getTypeConnect()
    {
        return 'remote';
    }
}