<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Glue\TasksBackendApi\Processor\Validator;

use Generated\Shared\Transfer\TaskTransfer;
use Generated\Shared\Transfer\TaskValidationResponseTransfer;

interface TaskValidatorInterface
{
    /**
     * @param \Generated\Shared\Transfer\TaskTransfer $taskTransfer
     *
     * @return \Generated\Shared\Transfer\TaskValidationResponseTransfer
     */
    public function validate(TaskTransfer $taskTransfer): TaskValidationResponseTransfer;
}
