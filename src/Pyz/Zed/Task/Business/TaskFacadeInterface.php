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

interface TaskFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\TaskTransfer $taskTransfer
     *
     * @return \Generated\Shared\Transfer\TaskResponseTransfer
     */
    public function createTask(TaskTransfer $taskTransfer): TaskResponseTransfer;

    /**
     * @param \Generated\Shared\Transfer\TaskTransfer $taskTransfer
     *
     * @return \Generated\Shared\Transfer\TaskResponseTransfer
     */
    public function findTask(TaskTransfer $taskTransfer): TaskResponseTransfer;

    /**
     * @param \Generated\Shared\Transfer\TaskCriteriaTransfer $taskCriteriaTransfer
     *
     * @return \Generated\Shared\Transfer\TaskCollectionResponseTransfer
     */
    public function findTaskCollection(TaskCriteriaTransfer $taskCriteriaTransfer): TaskCollectionResponseTransfer;

    /**
     * @param \Generated\Shared\Transfer\TaskTransfer $taskTransfer
     *
     * @return \Generated\Shared\Transfer\TaskResponseTransfer
     */
    public function updateTask(TaskTransfer $taskTransfer): TaskResponseTransfer;

    /**
     * @param \Generated\Shared\Transfer\TaskTransfer $taskTransfer
     *
     * @return \Generated\Shared\Transfer\TaskResponseTransfer
     */
    public function deleteTask(TaskTransfer $taskTransfer): TaskResponseTransfer;
}
