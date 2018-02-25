<?php

namespace Bootstrap;

use App\Controller\AbstractController;
use App\Controller\ErrorController;
use Libs\Request;
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

        if ($this->isDebug()) {
            $this->enableDebugMode();
        }

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
            $controller->setRequest($this->getRequest());
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
        $this->getRouter()->setRoutes(require(__DIR__.'/../config/routes.php'));
        $this->router = $this->getRouter();
    }

    protected function getRouter(): RouterInterface
    {
        return $this->container->get('libs.router');
    }

    protected function getRequest(): Request
    {
        return $this->container->get('libs.request');
    }

    protected function getConfigPath(): string
    {
        return __DIR__ . '/../config/config.php';
    }
}