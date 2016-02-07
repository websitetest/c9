<?php
namespace src\Framework\lib\Session;
use src\Framework\lib\Session\SessionInterface;

interface SessionStorageInterface {
    
    public function create(SessionInterface $session);
    public function get(SessionInterface $session);
    public function update(SessionInterface $session);
    public function destroy(SessionInterface $session);
}