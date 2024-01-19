<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Task\Business\Model;

use ArrayObject;
use Exception;
use Generated\Shared\Transfer\TaskCollectionResponseTransfer;
use Generated\Shared\Transfer\TaskCriteriaTransfer;
use Generated\Shared\Transfer\TaskResponseTransfer;
use Generated\Shared\Transfer\TaskTransfer;
use Pyz\Zed\Task\Persistence\TaskRepositoryInterface;

class ReadTask
{
    private TaskRepositoryInterface $taskRepository;

    /**
     * @param \Pyz\Zed\Task\Persistence\TaskRepositoryInterface $taskRepository
     */
    public function __construct(TaskRepositoryInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    /**
     * @param \Generated\Shared\Transfer\TaskTransfer $taskTransfer
     *
     * @return \Generated\Shared\Transfer\TaskResponseTransfer
     */
    public function find(TaskTransfer $taskTransfer): TaskResponseTransfer
    {
        $taskResponseTransfer = (new TaskResponseTransfer())->setIsSuccess(true);

        try {
            $taskTransfer = $this->taskRepository->findTaskById($taskTransfer);
        } catch (Exception $exception) {
            return $taskResponseTransfer
                ->setIsSuccess(false)
                ->addError($exception->getMessage());
        }

        return $taskResponseTransfer
            ->setTask($taskTransfer)
            ->setMessage('Task was found successfully.');
    }

    /**
     * @param \Generated\Shared\Transfer\TaskCriteriaTransfer $taskCriteriaTransfer
     *
     * @return \Generated\Shared\Transfer\TaskCollectionResponseTransfer
     */
    public function findTaskCollection(TaskCriteriaTransfer $taskCriteriaTransfer): TaskCollectionResponseTransfer
    {
        $taskTransfers = $this->taskRepository->findTaskCollection($taskCriteriaTransfer);

        return (new TaskCollectionResponseTransfer())->setTasks(new ArrayObject($taskTransfers));
    }
}
