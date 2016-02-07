<?php
namespace src\Framework\lib\Console\Command;
use src\Framework\lib\Console\Exception\LogicException;

class Command {
    
    protected $application;
    protected $name;
    protected $help;
    
    public function getHelp() {
        
        return $this->help;
    }
    
    public function execute(InputInterface $input, OutputInterface $output) {
        
        throw new LogicException('This method should be overridden');
    }
}
?>