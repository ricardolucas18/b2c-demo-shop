<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Task\Communication\Controller;

use Spryker\Zed\Kernel\Communication\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @method \Pyz\Zed\Task\Persistence\TaskRepositoryInterface getRepository()
 * @method \Pyz\Zed\Task\Business\TaskFacadeInterface getFacade()
 * @method \Pyz\Zed\Task\Communication\TaskCommunicationFactory getFactory()
 * @method \Pyz\Zed\Task\Persistence\TaskQueryContainerInterface getQueryContainer()
 */
class IndexController extends AbstractController
{
    /**
     * @return array<mixed>
     */
    public function indexAction(): array
    {
        $tasksTable = $this->getFactory()->createTasksTable();

        return [
            'tasks' => $tasksTable->render(),
        ];
    }

    /**
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function tableAction(): JsonResponse
    {
        $table = $this->getFactory()->createTasksTable();

        return $this->jsonResponse(
            $table->fetchData(),
        );
    }
}
