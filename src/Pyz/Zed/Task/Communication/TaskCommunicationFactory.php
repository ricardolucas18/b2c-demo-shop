<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Task\Communication;

use Pyz\Zed\Task\Communication\Form\TaskDeleteConfirmationForm;
use Pyz\Zed\Task\Communication\Table\TasksTable;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;
use Symfony\Component\Form\FormInterface;

/**
 * @method \Pyz\Zed\Task\Persistence\TaskEntityManagerInterface getEntityManager()
 * @method \Pyz\Zed\Task\TaskConfig getConfig()
 * @method \Pyz\Zed\Task\Persistence\TaskRepositoryInterface getRepository()
 * @method \Pyz\Zed\Task\Business\TaskFacadeInterface getFacade()
 * @method \Pyz\Zed\Task\Persistence\TaskQueryContainerInterface getQueryContainer()
 */
class TaskCommunicationFactory extends AbstractCommunicationFactory
{
    /**
     * @return \Pyz\Zed\Task\Communication\Table\TasksTable
     */
    public function createTasksTable(): TasksTable
    {
        return new TasksTable(
            $this->getQueryContainer(),
        );
    }

    /**
     * @return \Symfony\Component\Form\FormInterface
     */
    public function getTaskDeleteConfirmForm(): FormInterface
    {
        return $this->getFormFactory()->create(TaskDeleteConfirmationForm::class);
    }
}
