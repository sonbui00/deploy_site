<?php
/**
 * Created by PhpStorm.
 * User: sonbv
 * Date: 06/11/2014
 * Time: 15:04
 */
function run($exec) {
    $r = '<pre>';
    try {
        $r .= $exec->run();
        $r .= "\nDone!!!!!\n";
    } catch (Exception $e) {
        $r .= "Error!!!!!!!!!!!!\n";
        $r .= $e->getMessage();
    }
    $r .= '</pre>';

    return $r;
}

class ExecCommand {

    protected static $_execSsh = null;

    protected static $_instance = null;

    protected $_commands = '';

    public static function getInstance()
    {
        if (!isset(static::$_instance)) {
            static::$_instance = new static;
        }
        return static::$_instance;
    }

    protected function __construct() {}

    public function run($command = null)
    {
        if (is_null($command)) {
            $command = $this->_commands;
            $this->_commands = '';
        }
//        echo $command . "\n";
        if (SERVER == 'local') {
            return $this->execPrint($command);

        } elseif (SERVER == 'remote') {
            if (!isset(static::$_execSsh)) {

                $configuration = new \Ssh\Configuration(HOSTNAME);
                $authentication = new Ssh\Authentication\Password(USERNAME, PASSWORD);

                $session = new \Ssh\Session($configuration, $authentication);

                static::$_execSsh = $session->getExec();

            }

            return static::$_execSsh->run($command);

        } else {}

    }

    public function addCommand($command)
    {
        $this->_commands .= $command;
    }

    private function execPrint($command) {
        $result = array();
        exec($command, $result);
        $r = '';
        foreach ($result as $line) {
            $r .= $line . "\n";
        }
        return $r;
    }


} 