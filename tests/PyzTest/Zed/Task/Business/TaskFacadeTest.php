<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Zed\Task\Business;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\MailRecipientTransfer;
use Generated\Shared\Transfer\MailTransfer;
use Generated\Shared\Transfer\TaskTransfer;
use Orm\Zed\Task\Persistence\PyzTaskQuery;
use Pyz\Zed\Task\Business\TaskFacade;
use Pyz\Zed\Task\Communication\Plugin\Mail\TaskStatusNotificationMailTypePlugin;
use Pyz\Zed\Task\TaskDependencyProvider;
use PyzTest\Zed\Task\TaskBusinessTester;
use Spryker\Zed\Mail\Business\MailFacadeInterface;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Zed
 * @group Task
 * @group Business
 * @group Facade
 * @group TaskFacadeTest
 * Add your own group annotations below this line
 */
class TaskFacadeTest extends Unit
{
    protected TaskBusinessTester $tester;

    /**
     * @return void
     */
    public function testCanCreateTask(): void
    {
        // Arrange
        $taskTransfer = $this->buildTaskTransfer();

        // Act
        $taskTransferResult = $this->getFacade()->createTask($taskTransfer);

        // Assert
        $foundTask = PyzTaskQuery::create()->findOneByTitle('Test Task Title');
        $this->assertNotNull($foundTask);
        $this->assertSame('Test Task Title', $foundTask->getTitle());
        $this->assertSame('Test Task Description', $foundTask->getDescription());
        $this->assertSame('30.01.2024', $foundTask->getDueDate());
        $this->assertSame('To Do', $foundTask->getStatus());
        $this->assertTrue($taskTransferResult->getIsSuccess());
        $this->assertSame('Task was created successfully.', $taskTransferResult->getMessage());
        $this->assertSame($taskTransferResult->getTask()->getIdTask(), $foundTask->getIdTask());
    }

    /**
     * @return void
     */
    public function testCanNotCreateTaskWithUserUuidThatDoNotExist(): void
    {
        // Arrange
        $taskTransfer = (new TaskTransfer())
            ->setTitle('Test Task Title')
            ->setDescription('Test Task Description')
            ->setUserUuid('test-uuid')
            ->setDueDate('30.01.2024')
            ->setStatus('To Do');

        // Act
        $taskTransferResult = $this->getFacade()->createTask($taskTransfer);

        // Assert
        $taskTransfer = PyzTaskQuery::create()->findOneByTitle('Test Task Title');
        $this->assertNull($taskTransfer);
        $this->assertFalse($taskTransferResult->getIsSuccess());
        $this->assertSame('The user with Uuid provided was not found.', $taskTransferResult->getMessage());
    }

    /**
     * @return void
     */
    public function testCanCreateOverdueTaskAndSendsMail(): void
    {
        $userTransfer = $this->tester->haveUser();

        // Arrange
        $taskTransfer = (new TaskTransfer())
            ->setTitle('Test Task Title')
            ->setUserUuid($userTransfer->getUuid())
            ->setDescription('Test Task Description')
            ->setDueDate('30.01.2024')
            ->setStatus('Overdue');

        $mailFacadeMock = $this->createMock(MailFacadeInterface::class);

        $expectedRecipientTransfer = (new MailRecipientTransfer())
            ->setName(sprintf('%s %s', $userTransfer->getFirstName(), $userTransfer->getLastName()))
            ->setEmail($userTransfer->getUsername());

        $expectedMailTransferParam = (new MailTransfer())
            ->setTask($taskTransfer)
            ->setType(TaskStatusNotificationMailTypePlugin::MAIL_TYPE)
            ->addRecipient($expectedRecipientTransfer);

        $mailFacadeMock->expects($this->once())
            ->method('handleMail')
            ->with($expectedMailTransferParam)
            ->willReturn(new MailTransfer());

        $this->tester->setDependency(
            TaskDependencyProvider::FACADE_MAIL,
            $mailFacadeMock,
        );

        // Act
        $taskTransferResult = $this->getFacade()->createTask($taskTransfer);

        // Assert
        $foundTask = PyzTaskQuery::create()->findOneByTitle('Test Task Title');
        $this->assertNotNull($foundTask);
        $this->assertSame('Test Task Title', $foundTask->getTitle());
        $this->assertSame('Test Task Description', $foundTask->getDescription());
        $this->assertSame('30.01.2024', $foundTask->getDueDate());
        $this->assertSame('Overdue', $foundTask->getStatus());
        $this->assertTrue($taskTransferResult->getIsSuccess());
        $this->assertSame('Task was created successfully.', $taskTransferResult->getMessage());
        $this->assertSame($taskTransferResult->getTask()->getIdTask(), $foundTask->getIdTask());
    }

