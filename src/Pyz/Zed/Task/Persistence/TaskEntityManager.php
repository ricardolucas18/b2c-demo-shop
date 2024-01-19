<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Task\Persistence;

use Generated\Shared\Transfer\PyzTaskEntityTransfer;
use Generated\Shared\Transfer\TaskTransfer;
use Orm\Zed\Task\Persistence\PyzTask;
use Pyz\Zed\Task\Persistence\Exception\TaskNotFoundException;
use Spryker\Zed\Kernel\Persistence\AbstractEntityManager;

/**
 * @method \Pyz\Zed\Task\Persistence\TaskPersistenceFactory getFactory()
 */
class TaskEntityManager extends AbstractEntityManager implements TaskEntityManagerInterface
{
    /**
     * @param \Generated\Shared\Transfer\TaskTransfer $taskTransfer
     *
     * @return \Generated\Shared\Transfer\TaskTransfer|null
     */
    public function saveTask(TaskTransfer $taskTransfer): ?TaskTransfer
    {
        if ($taskTransfer->getIdTask() === null) {
            return $this->createTask($taskTransfer);
        }

        return $this->updateTask($taskTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\TaskTransfer $taskTransfer
     *
     * @return \Generated\Shared\Transfer\TaskTransfer
     */
    private function createTask(TaskTransfer $taskTransfer): TaskTransfer
    {
        $taskEntityTransfer = $this->getFactory()
            ->createTaskEntityTransferMapper()
            ->mapTaskTransferToTaskEntity($taskTransfer, new PyzTaskEntityTransfer());

        /** @var \Generated\Shared\Transfer\PyzTaskEntityTransfer $taskEntityTransfer */
        $taskEntityTransfer = $this->save($taskEntityTransfer);

        return $this->getFactory()
            ->createTaskEntityTransferMapper()
            ->mapTaskEntityToTaskTransfer($taskEntityTransfer, $taskTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\TaskTransfer $taskTransfer
     *
     * @throws \Pyz\Zed\Task\Persistence\Exception\TaskNotFoundException
     *
     * @return \Generated\Shared\Transfer\TaskTransfer
     */
    private function updateTask(TaskTransfer $taskTransfer): TaskTransfer
    {
        $taskEntityTransfer = $this->getTaskEntityTransferById($taskTransfer);
        if ($taskEntityTransfer === null) {
            throw new TaskNotFoundException();
        }

        $taskEntityTransfer->fromArray($taskTransfer->toArray());
        $taskEntityTransfer = $this->saveTaskEntityTransfer($taskEntityTransfer);

        return (new TaskTransfer())->fromArray($taskEntityTransfer->toArray(), true);
    }

    /**
     * @param \Generated\Shared\Transfer\TaskTransfer $taskTransfer
     *
     * @return \Orm\Zed\Task\Persistence\PyzTask|null
     */
    private function getTaskEntityTransferById(TaskTransfer $taskTransfer): ?PyzTask
    {
        return $this->getFactory()
            ->createTaskQuery()
            ->findOneByIdTask($taskTransfer->getIdTask());
    }

    /**
     * @param \Orm\Zed\Task\Persistence\PyzTask $taskEntityTransfer
     *
     * @return \Orm\Zed\Task\Persistence\PyzTask
     */
    private function saveTaskEntityTransfer(PyzTask $taskEntityTransfer): PyzTask
    {
        if ($taskEntityTransfer->isModified()) {
            $taskEntityTransfer->save();
        }

        return $taskEntityTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\TaskTransfer $taskTransfer
     *
     * @throws \Pyz\Zed\Task\Persistence\Exception\TaskNotFoundException
     *
     * @return void
     */
    public function deleteTask(TaskTransfer $taskTransfer): void
    {
        $taskEntityTransfer = $this->getTaskEntityTransferById($taskTransfer);

        if ($taskEntityTransfer === null) {
            throw new TaskNotFoundException();
        }

        $taskEntityTransfer->delete();
    }
}
