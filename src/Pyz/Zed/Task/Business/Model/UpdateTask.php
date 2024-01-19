<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Task\Business\Model;

use Exception;
use Generated\Shared\Transfer\TaskResponseTransfer;
use Generated\Shared\Transfer\TaskTransfer;
use Pyz\Zed\Task\Persistence\TaskEntityManagerInterface;
use Spryker\Zed\Kernel\Persistence\EntityManager\TransactionTrait;

class UpdateTask
{
    use TransactionTrait;

    private TaskEntityManagerInterface $entityManager;

    /**
     * @param \Pyz\Zed\Task\Persistence\TaskEntityManagerInterface $entityManager
     */
    public function __construct(TaskEntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param \Generated\Shared\Transfer\TaskTransfer $taskTransfer
     *
     * @return \Generated\Shared\Transfer\TaskResponseTransfer
     */
    public function update(TaskTransfer $taskTransfer): TaskResponseTransfer
    {
        $taskResponseTransfer = (new TaskResponseTransfer())->setIsSuccess(true);

        try {
            $taskTransfer = $this->getTransactionHandler()->handleTransaction(function () use ($taskTransfer) {
                return $this->entityManager->saveTask($taskTransfer);
            });
        } catch (Exception $exception) {
            return $taskResponseTransfer
                ->setIsSuccess(false)
                ->addError($exception->getMessage());
        }

        return $taskResponseTransfer
            ->setTask($taskTransfer)
            ->setMessage('Task was updated successfully.');
    }
}
