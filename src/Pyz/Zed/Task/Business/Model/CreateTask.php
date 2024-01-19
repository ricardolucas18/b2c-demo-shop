<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Task\Business\Model;

use Exception;
use Generated\Shared\Transfer\TaskResponseTransfer;
use Generated\Shared\Transfer\TaskTransfer;
use Generated\Shared\Transfer\UserConditionsTransfer;
use Generated\Shared\Transfer\UserCriteriaTransfer;
use Generated\Shared\Transfer\UserTransfer;
use Pyz\Shared\Task\TaskConstants;
use Pyz\Zed\Task\Business\Mailer\TaskMailerInterface;
use Pyz\Zed\Task\Persistence\TaskEntityManagerInterface;
use Spryker\Zed\Kernel\Persistence\EntityManager\TransactionTrait;
use Spryker\Zed\User\Business\UserFacadeInterface;

class CreateTask
{
    use TransactionTrait;

    /**
     * @var \Pyz\Zed\Task\Persistence\TaskEntityManagerInterface
     */
    private TaskEntityManagerInterface $entityManager;

    /**
     * @var \Spryker\Zed\User\Business\UserFacadeInterface
     */
    private UserFacadeInterface $userFacade;

    /**
     * @var \Pyz\Zed\Task\Business\Mailer\TaskMailerInterface
     */
    private TaskMailerInterface $taskMailer;

    /**
     * @param \Pyz\Zed\Task\Persistence\TaskEntityManagerInterface $entityManager
     * @param \Spryker\Zed\User\Business\UserFacadeInterface $userFacade
     * @param \Pyz\Zed\Task\Business\Mailer\TaskMailerInterface $taskMailer
     */
    public function __construct(
        TaskEntityManagerInterface $entityManager,
        UserFacadeInterface $userFacade,
        TaskMailerInterface $taskMailer,
    ) {
        $this->entityManager = $entityManager;
        $this->userFacade = $userFacade;
        $this->taskMailer = $taskMailer;
    }

    /**
     * @param \Generated\Shared\Transfer\TaskTransfer $taskTransfer
     *
     * @return \Generated\Shared\Transfer\TaskResponseTransfer
     */
    public function create(TaskTransfer $taskTransfer): TaskResponseTransfer
    {
        $taskResponseTransfer = (new TaskResponseTransfer())->setIsSuccess(true);

        $userTransfer = null;

        if (!empty($taskTransfer->getUserUuid())) {
            $userTransfer = $this->getUserTransfer($taskTransfer->getUserUuid());

            if ($userTransfer === null) {
                return $taskResponseTransfer
                    ->setIsSuccess(false)
                    ->setMessage('The user with Uuid provided was not found.');
            }
        }

        try {
            $taskTransfer = $this->getTransactionHandler()->handleTransaction(function () use ($taskTransfer) {
                return $this->entityManager->saveTask($taskTransfer);
            });
        } catch (Exception $exception) {
            return $taskResponseTransfer
                ->setIsSuccess(false)
                ->addError($exception->getMessage());
        }

        if ($userTransfer !== null && $taskTransfer->getStatus() === TaskConstants::OVERDUE_STATUS) {
            $this->taskMailer->sendMail($taskTransfer, $userTransfer);
        }

        return $taskResponseTransfer
            ->setTask($taskTransfer)
            ->setMessage('Task was created successfully.');
    }

    /**
     * @param string $userUuid
     *
     * @return \Generated\Shared\Transfer\UserTransfer|null
     */
    private function getUserTransfer(string $userUuid): ?UserTransfer
    {
        $userConditionsTransfer = (new UserConditionsTransfer())->addUuid($userUuid);

        $userCollectionTransfer = $this->userFacade->getUserCollection((new UserCriteriaTransfer())->setUserConditions($userConditionsTransfer));

        if (!$userCollectionTransfer->getUsers()->getArrayCopy()) {
            return null;
        }

        return $userCollectionTransfer->getUsers()->getArrayCopy()[0];
    }
}
