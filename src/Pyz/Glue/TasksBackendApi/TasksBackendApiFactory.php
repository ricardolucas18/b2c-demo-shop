<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Glue\TasksBackendApi;

use Pyz\Glue\TasksBackendApi\Processor\Creator\TaskCreator;
use Pyz\Glue\TasksBackendApi\Processor\Creator\TaskCreatorInterface;
use Pyz\Glue\TasksBackendApi\Processor\Deleter\TaskDeleter;
use Pyz\Glue\TasksBackendApi\Processor\Deleter\TaskDeleterInterface;
use Pyz\Glue\TasksBackendApi\Processor\Reader\TaskReader;
use Pyz\Glue\TasksBackendApi\Processor\Reader\TaskReaderInterface;
use Pyz\Glue\TasksBackendApi\Processor\Updater\TaskUpdater;
use Pyz\Glue\TasksBackendApi\Processor\Updater\TaskUpdaterInterface;
use Pyz\Glue\TasksBackendApi\Processor\Validator\TaskValidator;
use Pyz\Glue\TasksBackendApi\Processor\Validator\TaskValidatorInterface;
use Pyz\Zed\Task\Business\TaskFacadeInterface;
use Spryker\Glue\Kernel\Backend\AbstractBackendApiFactory;
use Spryker\Zed\User\Business\UserFacadeInterface;

class TasksBackendApiFactory extends AbstractBackendApiFactory
{
    /**
     * @return \Pyz\Glue\TasksBackendApi\Processor\Creator\TaskCreatorInterface
     */
    public function createTaskCreator(): TaskCreatorInterface
    {
        return new TaskCreator(
            $this->createTaskValidator(),
            $this->getTaskFacade(),
        );
    }

    /**
     * @return \Pyz\Glue\TasksBackendApi\Processor\Reader\TaskReaderInterface
     */
    public function createTaskReader(): TaskReaderInterface
    {
        return new TaskReader(
            $this->getTaskFacade(),
        );
    }

    /**
     * @return \Pyz\Glue\TasksBackendApi\Processor\Updater\TaskUpdaterInterface
     */
    public function createTaskUpdater(): TaskUpdaterInterface
    {
        return new TaskUpdater(
            $this->createTaskValidator(),
            $this->getTaskFacade(),
        );
    }

    /**
     * @return \Pyz\Glue\TasksBackendApi\Processor\Deleter\TaskDeleterInterface
     */
    public function createTaskDeleter(): TaskDeleterInterface
    {
        return new TaskDeleter(
            $this->getTaskFacade(),
        );
    }

    /**
     * @return \Pyz\Glue\TasksBackendApi\Processor\Validator\TaskValidatorInterface
     */
    private function createTaskValidator(): TaskValidatorInterface
    {
        return new TaskValidator(
            $this->getUserFacade(),
        );
    }

    /**
     * @return \Pyz\Zed\Task\Business\TaskFacadeInterface
     */
    private function getTaskFacade(): TaskFacadeInterface
    {
        return $this->getProvidedDependency(TasksBackendApiDependencyProvider::FACADE_TASK);
    }

    /**
     * @return \Spryker\Zed\User\Business\UserFacadeInterface
     */
    private function getUserFacade(): UserFacadeInterface
    {
        return $this->getProvidedDependency(TasksBackendApiDependencyProvider::FACADE_USER);
    }
}
