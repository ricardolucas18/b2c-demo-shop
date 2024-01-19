<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Task\Communication\Plugin\User;

use Generated\Shared\Transfer\TaskConditionsTransfer;
use Generated\Shared\Transfer\TaskCriteriaTransfer;
use Generated\Shared\Transfer\UserTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\UserExtension\Dependency\Plugin\UserTransferExpanderPluginInterface;

/**
 * @method \Pyz\Zed\Task\TaskConfig getConfig()
 * @method \Pyz\Zed\Task\Persistence\TaskQueryContainerInterface getQueryContainer()
 * @method \Pyz\Zed\Task\Business\TaskFacadeInterface getFacade()
 * @method \Pyz\Zed\Task\Communication\TaskCommunicationFactory getFactory()
 */
class UserTaskTransferExpanderPlugin extends AbstractPlugin implements UserTransferExpanderPluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\UserTransfer $userTransfer
     *
     * @return \Generated\Shared\Transfer\UserTransfer
     */
    public function expandUserTransfer(UserTransfer $userTransfer): UserTransfer
    {
        $taskConditionsTransfer = (new TaskConditionsTransfer())->setUserUuid($userTransfer->getUuid());
        $taskCriteriaTransfer = (new TaskCriteriaTransfer())->setTaskConditions($taskConditionsTransfer);

        $taskCollection = $this->getFacade()->findTaskCollection($taskCriteriaTransfer);

        $userTransfer->setTasks($taskCollection->getTasks());

        return $userTransfer;
    }
}
