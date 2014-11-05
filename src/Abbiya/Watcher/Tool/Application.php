<?php

namespace Abbiya\Watcher\Tool;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of WatchApplication
 *
 * @author seshachalam
 */
use Symfony\Component\Console\Application as BaseApplication;
use Symfony\Component\Console\Input\InputInterface;

class Application extends BaseApplication {

    const NAME = 'Abbiya\'s\' Console Application';
    const VERSION = '1.0';

    public function __construct()
    {
        parent::__construct(static::NAME, static::VERSION);
    }
    
    protected function getCommandName(InputInterface $input) {
        // This should return the name of your command.
        return 'iwatch';
    }

    protected function getDefaultCommands() {
        // Keep the core default commands to have the HelpCommand
        // which is used when using the --help option
        $defaultCommands = parent::getDefaultCommands();

        return $defaultCommands;
    }

    public function getDefinition() {
        $inputDefinition = parent::getDefinition();
        // clear out the normal first argument, which is the command name
        $inputDefinition->setArguments();

        return $inputDefinition;
    }

}
