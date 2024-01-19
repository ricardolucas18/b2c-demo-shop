<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Task\Business;

use Pyz\Zed\Task\Business\Mailer\TaskMailer;
use Pyz\Zed\Task\Business\Mailer\TaskMailerInterface;
use Pyz\Zed\Task\Business\Model\CreateTask;
use Pyz\Zed\Task\Business\Model\DeleteTask;
use Pyz\Zed\Task\Business\Model\ReadTask;
use Pyz\Zed\Task\Business\Model\UpdateTask;
use Pyz\Zed\Task\TaskDependencyProvider;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;
use Spryker\Zed\Mail\Business\MailFacadeInterface;
use Spryker\Zed\User\Business\UserFacadeInterface;

/**
 * @method \Pyz\Zed\Task\Persistence\TaskEntityManagerInterface getEntityManager()
 * @method \Pyz\Zed\Task\Persistence\TaskRepositoryInterface getRepository()
 * @method \Pyz\Zed\Task\TaskConfig getConfig()
 * @method \Pyz\Zed\Task\Persistence\TaskQueryContainerInterface getQueryContainer()
 */
class TaskBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \Pyz\Zed\Task\Business\Model\CreateTask
     */
    public function createCreateTask(): CreateTask
    {
        return new CreateTask(
            $this->getEntityManager(),
            $this->getUserFacade(),
            $this->createTaskMailer(),
        );
    }

    /**
     * @return \Pyz\Zed\Task\Business\Model\ReadTask
     */
    public function createFindTask(): ReadTask
    {
        return new ReadTask(
            $this->getRepository(),
        );
    }

    /**
     * @return \Pyz\Zed\Task\Business\Model\UpdateTask
     */
    public function createUpdateTask(): UpdateTask
    {
        return new UpdateTask(
            $this->getEntityManager(),
        );
    }

    /**
     * @return \Pyz\Zed\Task\Business\Model\DeleteTask
     */
    public function createDeleteTask(): DeleteTask
    {
        return new DeleteTask(
            $this->getEntityManager(),
        );
    }

    /**
     * @return \Pyz\Zed\Task\Business\Mailer\TaskMailerInterface
     */
    public function createTaskMailer(): TaskMailerInterface
    {
        return new TaskMailer(
            $this->getMailFacade(),
        );
    }

    /**
     * @return \Spryker\Zed\User\Business\UserFacadeInterface
     */
    private function getUserFacade(): UserFacadeInterface
    {
        return $this->getProvidedDependency(TaskDependencyProvider::FACADE_USER);
    }

    /**
     * @return \Spryker\Zed\Mail\Business\MailFacadeInterface
     */
    private function getMailFacade(): MailFacadeInterface
    {
        return $this->getProvidedDependency(TaskDependencyProvider::FACADE_MAIL);
    }
}
