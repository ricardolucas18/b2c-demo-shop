<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Task\Communication\Table;

use Orm\Zed\Task\Persistence\Map\PyzTaskTableMap;
use Pyz\Zed\Task\Persistence\TaskQueryContainerInterface;
use Spryker\Service\UtilText\Model\Url\Url;
use Spryker\Zed\Gui\Communication\Table\AbstractTable;
use Spryker\Zed\Gui\Communication\Table\TableConfiguration;

class TasksTable extends AbstractTable
{
    /**
     * @var string
     */
    private const ACTION = 'Action';

    /**
     * @var string
     */
    public const DELETE_TASK_URL = '/task/edit/confirm-delete';

    /**
     * @var string
     */
    private const PARAM_ID_TASK = 'id-task';

    private TaskQueryContainerInterface $taskQueryContainer;

    /**
     * @param \Pyz\Zed\Task\Persistence\TaskQueryContainerInterface $taskQueryContainer
     */
    public function __construct(
        TaskQueryContainerInterface $taskQueryContainer,
    ) {
        $this->taskQueryContainer = $taskQueryContainer;
    }

    /**
     * @param \Spryker\Zed\Gui\Communication\Table\TableConfiguration $config
     *
     * @return \Spryker\Zed\Gui\Communication\Table\TableConfiguration
     */
    protected function configure(TableConfiguration $config): TableConfiguration
    {
        $config->setHeader($this->getHeaders());

        $config->setSortable($this->getSortable());

        $config->setSearchable($this->getSearchable());

        $config->setRawColumns([PyzTaskTableMap::COL_STATUS, self::ACTION]);

        return $config;
    }

    /**
     * @param \Spryker\Zed\Gui\Communication\Table\TableConfiguration $config
     *
     * @return array<mixed>
     */
    protected function prepareData(TableConfiguration $config): array
    {
        $taskResult = $this->taskQueryContainer->queryTasks();
        $queryResults = $this->runQuery($taskResult, $config);

        $results = [];
        foreach ($queryResults as $item) {
            $results[] = [
                PyzTaskTableMap::COL_TITLE => $item[PyzTaskTableMap::COL_TITLE],
                PyzTaskTableMap::COL_DESCRIPTION => $item[PyzTaskTableMap::COL_DESCRIPTION],
                PyzTaskTableMap::COL_STATUS => $item[PyzTaskTableMap::COL_STATUS],
                self::ACTION => implode(' ', $this->createActionButtons($item)),
            ];
        }

        return $results;
    }

    /**
     * @param array<string> $task
     *
     * @return array<string>
     */
    public function createActionButtons(array $task): array
    {
        $urls = [];

        $deleteUrl = Url::generate(static::DELETE_TASK_URL, [
            self::PARAM_ID_TASK => $task[PyzTaskTableMap::COL_ID_TASK],
        ]);

        $urls[] = $this->generateRemoveButton($deleteUrl, 'Delete');

        return $urls;
    }

    /**
     * @return array<string, string>
     */
    private function getHeaders(): array
    {
        return [
            PyzTaskTableMap::COL_TITLE => 'Title',
            PyzTaskTableMap::COL_DESCRIPTION => 'Description',
            PyzTaskTableMap::COL_STATUS => 'Status',
            self::ACTION => self::ACTION,
        ];
    }

    /**
     * @return array<string>
     */
    private function getSortable(): array
    {
        return [
            PyzTaskTableMap::COL_TITLE,
            PyzTaskTableMap::COL_DESCRIPTION,
        ];
    }

    /**
     * @return array<string>
     */
    private function getSearchable(): array
    {
        return [
            PyzTaskTableMap::COL_TITLE,
            PyzTaskTableMap::COL_DESCRIPTION,
        ];
    }
}
