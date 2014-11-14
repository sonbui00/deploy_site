<?php
/**
 * Created by PhpStorm.
 * User: sonbv
 * Date: 13/11/2014
 * Time: 09:46
 */

namespace SonBV;

use SonBV\Environment;
use SonBV\Environment\EnvironmentInterface;


class Git {

    /**
     * Environment for exec git command
     * @var Environment\EnvironmentInterface
     * */
    private $_environment = null;

    private $_repositoryPath;

    function __construct(EnvironmentInterface $environment, $repositoryPath)
    {
        $this->_environment = $environment;
        $this->_repositoryPath = $repositoryPath;
    }

    public function pull($branch)
    {
        if (!empty($branch)) {
            $this->checkOutBranch($branch);
        }
        $output = $this->execute('git pull');
        return implode('<br />', $output);
    }

    public function getCurrentBranch()
    {
        $output = $this->execute('git status --porcelain --branch');
        $tmp = explode(' ', $output[0]);
        $tmp = explode('...', $tmp[1]);
        return $tmp[0];
    }

    public function getBranches()
    {
        return $this->execute('git branch');
    }

    /**
     * @return array
     */
    public function getOtherBranches()
    {
        $branches = $this->execute('git branch');
        $output = array();
        foreach ($branches as $branch) {
            $branch = trim($branch);
            if ($this->_checkOtherBranches($branch)) {
                $output[] = $branch;
            }
        }
        return $output;
    }

    protected function execute($commands)
    {
        if (0 === strpos($commands, 'git')) {
            $commands = $this->_beforeRunGitCommand($commands);
        }
        $commands = $this->_changeDir($this->_repositoryPath, $commands);
        return $this->_environment->run($commands);
    }

    private function _changeDir($repositoryPath, $commands)
    {
        $commands = 'cd ' . $repositoryPath . ';' . $commands;
        return $commands;
    }

    /**
     * @param $branch
     * @return bool
     */
    protected function _checkOtherBranches($branch)
    {
        return !empty($branch) && $branch != 'master' && $branch[0] != '*';
    }

    public function checkOutBranch($branch)
    {
        if (in_array($branch, $this->getOtherBranches())) {
//            try {
                $this->execute('git checkout ' . $branch);
//            } catch (\Exception $e) {

//            }
        }
    }

    protected function _beforeRunGitCommand($command)
    {
        if ('local' == $this->_environment->getTypeConnect()) {
            $user = $this->_getUser();
            if (!empty($user)) {
                $result = 'sudo -u ' . $user . ' ' . $command;
            } else {
                return $command;
                throw new \Exception('No config user');
            }
            return $result;
        }
        return $command;
    }

    protected function _getUser()
    {
        if (defined('USERNAME')) {
            return USERNAME;
        }
//        return 'root';
    }


} 