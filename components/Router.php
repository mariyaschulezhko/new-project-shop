<?php


namespace components;


class Router
{
    public $routes;

    public function __construct()
    {
        $routerPath = __DIR__ .'/../config/routes.php';
        $this->routes = require $routerPath;
    }

    private function getUrl()
    {
        if(!empty($_SERVER['REQUEST_URI']))
        {
            return trim($_SERVER['REQUEST_URI'], '/');
        }
    }

    public function run()
    {
        $url= $this->getUrl();

        foreach($this->routes as $urlPattern => $path)
        {
            if(preg_match("~$urlPattern~", $url))
            {
                $internalRoute = preg_replace("~$urlPattern~", $path, $url);
                $segments = explode('/', $internalRoute);

                $controllerName = ucfirst(array_shift($segments)) . 'Controller';
                $actionName = 'action' . ucfirst(array_shift($segments));

                $parameters = $segments;
                $namespaceControllerName = 'controllers\\' . $controllerName;

                if(class_exists($namespaceControllerName))
                    $controllerObject = new $namespaceControllerName;
                $result = call_user_func_array([$controllerObject, $actionName], $parameters);


                if($result != null)
                {
                    break;
                }





            }
        }
    }

}