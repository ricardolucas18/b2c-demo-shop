<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Glue\TasksBackendApi\Controller;

use Generated\Shared\Transfer\GlueRequestTransfer;
use Generated\Shared\Transfer\GlueResponseTransfer;
use Generated\Shared\Transfer\PaginationTransfer;
use Generated\Shared\Transfer\TaskConditionsTransfer;
use Generated\Shared\Transfer\TaskCriteriaTransfer;
use Generated\Shared\Transfer\TaskResponseTransfer;
use Generated\Shared\Transfer\TaskTransfer;
use Spryker\Glue\Kernel\Backend\Controller\AbstractBackendApiController;
use Symfony\Component\HttpFoundation\Response;

/**
 * @method \Pyz\Glue\TasksBackendApi\TasksBackendApiFactory getFactory()
 */
class TasksController extends AbstractBackendApiController
{
    /**
     * @var string
     */
    protected const PARAM_DATA = 'data';

    /**
     * @var string
     */
    protected const PARAM_PARAMS = 'params';

    /**
     * @var string
     */
    protected const PARAM_TITLE = 'title';

    /**
     * @var string
     */
    protected const PARAM_DESCRIPTION = 'description';

    /**
     * @var string
     */
    protected const PARAM_UUID_USER = 'userUuid';

    /**
     * @var string
     */
    protected const PARAM_PAGINATION = 'pagination';

    /**
     * @var string
     */
    protected const MESSAGE_REQUEST_INVALID = 'Request was invalid.';

