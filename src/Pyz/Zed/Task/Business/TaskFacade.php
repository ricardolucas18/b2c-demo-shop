<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Task\Business;

use Generated\Shared\Transfer\TaskCollectionResponseTransfer;
use Generated\Shared\Transfer\TaskCriteriaTransfer;
use Generated\Shared\Transfer\TaskResponseTransfer;
use Generated\Shared\Transfer\TaskTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \Pyz\Zed\Task\Business\TaskBusinessFactory getFactory()
 * @method \Pyz\Zed\Task\Persistence\TaskEntityManagerInterface getEntityManager()
 * @method \Pyz\Zed\Task\Persistence\TaskRepositoryInterface getRepository()
 */
class TaskFacade extends AbstractFacade implements TaskFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\TaskTransfer $taskTransfer
     *
     * @return \Generated\Shared\Transfer\TaskResponseTransfer
     */
    public function createTask(TaskTransfer $taskTransfer): TaskResponseTransfer
    {
        return $this->getFactory()->createCreateTask()->create($taskTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\TaskTransfer $taskTransfer
     *
     * @return \Generated\Shared\Transfer\TaskResponseTransfer
     */
    public function findTask(TaskTransfer $taskTransfer): TaskResponseTransfer
    {
        return $this->getFactory()->createFindTask()->find($taskTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\TaskCriteriaTransfer $taskCriteriaTransfer
     *
     * @return \Generated\Shared\Transfer\TaskCollectionResponseTransfer
     */
    public function findTaskCollection(TaskCriteriaTransfer $taskCriteriaTransfer): TaskCollectionResponseTransfer
    {
        return $this->getFactory()->createFindTask()->findTaskCollection($taskCriteriaTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\TaskTransfer $taskTransfer
     *
     * @return \Generated\Shared\Transfer\TaskResponseTransfer
     */
    public function updateTask(TaskTransfer $taskTransfer): TaskResponseTransfer
    {
        return $this->getFactory()->createUpdateTask()->update($taskTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\TaskTransfer $taskTransfer
     *
     * @return \Generated\Shared\Transfer\TaskResponseTransfer
     */
    public function deleteTask(TaskTransfer $taskTransfer): TaskResponseTransfer
    {
        return $this->getFactory()->createDeleteTask()->delete($taskTransfer);
    }
}
