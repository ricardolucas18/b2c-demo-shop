<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Task\Persistence\Exception;

use Exception;

class TaskNotFoundException extends Exception
{
    public function __construct()
    {
        parent::__construct('Task not found.', 404);
    }
}