    /**
     * @return void
     */
    public function testCanFindTask(): void
    {
        // Arrange
        $taskTransfer = $this->buildTaskTransfer();

        $createTaskResponseTransfer = $this->getFacade()->createTask($taskTransfer);

        // Act
        $findTaskTransferResult = $this->getFacade()->findTask((new TaskTransfer())
            ->setIdTask($createTaskResponseTransfer->getTask()->getIdTask()));

        // Assert
        $foundTask = $findTaskTransferResult->getTask();
        $this->assertNotNull($foundTask);
        $this->assertSame('Test Task Title', $foundTask->getTitle());
        $this->assertSame('Test Task Description', $foundTask->getDescription());
        $this->assertSame('30.01.2024', $foundTask->getDueDate());
        $this->assertSame('To Do', $foundTask->getStatus());
        $this->assertTrue($findTaskTransferResult->getIsSuccess());
        $this->assertSame('Task was found successfully.', $findTaskTransferResult->getMessage());
        $this->assertSame($createTaskResponseTransfer->getTask()->getIdTask(), $foundTask->getIdTask());
    }

    /**
     * @return void
     */
    public function testCanUpdateTask(): void
    {
        // Arrange
        $oldTaskTransfer = $this->buildTaskTransfer();

        $createTaskResponseTransfer = $this->getFacade()->createTask($oldTaskTransfer);

        $updatedTask = $createTaskResponseTransfer->getTask()
            ->setTitle('Updated Task Title')
            ->setDescription('Updated Task Description')
            ->setStatus('In Progress');

        // Act
        $updateTaskTransferResult = $this->getFacade()->updateTask($updatedTask);

        // Assert
        $updatedTask = $updateTaskTransferResult->getTask();

        $this->assertNotNull($updatedTask);
        $this->assertSame('Updated Task Title', $updatedTask->getTitle());
        $this->assertSame('Updated Task Description', $updatedTask->getDescription());
        $this->assertSame('30.01.2024', $updatedTask->getDueDate());
        $this->assertSame('In Progress', $updatedTask->getStatus());
        $this->assertTrue($updateTaskTransferResult->getIsSuccess());
        $this->assertSame('Task was updated successfully.', $updateTaskTransferResult->getMessage());
        $this->assertSame($createTaskResponseTransfer->getTask()->getIdTask(), $updatedTask->getIdTask());
    }

    /**
     * @return void
     */
    public function testCanDeleteTask(): void
    {
        // Arrange
        $taskTransfer = $this->buildTaskTransfer();

        $createTaskResponseTransfer = $this->getFacade()->createTask($taskTransfer);

        // Act
        $deleteTaskTransferResult = $this->getFacade()->deleteTask(
            (new TaskTransfer())
                ->setIdTask($createTaskResponseTransfer->getTask()->getIdTask()),
        );

        // Assert
        $dataResponse = PyzTaskQuery::create()->findByIdTask($createTaskResponseTransfer->getTask()->getIdTask())->getData();

        $this->assertEmpty($dataResponse);
        $this->assertEmpty($deleteTaskTransferResult->getTask());
        $this->assertSame('Task was deleted successfully.', $deleteTaskTransferResult->getMessage());
    }

    /**
     * @return \Pyz\Zed\Task\Business\TaskFacade
     */
    private function getFacade(): TaskFacade
    {
        return $this->tester->getLocator()->task()->facade();
    }

    /**
     * @return \Generated\Shared\Transfer\TaskTransfer
     */
    private function buildTaskTransfer(): TaskTransfer
    {
        return (new TaskTransfer())
            ->setTitle('Test Task Title')
            ->setDescription('Test Task Description')
            ->setDueDate('30.01.2024')
            ->setStatus('To Do');
    }
}
