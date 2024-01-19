<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Task\Persistence;

use Generated\Shared\Transfer\TaskTransfer;

/**
 * @method \Pyz\Zed\Task\Persistence\TaskPersistenceFactory getFactory()
 */
interface TaskEntityManagerInterface
{
    /**
     * @param \Generated\Shared\Transfer\TaskTransfer $taskTransfer
     *
     * @return \Generated\Shared\Transfer\TaskTransfer|null
     */
    public function saveTask(TaskTransfer $taskTransfer): ?TaskTransfer;

    /**
     * @param \Generated\Shared\Transfer\TaskTransfer $taskTransfer
     *
     * @return void
     */
    public function deleteTask(TaskTransfer $taskTransfer): void;
}
