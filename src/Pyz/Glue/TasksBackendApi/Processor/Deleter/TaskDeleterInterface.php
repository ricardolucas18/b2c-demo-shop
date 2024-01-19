<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Glue\TasksBackendApi\Processor\Deleter;

use Generated\Shared\Transfer\TaskResponseTransfer;
use Generated\Shared\Transfer\TaskTransfer;

interface TaskDeleterInterface
{
 /**
  * @param \Generated\Shared\Transfer\TaskTransfer $taskTransfer
  *
  * @return \Generated\Shared\Transfer\TaskResponseTransfer
  */
    public function delete(TaskTransfer $taskTransfer): TaskResponseTransfer;
}
