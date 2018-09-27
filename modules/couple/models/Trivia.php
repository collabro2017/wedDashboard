<?php

namespace app\modules\couple\models;

use yii\helpers\Inflector;

/**
 * Class Trivia
 * @package app\modules\couple\models
 *
 * @property string $title
 */
class Trivia extends \app\models\ext\Trivia
{
    public static function getAvailableTypes()
    {
        $types = [
            'bride-and-groom' => 'Bride & Groom Trivia',
            'groom'           => 'Groom Trivia',
            'bride'           => 'Bride Trivia',
            'friends'         => 'Friends Trivia'
        ];

        foreach (Wedding::current()->trivias as $trivia) {
            unset($types[$trivia->type]);
        }

        return $types;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return Inflector::camel2words($this->type) . ' Trivia';
    }

    /**
     * @return string
     */
    public function getHint()
    {
        $questions = $this->getQuestions()->count();

        return $questions > 0 ? sprintf('%d Question(s)', $questions) : 'Click plus on right to add';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestions()
    {
        return $this->hasMany(Question::className(), ['trivia_id' => 'id']);
    }

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
}