    /**
     * @param \Generated\Shared\Transfer\GlueRequestTransfer $glueRequestTransfer
     *
     * @return \Generated\Shared\Transfer\GlueResponseTransfer
     */
    public function createAction(GlueRequestTransfer $glueRequestTransfer): GlueResponseTransfer
    {
        $data = $glueRequestTransfer->getAttributes()[static::PARAM_DATA];

        $taskTransfer = (new TaskTransfer())->fromArray($data);

        $taskResponseTransfer = $this->getFactory()->createTaskCreator()->create($taskTransfer);

        if (!$taskResponseTransfer->getIsSuccess()) {
            $taskResponseTransfer->setMessage(static::MESSAGE_REQUEST_INVALID);

            return $this->buildFailedGlueResponseTransfer($taskResponseTransfer);
        }

        return $this->buildSuccessGlueResponseTransfer($taskResponseTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\GlueRequestTransfer $glueRequestTransfer
     *
     * @return \Generated\Shared\Transfer\GlueResponseTransfer
     */
    public function findAction(GlueRequestTransfer $glueRequestTransfer): GlueResponseTransfer
    {
        $taskTransfer = (new TaskTransfer())->setIdTask((int)$glueRequestTransfer->getResource()->getId());

        $taskResponseTransfer = $this->getFactory()->createTaskReader()->find($taskTransfer);

        if (!$taskResponseTransfer->getIsSuccess()) {
            return $this->buildFailedGlueResponseTransfer($taskResponseTransfer);
        }

        return $this->buildSuccessGlueResponseTransfer($taskResponseTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\GlueRequestTransfer $glueRequestTransfer
     *
     * @return \Generated\Shared\Transfer\GlueResponseTransfer
     */
    public function findCollectionAction(GlueRequestTransfer $glueRequestTransfer): GlueResponseTransfer
    {
        $taskCriteriaTransfer = new TaskCriteriaTransfer();

        if (isset($glueRequestTransfer->getAttributes()[static::PARAM_PARAMS])) {
            $data = $glueRequestTransfer->getAttributes()[static::PARAM_PARAMS];

            $taskCriteriaTransfer = $this->buildTaskCriteriaTransfer($data);
        }

        $tasksCollectionResponseTransfer = $this->getFactory()->createTaskReader()->findTaskCollection($taskCriteriaTransfer);

        return (new GlueResponseTransfer())
            ->setHttpStatus(Response::HTTP_OK)
            ->setContent(json_encode($tasksCollectionResponseTransfer->toArray()['tasks']))
            ->setFormat('json-api');
    }

    /**
     * @param \Generated\Shared\Transfer\GlueRequestTransfer $glueRequestTransfer
     *
     * @return \Generated\Shared\Transfer\GlueResponseTransfer
     */
    public function updateAction(GlueRequestTransfer $glueRequestTransfer): GlueResponseTransfer
    {
        $data = $glueRequestTransfer->getAttributes()[static::PARAM_DATA];

        $taskTransfer = (new TaskTransfer())->fromArray($data);

        $taskTransfer->setIdTask((int)$glueRequestTransfer->getResource()->getId());

        $taskResponseTransfer = $this->getFactory()->createTaskUpdater()->update($taskTransfer);

        if (!$taskResponseTransfer->getIsSuccess()) {
            return $this->buildFailedGlueResponseTransfer($taskResponseTransfer);
        }

        return $this->buildSuccessGlueResponseTransfer($taskResponseTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\GlueRequestTransfer $glueRequestTransfer
     *
     * @return \Generated\Shared\Transfer\GlueResponseTransfer
     */
    public function deleteAction(GlueRequestTransfer $glueRequestTransfer): GlueResponseTransfer
    {
        $taskTransfer = (new TaskTransfer())->setIdTask((int)$glueRequestTransfer->getResource()->getId());

        $taskResponseTransfer = $this->getFactory()->createTaskDeleter()->delete($taskTransfer);

        if (!$taskResponseTransfer->getIsSuccess()) {
            return $this->buildFailedGlueResponseTransfer($taskResponseTransfer);
        }

        return $this->buildSuccessGlueResponseTransfer($taskResponseTransfer);
    }

    /**
     * @param array<string, mixed> $data
     *
     * @return \Generated\Shared\Transfer\TaskCriteriaTransfer
     */
    private function buildTaskCriteriaTransfer(array $data): TaskCriteriaTransfer
    {
        $taskConditionsTransfer = new TaskConditionsTransfer();
        $pagination = new PaginationTransfer();

        if (isset($data[static::PARAM_UUID_USER])) {
            $taskConditionsTransfer->setUserUuid($data[static::PARAM_UUID_USER]);
        }

        if (isset($data[static::PARAM_TITLE])) {
            $taskConditionsTransfer->setTitle($data[static::PARAM_TITLE]);
        }

        if (isset($data[static::PARAM_DESCRIPTION])) {
            $taskConditionsTransfer->setDescription($data[static::PARAM_DESCRIPTION]);
        }

        if (isset($data[static::PARAM_PAGINATION])) {
            $pagination->fromArray($data[static::PARAM_PAGINATION], true);
        }

        return (new TaskCriteriaTransfer())
            ->setTaskConditions($taskConditionsTransfer)
            ->setPagination($pagination);
    }

    /**
     * @param \Generated\Shared\Transfer\TaskResponseTransfer $taskResponseTransfer
     *
     * @return \Generated\Shared\Transfer\GlueResponseTransfer
     */
    private function buildSuccessGlueResponseTransfer(TaskResponseTransfer $taskResponseTransfer): GlueResponseTransfer
    {
        return (new GlueResponseTransfer())
            ->setHttpStatus(Response::HTTP_OK)
            ->setContent(json_encode($taskResponseTransfer->toArray()))
            ->setFormat('json-api');
    }

    /**
     * @param \Generated\Shared\Transfer\TaskResponseTransfer $taskResponseTransfer
     *
     * @return \Generated\Shared\Transfer\GlueResponseTransfer
     */
    private function buildFailedGlueResponseTransfer(TaskResponseTransfer $taskResponseTransfer): GlueResponseTransfer
    {
        return (new GlueResponseTransfer())
            ->setHttpStatus(Response::HTTP_BAD_REQUEST)
            ->setContent(json_encode($taskResponseTransfer->toArray()))
            ->setFormat('json-api');
    }
}
