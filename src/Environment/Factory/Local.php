<?php
/**
 * Created by PhpStorm.
 * User: sonbv
 * Date: 13/11/2014
 * Time: 10:01
 */

namespace SonBV\Environment\Factory;


use SonBV\Environment\EnvironmentInterface;

class Local implements EnvironmentInterface {

    public function run($commands)
    {
        exec($commands, $output, $returnValue);

        if ($returnValue !== 0) {
            throw new \RuntimeException($output);
        }

        return $output;
    }
}