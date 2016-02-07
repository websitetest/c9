<?php
namespace src\Framework\lib\HTTP;

class Request {
    
    protected $post;
    protected $params;
    protected $server;
    protected $files;
    protected $cookies;
    
    protected $pathinfo;
    
    public function __construct($post, $params, $server, $files, $cookies) {
        
        $this->initialize($post, $params, $server, $files, $cookies);
    }
    
    public static function createFromGlobals() {
        
        $request = self::createRequest($_POST, $_GET, $_SERVER, $_FILES, $_COOKIE);
        return $request;
    }
    
    protected function createRequest($post, $params, $server, $files, $cookies) {
        
        $request = new Request($post, $params, $server, $files, $cookies);
        return $request;
    }
    
    public function initialize($post, $params, $server, $files, $cookies) {
        
        $this->post = $post;
        $this->params = $params;
        $this->server = new ServerBag($server);
        $this->files = new FileBag($files);
        $this->cookies = new CookieBag($cookies);
        
        $this->pathinfo = $_SERVER['PATH_INFO'];
        
    }
    
    public function pathInfo() {
        
        return $this->pathinfo;
    }
}
?>