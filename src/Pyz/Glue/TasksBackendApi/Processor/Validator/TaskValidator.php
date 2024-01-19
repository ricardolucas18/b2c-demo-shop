<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Glue\TasksBackendApi\Processor\Validator;

use Generated\Shared\Transfer\TaskTransfer;
use Generated\Shared\Transfer\TaskValidationResponseTransfer;
use Generated\Shared\Transfer\UserConditionsTransfer;
use Generated\Shared\Transfer\UserCriteriaTransfer;
use Pyz\Shared\Task\TaskConstants;
use Spryker\Zed\User\Business\UserFacadeInterface;

class TaskValidator implements TaskValidatorInterface
{
    private UserFacadeInterface $userFacade;

    /**
     * @param \Spryker\Zed\User\Business\UserFacadeInterface $userFacade
     */
    public function __construct(UserFacadeInterface $userFacade)
    {
        $this->userFacade = $userFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\TaskTransfer $taskTransfer
     *
     * @return \Generated\Shared\Transfer\TaskValidationResponseTransfer
     */
    public function validate(TaskTransfer $taskTransfer): TaskValidationResponseTransfer
    {
        $taskValidationResponseTransfer = (new TaskValidationResponseTransfer())->setIsSuccess(true);

        $taskValidationResponseTransfer = $this->validateUser($taskTransfer, $taskValidationResponseTransfer);
        $taskValidationResponseTransfer = $this->validateTitle($taskTransfer, $taskValidationResponseTransfer);
        $taskValidationResponseTransfer = $this->validateStatus($taskTransfer, $taskValidationResponseTransfer);
        $taskValidationResponseTransfer = $this->validateDueDate($taskTransfer, $taskValidationResponseTransfer);

        return $taskValidationResponseTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\TaskTransfer $taskTransfer
     * @param \Generated\Shared\Transfer\TaskValidationResponseTransfer $taskValidationResponseTransfer
     *
     * @return \Generated\Shared\Transfer\TaskValidationResponseTransfer
     */
    private function validateUser(
        TaskTransfer $taskTransfer,
        TaskValidationResponseTransfer $taskValidationResponseTransfer,
    ): TaskValidationResponseTransfer {
        if (!empty($taskTransfer->getUserUuid())) {
            $userConditionsTransfer = (new UserConditionsTransfer())->addUuid($taskTransfer->getUserUuid());

            $userCollectionTransfer = $this->userFacade->getUserCollection((new UserCriteriaTransfer())->setUserConditions($userConditionsTransfer));

            if (!$userCollectionTransfer->getUsers()->getArrayCopy()) {
                $taskValidationResponseTransfer
                    ->setIsSuccess(false)
                    ->addError('The user with Uuid provided was not found.');
            }
        }

        return $taskValidationResponseTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\TaskTransfer $taskTransfer
     * @param \Generated\Shared\Transfer\TaskValidationResponseTransfer $taskValidationResponseTransfer
     *
     * @return \Generated\Shared\Transfer\TaskValidationResponseTransfer
     */
    private function validateTitle(
        TaskTransfer $taskTransfer,
        TaskValidationResponseTransfer $taskValidationResponseTransfer,
    ): TaskValidationResponseTransfer {
        if (empty($taskTransfer->getTitle())) {
            $taskValidationResponseTransfer
                ->setIsSuccess(false)
                ->addError("the attribute 'title' can not be blank.");
        }

        return $taskValidationResponseTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\TaskTransfer $taskTransfer
     * @param \Generated\Shared\Transfer\TaskValidationResponseTransfer $taskValidationResponseTransfer
     *
     * @return \Generated\Shared\Transfer\TaskValidationResponseTransfer
     */
    private function validateStatus(
        TaskTransfer $taskTransfer,
        TaskValidationResponseTransfer $taskValidationResponseTransfer,
    ): TaskValidationResponseTransfer {
        if (empty($taskTransfer->getStatus())) {
            return $taskValidationResponseTransfer
                ->setIsSuccess(false)
                ->addError("the attribute 'status' can not be blank.");
        }

        if (!in_array($taskTransfer->getStatus(), TaskConstants::ACCEPTED_STATUS)) {
            $taskValidationResponseTransfer
                ->setIsSuccess(false)
                ->addError("the attribute 'status' has an invalid status. (Accepted status: 'To Do', 'In Progress', 'Completed', 'Overdue')");
        }

        return $taskValidationResponseTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\TaskTransfer $taskTransfer
     * @param \Generated\Shared\Transfer\TaskValidationResponseTransfer $taskValidationResponseTransfer
     *
     * @return \Generated\Shared\Transfer\TaskValidationResponseTransfer
     */
    private function validateDueDate(
        TaskTransfer $taskTransfer,
        TaskValidationResponseTransfer $taskValidationResponseTransfer,
    ): TaskValidationResponseTransfer {
        $datePattern = '/^(?:(?:31(\.)(?:0?[13578]|1[02]))\1|(?:(?:29|30)(\.)(?:0?[13-9]|1[0-2])\2))(?:(?:1[6-9]|[2-9]\d)?\d{2})$|^(?:29(\.)0?2\3(?:(?:(?:1[6-9]|[2-9]\d)?(?:0[48]|[2468][048]|[13579][26])|(?:(?:16|[2468][048]|[3579][26])00))))$|^(?:0?[1-9]|1\d|2[0-8])(\.)(?:(?:0?[1-9])|(?:1[0-2]))\4(?:(?:1[6-9]|[2-9]\d)?\d{4})$/';

        if (!empty($taskTransfer->getDueDate()) && !preg_match($datePattern, $taskTransfer->getDueDate())) {
            $taskValidationResponseTransfer
                ->setIsSuccess(false)
                ->addError("the attribute 'dateDue' has an invalid date. (e.g: 'dd.mm.yyyy')");
        }

        return $taskValidationResponseTransfer;
    }
}
