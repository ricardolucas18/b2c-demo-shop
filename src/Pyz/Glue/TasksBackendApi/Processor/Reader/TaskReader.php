<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Glue\TasksBackendApi\Processor\Reader;

use Generated\Shared\Transfer\TaskCollectionResponseTransfer;
use Generated\Shared\Transfer\TaskCriteriaTransfer;
use Generated\Shared\Transfer\TaskResponseTransfer;
use Generated\Shared\Transfer\TaskTransfer;
use Pyz\Zed\Task\Business\TaskFacadeInterface;

class TaskReader implements TaskReaderInterface
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
    public function find(TaskTransfer $taskTransfer): TaskResponseTransfer
    {
        return $this->taskFacade->findTask($taskTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\TaskCriteriaTransfer $taskCriteriaTransfer
     *
     * @return \Generated\Shared\Transfer\TaskCollectionResponseTransfer
     */
    public function findTaskCollection(TaskCriteriaTransfer $taskCriteriaTransfer): TaskCollectionResponseTransfer
    {
        return $this->taskFacade->findTaskCollection($taskCriteriaTransfer);
    }
}
