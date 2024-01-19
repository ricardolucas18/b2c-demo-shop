<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Task\Communication\Controller;

use Generated\Shared\Transfer\TaskTransfer;
use Spryker\Zed\Kernel\Communication\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

/**
 * @method \Pyz\Zed\Task\Persistence\TaskQueryContainerInterface getQueryContainer()
 * @method \Pyz\Zed\Task\Persistence\TaskRepositoryInterface getRepository()
 * @method \Pyz\Zed\Task\Business\TaskFacadeInterface getFacade()
 * @method \Pyz\Zed\Task\Communication\TaskCommunicationFactory getFactory()
 */
class EditController extends AbstractController
{
    /**
     * @var string
     */
    public const PARAM_ID_TASK = 'id-task';

    /**
     * @var string
     */
    public const TASK_LISTING_URL = '/task';

    /**
     * @var string
     */
    public const MESSAGE_ID_TASK_EXTRACT_ERROR = 'Missing task id!';

    /**
     * @var string
     */
    protected const MESSAGE_TASK_NOT_FOUND = "Task couldn't be found";

    /**
     * @var string
     */
    public const MESSAGE_TASK_DELETE_SUCCESS = 'Task was deleted successfully.';

    /**
     * @var string
     */
    public const MESSAGE_CSRF_FORM_PROTECTION_ERROR = 'CSRF token is not valid!';

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|array<mixed>
     */
    public function confirmDeleteAction(Request $request): RedirectResponse|array
    {
        $idUser = $this->castId($request->query->get(static::PARAM_ID_TASK));

        if (!$idUser) {
            $this->addErrorMessage(static::MESSAGE_ID_TASK_EXTRACT_ERROR);

            return $this->redirectResponse(static::TASK_LISTING_URL);
        }

        $taskTransfer = $this->findTaskTransfer($idUser);
        if (!$taskTransfer) {
            $this->addErrorMessage(static::MESSAGE_TASK_NOT_FOUND);

            return $this->redirectResponse(static::TASK_LISTING_URL);
        }

        $taskDeleteConfirmForm = $this->getFactory()->getTaskDeleteConfirmForm();

        return $this->viewResponse([
            'taskDeleteConfirmForm' => $taskDeleteConfirmForm->createView(),
            'task' => $taskTransfer,
        ]);
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @throws \Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request): RedirectResponse
    {
        if (!$request->isMethod(Request::METHOD_DELETE)) {
            throw new MethodNotAllowedHttpException([Request::METHOD_DELETE], 'This action requires a DELETE request.');
        }

        $taskDeleteConfirmForm = $this->getFactory()->getTaskDeleteConfirmForm()->handleRequest($request);

        if (!$taskDeleteConfirmForm->isSubmitted() || !$taskDeleteConfirmForm->isValid()) {
            $this->addErrorMessage(static::MESSAGE_CSRF_FORM_PROTECTION_ERROR);

            return $this->redirectResponse(static::TASK_LISTING_URL);
        }

        $idTask = $this->castId($request->request->get(static::PARAM_ID_TASK));

        if (!$idTask) {
            $this->addErrorMessage(static::MESSAGE_ID_TASK_EXTRACT_ERROR);

            return $this->redirectResponse(static::TASK_LISTING_URL);
        }

        $this->getFacade()->deleteTask((new TaskTransfer())->setIdTask($idTask));

        $this->addSuccessMessage(static::MESSAGE_TASK_DELETE_SUCCESS);

        return $this->redirectResponse(static::TASK_LISTING_URL);
    }

    /**
     * @param int $idtask
     *
     * @return \Generated\Shared\Transfer\TaskTransfer|null
     */
    protected function findTaskTransfer(int $idtask): ?TaskTransfer
    {
        $taskResponseTransfer = $this->getFacade()->findTask((new TaskTransfer())->setIdTask($idtask));

        return $taskResponseTransfer->getTask();
    }
}
