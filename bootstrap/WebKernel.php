<?php

namespace Bootstrap;

use App\Controller\AbstractController;
use App\Controller\ErrorController;
use Libs\Router;
use Libs\RouterInterface;

class WebKernel extends AbstractKernel
{
    /**
     * @var Router
     */
    protected $router;

    public function __construct()
    {
        $this->container = $this->getContainer();
        $this->loadRouter();
    }

    public function run(): void
    {
        try {
            $resolvedRoute = $this->router->resolve($_SERVER['REQUEST_URI']);
            /**
             * @var AbstractController $controller
             */
            $controller = new $resolvedRoute['controller']();
            $controller->setContainer($this->getContainer());
            $response = call_user_func_array([$controller, $resolvedRoute['action']], $resolvedRoute['parameters'] ?? []);
            $response->sendResponse();
        }
        catch (\Exception $ex) {
            $this->renderException($ex);
        }
    }

    protected function renderException(\Exception $ex): void
    {
        $controller = new ErrorController();
        $controller->setContainer($this->getContainer());
        $response = $controller->error500($ex);
        $response->sendResponse();
    }

    protected function loadRouter()
    {
        $this->getRouter()->setRouteArray(require(__DIR__.'/../config/routes.php'));
        $this->router = $this->getRouter();
    }

    protected function getRouter(): RouterInterface
    {
        return $this->container->get('libs.router');
    }
}