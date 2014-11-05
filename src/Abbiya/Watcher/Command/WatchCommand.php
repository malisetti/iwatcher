<?php

namespace Abbiya\Watcher\Command;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of WatchCommand
 *
 * @author seshachalam
 */
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Abbiya\Watcher\Event\ExecuteCommandEvent;
use Abbiya\Watcher\ReactInotify\Inotify;
use React\EventLoop\Factory as EventLoopFactory;
use Symfony\Component\Process\Process;
use Abbiya\Watcher\EventListener\NotifyEventListener;
use Abbiya\Watcher\Event\Events;

class WatchCommand extends Command {

    private $dispatcher;

    protected function configure() {
        $this->setName('iwatch')
                ->setDescription('Watches over a file or directory')
                ->addArgument('file', InputArgument::REQUIRED, 'What to watch ?')
                ->addArgument('events', InputArgument::OPTIONAL, 'See the Inotify events. Give multiple events with | as separator')
                ->addArgument('commandToExec', InputArgument::OPTIONAL, 'Give the command to execute');
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        //get the flags and directories to watch and execute commands
        $loop = EventLoopFactory::create();
        $inotify = new Inotify($loop, $this->dispatcher);

        $watchableEvents = Events::getAllWatchableEvents();

        $file = $input->getArgument('file');
        $events = $input->getArgument('events');
        if (!$events) {
            $events = 'ALL';
        }

        $command = $input->getArgument('commandToExec');
        if (!$command) {
            $command = 'NONE';
        }

        $map = explode('|', $events);
        $bit = null;

        if ($events === 'ALL' || empty($map)) {
            $bit = Events::getAllEventsBit();
        } else {
            $eventsReflection = new \ReflectionClass('\Abbiya\Watcher\Event\Events');
            foreach ($map as $event) {
                $event = strtoupper($event);
                $eventConstant = $eventsReflection->getConstant($event);
                if ($bit === null) {
                    $bit = $eventConstant;
                } else {
                    $bit |= $eventConstant;
                }
            }
        }

        $inotify->add($file, $bit);
        $listener = new NotifyEventListener($command, $output);
        foreach ($watchableEvents as $watchableEvent => $functionName) {
            $this->dispatcher->addListener($watchableEvent, array($listener, $functionName));
            /*
              $this->dispatcher->addListener($watchableEvent, function(ExecuteCommandEvent $event) use($command, $output) {
              $filePath = $event->getPath();
              if ($command !== 'NONE') {
              $process = new Process($command);
              $process->run();
              if (!$process->isSuccessful()) {
              throw new \RuntimeException($process->getErrorOutput());
              }

              $output->writeln($process->getOutput());
              } else {
              $output->writeln($filePath);
              }
              });
             * 
             */
        }

        $loop->run();
    }

    public function setDispatcher(EventDispatcherInterface $dispatcher) {
        $this->dispatcher = $dispatcher;
    }

}
