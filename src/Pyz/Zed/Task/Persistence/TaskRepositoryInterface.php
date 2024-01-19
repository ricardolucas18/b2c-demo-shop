<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Task\Persistence;

use Generated\Shared\Transfer\TaskCriteriaTransfer;
use Generated\Shared\Transfer\TaskTransfer;

interface TaskRepositoryInterface
{
    /**
     * @param \Generated\Shared\Transfer\TaskTransfer $taskTransfer
     *
     * @return \Generated\Shared\Transfer\TaskTransfer|null
     */
    public function findTaskById(TaskTransfer $taskTransfer): ?TaskTransfer;

    /**
     * @param \Generated\Shared\Transfer\TaskCriteriaTransfer $taskCriteriaTransfer
     *
     * @return array<\Generated\Shared\Transfer\TaskTransfer>
     */
    public function findTaskCollection(TaskCriteriaTransfer $taskCriteriaTransfer): array;
}
