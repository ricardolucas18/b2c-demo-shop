<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Task\Communication\Plugin\Mail;

use Generated\Shared\Transfer\MailSenderTransfer;
use Generated\Shared\Transfer\MailTemplateTransfer;
use Generated\Shared\Transfer\MailTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\MailExtension\Dependency\Plugin\MailTypeBuilderPluginInterface;

/**
 * @method \Pyz\Zed\Task\TaskConfig getConfig()
 * @method \Pyz\Zed\Task\Business\TaskFacadeInterface getFacade()
 * @method \Pyz\Zed\Task\Communication\TaskCommunicationFactory getFactory()
 * @method \Pyz\Zed\Task\Persistence\TaskQueryContainerInterface getQueryContainer()
 */
class TaskStatusNotificationMailTypePlugin extends AbstractPlugin implements MailTypeBuilderPluginInterface
{
    /**
     * @var string
     */
    public const MAIL_TYPE = 'task status notification email';

    /**
     * @var string
     */
    public const DEFAULT_SUBJECT = 'Task status notification';

    /**
     * @var string
     */
    public const MAIL_TEMPLATE_TEXT = 'Task/mail/task_notification_body.text.twig';

    /**
     * @return string
     */
    public function getName(): string
    {
        return static::MAIL_TYPE;
    }

    /**
     * @param \Generated\Shared\Transfer\MailTransfer $mailTransfer
     *
     * @return \Generated\Shared\Transfer\MailTransfer
     */
    public function build(MailTransfer $mailTransfer): MailTransfer
    {
        return $mailTransfer
            ->setSubject(static::DEFAULT_SUBJECT)
            ->addTemplate(
                (new MailTemplateTransfer())
                    ->setName(static::MAIL_TEMPLATE_TEXT)
                    ->setIsHtml(false),
            )
            ->setSender((new MailSenderTransfer())->setEmail('company@mail.com'));
    }
}
