<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Task\Business\Mailer;

use Generated\Shared\Transfer\TaskTransfer;
use Generated\Shared\Transfer\UserTransfer;

interface TaskMailerInterface
{
    /**
     * @param \Generated\Shared\Transfer\TaskTransfer $taskTransfer
     * @param \Generated\Shared\Transfer\UserTransfer $userTransfer
     *
     * @return void
     */
    public function sendMail(
        TaskTransfer $taskTransfer,
        UserTransfer $userTransfer,
    ): void;
}
