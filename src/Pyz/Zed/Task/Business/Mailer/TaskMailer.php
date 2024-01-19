<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Task\Business\Mailer;

use Generated\Shared\Transfer\MailRecipientTransfer;
use Generated\Shared\Transfer\MailTransfer;
use Generated\Shared\Transfer\TaskTransfer;
use Generated\Shared\Transfer\UserTransfer;
use Pyz\Zed\Task\Communication\Plugin\Mail\TaskStatusNotificationMailTypePlugin;
use Spryker\Zed\Mail\Business\MailFacadeInterface;

class TaskMailer implements TaskMailerInterface
{
    private MailFacadeInterface $mailFacade;

    /**
     * @param \Spryker\Zed\Mail\Business\MailFacadeInterface $mailFacade
     */
    public function __construct(MailFacadeInterface $mailFacade)
    {
        $this->mailFacade = $mailFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\TaskTransfer $taskTransfer
     * @param \Generated\Shared\Transfer\UserTransfer $userTransfer
     *
     * @return void
     */
    public function sendMail(
        TaskTransfer $taskTransfer,
        UserTransfer $userTransfer,
    ): void {
        $recipientTransfer = (new MailRecipientTransfer())
            ->setName(sprintf('%s %s', $userTransfer->getFirstName(), $userTransfer->getLastName()))
            ->setEmail($userTransfer->getUsername());

        $mailTransfer = (new MailTransfer())
            ->setType(TaskStatusNotificationMailTypePlugin::MAIL_TYPE)
            ->addRecipient($recipientTransfer)
            ->setTask($taskTransfer);

        $this->mailFacade->handleMail($mailTransfer);
    }
}
