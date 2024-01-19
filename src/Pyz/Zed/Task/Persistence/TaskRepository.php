<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Task\Persistence;

use Generated\Shared\Transfer\TaskCriteriaTransfer;
use Generated\Shared\Transfer\TaskTransfer;
use Pyz\Zed\Task\Persistence\Exception\TaskNotFoundException;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @method \Pyz\Zed\Task\Persistence\TaskPersistenceFactory getFactory()
 */
class TaskRepository extends AbstractRepository implements TaskRepositoryInterface
{
    /**
     * @param \Generated\Shared\Transfer\TaskTransfer $taskTransfer
     *
     * @throws \Pyz\Zed\Task\Persistence\Exception\TaskNotFoundException
     *
     * @return \Generated\Shared\Transfer\TaskTransfer|null
     */
    public function findTaskById(TaskTransfer $taskTransfer): ?TaskTransfer
    {
        $taskEntityTransfer = $this
            ->getFactory()
            ->createTaskQuery()
            ->findOneByIdTask($taskTransfer->getIdTask());

        if ($taskEntityTransfer === null) {
            throw new TaskNotFoundException();
        }

        return (new TaskTransfer())->fromArray($taskEntityTransfer->toArray(), true);
    }

    /**
     * @param \Generated\Shared\Transfer\TaskCriteriaTransfer $taskCriteriaTransfer
     *
     * @return array<\Generated\Shared\Transfer\TaskTransfer>
     */
    public function findTaskCollection(TaskCriteriaTransfer $taskCriteriaTransfer): array
    {
        $taskQuery = $this
            ->getFactory()
            ->createTaskQuery();

        $taskConditionsTransfer = $taskCriteriaTransfer->getTaskConditions();
        $paginationTransfer = $taskCriteriaTransfer->getPagination();

        if ($taskConditionsTransfer && $taskConditionsTransfer->getUserUuid() !== null) {
            $taskQuery->filterByUserUuid($taskConditionsTransfer->getUserUuid());
        }

        if ($taskConditionsTransfer && $taskConditionsTransfer->getTitle() !== null) {
            $taskQuery->filterByTitle($taskConditionsTransfer->getTitle());
        }

        if ($taskConditionsTransfer && $taskConditionsTransfer->getDescription() !== null) {
            $taskQuery->filterByDescription($taskConditionsTransfer->getDescription());
        }

        if ($paginationTransfer && $paginationTransfer->getOffset() !== null) {
            $taskQuery->setOffset($paginationTransfer->getOffset());
        }

        if ($paginationTransfer && $paginationTransfer->getLimit() !== null) {
            $taskQuery->setLimit($paginationTransfer->getLimit());
        }

        $taskEntityTransfers = $taskQuery->find();

        $taskTransfers = [];

        foreach ($taskEntityTransfers as $taskEntityTransfer) {
            $taskTransfer = (new TaskTransfer())->fromArray($taskEntityTransfer->toArray(), true);

            $taskTransfers[] = $taskTransfer;
        }

        return $taskTransfers;
    }
}
