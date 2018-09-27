<?php

namespace app\modules\couple\models;

/**
 * Class Poll
 * @package app\modules\couple\models
 *
 * @property array $editableOptions
 */
class Poll extends \app\models\ext\Poll
{
    /**
     * @param bool $insert
     *
     * @return bool
     */
    public function beforeSave($insert)
    {
        if ($insert) {
            $this->order = static::find()->count() + 1;
        }

        return parent::beforeSave($insert);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPollOptions()
    {
        return $this->hasMany(PollOption::className(), ['poll_id' => 'id']);
    }

    /**
     * @return \app\models\PollOption[]|array
     */
    public function getEditableOptions()
    {
        $options = $this->pollOptions;
        for ($index = count($options); $index < self::MAX_OPTIONS; $index++) {
            $options[] = new PollOption();
        }

        return $options;
    }

    /**
     * @param $options
     *
     * @return bool
     */
    public function setEditableOptions($options)
    {
        $result = true;

        /** @var PollOption $option */
        foreach ($options as $option) {

            if ($option->isNewRecord) {
                if (strlen($option->body) > 0) {
                    $option->poll_id = $this->id;
                    if ($result &= ($option->save() && $option->refresh())) {
                        $this->link('pollOptions', $option);
                    }
                } else {
                    continue;
                }
            } else {
                if (!strlen($option->body)) {
                    $this->unlink('pollOptions', $option, true);
                } else {
                    $result &= $option->save();
                }
            }
        }

        return $result;
    }
}