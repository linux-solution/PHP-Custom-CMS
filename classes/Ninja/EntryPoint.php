<?php
namespace Ninja;

// enforceing by interface.
    /* 
        - enforced classes like as "\Ninja\Routes $routes" must contain described function in interface like as getRoute(), if not, an error.
        - this interface can be used as hint type. hint means "string" or "\Ninja\Routes" in "string $route, \Ninja\Routes $routes".
    */
interface Routes
{
    public function getRoutes();
}

class EntryPoint
{
    private $route;
    private $method;

    private $routes;
    
    // initializing EntryPoint class, check request_url status.
    public function __construct(string $route, string $method, \Ninja\Routes $routes)
    {
        $this->route = $route;
        $this->method = $method;

        $this->routes = $routes;
        
        $this->checkUrl();
    }

    // check url if the request route is lowercase. If not, convert it to lowercase and redirect page.
    private function checkUrl()
    {
        if ($this->route !== strtolower($this->route)) {
            http_response_code(301);
            header('Location: ' . "http://". $_SERVER['SERVER_NAME'] . "/". strtolower($this->route));
        }
    }

    // load html to draw requested page on the broswer.
    private function loadTemplate($templateFileName, $variables = []) {
        extract($variables);
        ob_start();
        include  __DIR__ . '/../../templates/' . $templateFileName;
        return ob_get_clean();
    }

    // Entry point main function.
    public function run()
    {
        // get whole routing structure from IjdbRoutes class.
        $routes = $this->routes->getRoutes();   // $this->routes indicates \Ijdb\IjdbRoutes().

        // get controller and action to get page data, respond to browser request, from pre-structured routes above.
        $controller = $routes[$this->route][$this->method]['controller'];
        $action = $routes[$this->route][$this->method]['action'];

        $page = $controller->$action();

        // html drawing section.
        $title = $page['title'];

        if (isset($page['variables'])) {
            $output = $this->loadTemplate($page['template'], $page['variables']);
        }
        else {
            $output = $this->loadTemplate($page['template']);
        }

        include  __DIR__ . '/../../templates/layout.html.php';
        ///////////////////////
    }
}