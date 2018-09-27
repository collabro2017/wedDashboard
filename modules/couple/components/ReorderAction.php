<?php

namespace app\modules\couple\components;

use yii\base\Action;
use yii\base\Exception;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii2vm\components\ModelException;

/**
 * Class ReorderAction
 * @package app\modules\couple\components
 */
class ReorderAction extends Action
{
    /** @var callable | ActiveQuery */
    public $allQuery;

    /**
     * @param $current
     * @param $prev
     * @param $next
     *
     * @return bool
     * @throws Exception
     * @internal param array $params
     */
    public function run($current, $prev, $next)
    {
        if (!$prev && !$next) {
            return false;
        }

        if (is_callable($this->allQuery)) {
            $this->allQuery = call_user_func($this->allQuery);
        }

        $modelClass = $this->allQuery->modelClass;

        /** @var ActiveRecord $current */
        $current = $this->getModel($current);

        /** @var ActiveRecord $next */
        $next = $this->getModel($next);

        $index        = $prev ? $this->getModel($prev)->order : 0;
        $currentIndex = ++$index;

        if ($next) {
            $query     = clone $this->allQuery;
            $tableName = forward_static_call([$modelClass, 'tableName']);

            foreach ($query->andWhere($tableName . '.order >= :next')
                           ->addParams([':next' => $next->order])
                           ->orderBy($tableName . '.order asc')
                           ->all() as $model) {

                $model->order = ++$index;

                if (!$model->save()) {
                    new ModelException($model);
                };
            }
        }

        $current->order = $currentIndex;

        if (!$current->save()) {
            new ModelException($current);
        };

        $this->reindex();

        return true;
    }

    /**
     * @param $identifier
     *
     * @return mixed
     * @internal param $params
     * @internal param $attribute
     */
    private function getModel($identifier)
    {
        return forward_static_call([$this->allQuery->modelClass, 'findOne'], $identifier);
    }

    private function reindex()
    {
        $tableName = forward_static_call([$this->allQuery->modelClass, 'tableName']);

        $index = 0;

        foreach ($this->allQuery
                     ->orderBy($tableName . '.order asc')
                     ->all() as $model) {
            $model->order = ++$index;

            if (!$model->save()) {
                new ModelException($model);
            };
        }

        return true;
    }
}