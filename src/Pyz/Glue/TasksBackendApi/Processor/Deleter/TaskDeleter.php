<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Glue\TasksBackendApi\Processor\Deleter;

use Generated\Shared\Transfer\TaskResponseTransfer;
use Generated\Shared\Transfer\TaskTransfer;
use Pyz\Zed\Task\Business\TaskFacadeInterface;

class TaskDeleter implements TaskDeleterInterface
{
    private TaskFacadeInterface $taskFacade;

    /**
     * @param \Pyz\Zed\Task\Business\TaskFacadeInterface $taskFacade
     */
    public function __construct(TaskFacadeInterface $taskFacade)
    {
        $this->taskFacade = $taskFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\TaskTransfer $taskTransfer
     *
     * @return \Generated\Shared\Transfer\TaskResponseTransfer
     */
    public function delete(TaskTransfer $taskTransfer): TaskResponseTransfer
    {
        return $this->taskFacade->deleteTask($taskTransfer);
    }
}
