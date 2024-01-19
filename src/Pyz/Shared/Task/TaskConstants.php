<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Shared\Task;

class TaskConstants
{
    /**
     * @var string
     */
    public const TO_DO_STATUS = 'To Do';

    /**
     * @var string
     */
    public const IN_PROGRESS_STATUS = 'In Progress';

    /**
     * @var string
     */
    public const COMPLETED_STATUS = 'Completed';

    /**
     * @var string
     */
    public const OVERDUE_STATUS = 'Overdue';

    /**
     * @var array<string>
     */
    public const ACCEPTED_STATUS = [
        self::TO_DO_STATUS,
        self::IN_PROGRESS_STATUS,
        self::COMPLETED_STATUS,
        self::OVERDUE_STATUS,
    ];
}
