<?php
namespace src\Framework\lib\Dependency;
use src\Framework\lib\Dependency\ContainerInterface;

interface ContainerDependentInterface {
    
    public function setContainer(ContainerInterface $container);
}
?>