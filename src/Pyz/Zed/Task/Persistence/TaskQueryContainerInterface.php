<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Task\Persistence;

use Orm\Zed\Task\Persistence\PyzTaskQuery;

interface TaskQueryContainerInterface
{
    /**
     * @return \Orm\Zed\Task\Persistence\PyzTaskQuery
     */
    public function queryTasks(): PyzTaskQuery;
}
