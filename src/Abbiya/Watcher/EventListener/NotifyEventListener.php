<?php

namespace Abbiya\Watcher\EventListener;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of NotifyEventListener
 *
 * @author seshachalam
 */
use Abbiya\Watcher\Event\ExecuteCommandEvent;
use Symfony\Component\Process\Process;
use Symfony\Component\Console\Output\OutputInterface;

class NotifyEventListener {

    private $command;
    private $output;

    public function __construct($command, OutputInterface $output) {
        $this->command = $command;
        $this->output = $output;
    }

    public function onInAccess(ExecuteCommandEvent $event) {
        $this->execute($event->getPath());
    }

    public function onInModify(ExecuteCommandEvent $event) {
        $this->execute($event->getPath());
    }

    public function onInAttrib(ExecuteCommandEvent $event) {
        $this->execute($event->getPath());
    }

    public function onInOpen(ExecuteCommandEvent $event) {
        $this->execute($event->getPath());
    }

    public function onInCloseWrite(ExecuteCommandEvent $event) {
        $this->execute($event->getPath());
    }

    public function onInCloseNowrite(ExecuteCommandEvent $event) {
        $this->execute($event->getPath());
    }

    public function onInMovedFrom(ExecuteCommandEvent $event) {
        $this->execute($event->getPath());
    }

    public function onInDelete(ExecuteCommandEvent $event) {
        $this->execute($event->getPath());
    }

    public function onInCreate(ExecuteCommandEvent $event) {
        $this->execute($event->getPath());
    }

    public function onInDeleteSelf(ExecuteCommandEvent $event) {
        $this->execute($event->getPath());
    }

    private function execute($filePath) {
        if ($this->command !== 'NONE') {
            $process = new Process($this->command);
            $process->run();
            if (!$process->isSuccessful()) {
                throw new \RuntimeException($process->getErrorOutput());
            }

            $this->output->writeln($process->getOutput());
        } else {
            $this->output->writeln($filePath);
        }
    }

}
