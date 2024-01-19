<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Task\Persistence;

use Orm\Zed\Task\Persistence\PyzTaskQuery;
use Pyz\Zed\Task\Persistence\Mapper\TaskEntityTransferMapper;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

/**
 * @method \Pyz\Zed\Task\Persistence\TaskEntityManagerInterface getEntityManager()
 * @method \Pyz\Zed\Task\Persistence\TaskRepositoryInterface getRepository()
 * @method \Pyz\Zed\Task\TaskConfig getConfig()
 */
class TaskPersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \Pyz\Zed\Task\Persistence\Mapper\TaskEntityTransferMapper
     */
    public function createTaskEntityTransferMapper(): TaskEntityTransferMapper
    {
        return new TaskEntityTransferMapper();
    }

    /**
     * @return \Orm\Zed\Task\Persistence\PyzTaskQuery
     */
    public function createTaskQuery(): PyzTaskQuery
    {
        return PyzTaskQuery::create();
    }
}
