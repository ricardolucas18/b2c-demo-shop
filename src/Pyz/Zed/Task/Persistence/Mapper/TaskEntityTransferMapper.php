<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Task\Persistence\Mapper;

use Generated\Shared\Transfer\PyzTaskEntityTransfer;
use Generated\Shared\Transfer\TaskTransfer;

class TaskEntityTransferMapper
{
    /**
     * @param \Generated\Shared\Transfer\TaskTransfer $taskTransfer
     * @param \Generated\Shared\Transfer\PyzTaskEntityTransfer $pyzTaskEntityTransfer
     *
     * @return \Generated\Shared\Transfer\PyzTaskEntityTransfer
     */
    public function mapTaskTransferToTaskEntity(
        TaskTransfer $taskTransfer,
        PyzTaskEntityTransfer $pyzTaskEntityTransfer,
    ): PyzTaskEntityTransfer {
        $pyzTaskEntityTransfer->fromArray($taskTransfer->toArray(), true);

        return $pyzTaskEntityTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\PyzTaskEntityTransfer $taskEntity
     * @param \Generated\Shared\Transfer\TaskTransfer $taskTransfer
     *
     * @return \Generated\Shared\Transfer\TaskTransfer
     */
    public function mapTaskEntityToTaskTransfer(PyzTaskEntityTransfer $taskEntity, TaskTransfer $taskTransfer): TaskTransfer
    {
        $taskTransfer->fromArray($taskEntity->toArray(), true);

        return $taskTransfer;
    }
}
