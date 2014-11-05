<?php

namespace Abbiya\Watcher\Event;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ExecuteCommand
 *
 * @author seshachalam
 */
use Symfony\Component\EventDispatcher\Event;

class ExecuteCommandEvent extends Event {

    private $path;

    public function __construct($path) {
        $this->path = $path;
    }

    public function setPath($path) {
        $this->path = $path;
        return $this;
    }

    public function getPath() {
        return $this->path;
    }

}
