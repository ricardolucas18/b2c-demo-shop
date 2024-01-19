<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Glue\TasksBackendApi\Plugin;

use Pyz\Glue\TasksBackendApi\Controller\TasksController;
use Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\RouteProviderPluginInterface;
use Spryker\Glue\Kernel\Backend\AbstractPlugin;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class TasksRouteProviderPlugin extends AbstractPlugin implements RouteProviderPluginInterface
{
    /**
     * @param \Symfony\Component\Routing\RouteCollection $routeCollection
     *
     * @return \Symfony\Component\Routing\RouteCollection
     */
    public function addRoutes(RouteCollection $routeCollection): RouteCollection
    {
        $routeCollection = $this->addTaskCreateRoute($routeCollection);
        $routeCollection = $this->addTaskFindRoute($routeCollection);
        $routeCollection = $this->addTaskFindCollectionRoute($routeCollection);
        $routeCollection = $this->addTaskUpdateRoute($routeCollection);
        $routeCollection = $this->addTaskDeleteRoute($routeCollection);

        return $routeCollection;
    }

    /**
     * @param \Symfony\Component\Routing\RouteCollection $routeCollection
     *
     * @return \Symfony\Component\Routing\RouteCollection
     */
    public function addTaskCreateRoute(RouteCollection $routeCollection): RouteCollection
    {
        $postRoute = (new Route('/task'))
            ->setDefaults([
                '_controller' => [TasksController::class, 'createAction'],
                '_resourceName' => 'task',
            ])
            ->setMethods(Request::METHOD_POST);

        $routeCollection->add('taskPost', $postRoute);

        return $routeCollection;
    }

    /**
     * @param \Symfony\Component\Routing\RouteCollection $routeCollection
     *
     * @return \Symfony\Component\Routing\RouteCollection
     */
    public function addTaskFindRoute(RouteCollection $routeCollection): RouteCollection
    {
        $getRoute = (new Route('/task/{id}'))
            ->setDefaults([
                '_controller' => [TasksController::class, 'findAction'],
                '_resourceName' => 'task',
            ])
            ->setMethods(Request::METHOD_GET);

        $routeCollection->add('taskGet', $getRoute);

        return $routeCollection;
    }

    /**
     * @param \Symfony\Component\Routing\RouteCollection $routeCollection
     *
     * @return \Symfony\Component\Routing\RouteCollection
     */
    public function addTaskFindCollectionRoute(RouteCollection $routeCollection): RouteCollection
    {
        $postRoute = (new Route('/tasks'))
            ->setDefaults([
                '_controller' => [TasksController::class, 'findCollectionAction'],
                '_resourceName' => 'task',
            ])
            ->setMethods(Request::METHOD_POST);

        $routeCollection->add('tasksGet', $postRoute);

        return $routeCollection;
    }

    /**
     * @param \Symfony\Component\Routing\RouteCollection $routeCollection
     *
     * @return \Symfony\Component\Routing\RouteCollection
     */
    public function addTaskUpdateRoute(RouteCollection $routeCollection): RouteCollection
    {
        $putRoute = (new Route('/task/update/{id}'))
            ->setDefaults([
                '_controller' => [TasksController::class, 'updateAction'],
                '_resourceName' => 'task',
            ])
            ->setMethods(Request::METHOD_PUT);

        $routeCollection->add('taskPut', $putRoute);

        return $routeCollection;
    }

    /**
     * @param \Symfony\Component\Routing\RouteCollection $routeCollection
     *
     * @return \Symfony\Component\Routing\RouteCollection
     */
    public function addTaskDeleteRoute(RouteCollection $routeCollection): RouteCollection
    {
        $deleteRoute = (new Route('/task/delete/{id}'))
            ->setDefaults([
                '_controller' => [TasksController::class, 'deleteAction'],
                '_resourceName' => 'task',
            ])
            ->setMethods(Request::METHOD_DELETE);

        $routeCollection->add('taskDelete', $deleteRoute);

        return $routeCollection;
    }
}
