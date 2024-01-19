<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Glue\TasksBackendApi\Processor\Updater;

use Generated\Shared\Transfer\TaskResponseTransfer;
use Generated\Shared\Transfer\TaskTransfer;
use Pyz\Glue\TasksBackendApi\Processor\Validator\TaskValidatorInterface;
use Pyz\Zed\Task\Business\TaskFacadeInterface;

class TaskUpdater implements TaskUpdaterInterface
{
    private TaskValidatorInterface $taskValidator;

    private TaskFacadeInterface $taskFacade;

    /**
     * @param \Pyz\Glue\TasksBackendApi\Processor\Validator\TaskValidatorInterface $taskValidator
     * @param \Pyz\Zed\Task\Business\TaskFacadeInterface $taskFacade
     */
    public function __construct(
        TaskValidatorInterface $taskValidator,
        TaskFacadeInterface $taskFacade,
    ) {
        $this->taskValidator = $taskValidator;
        $this->taskFacade = $taskFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\TaskTransfer $taskTransfer
     *
     * @return \Generated\Shared\Transfer\TaskResponseTransfer
     */
    public function update(TaskTransfer $taskTransfer): TaskResponseTransfer
    {
        $taskValidatorResponse = $this->taskValidator->validate($taskTransfer);

        if (!$taskValidatorResponse->getIsSuccess()) {
            return (new TaskResponseTransfer())->fromArray($taskValidatorResponse->toArray());
        }

        return $this->taskFacade->updateTask($taskTransfer);
    }
}
