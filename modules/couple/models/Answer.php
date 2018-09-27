<?php

namespace app\modules\couple\models;

use yii\validators\UniqueValidator;

class Answer extends \app\models\ext\Answer
{
    public function init()
    {
        parent::init();

        foreach ($this->activeValidators as $validator) {
            if ($validator->className() == UniqueValidator::className()) {
                /** @var UniqueValidator $validator */
                $validator->message = 'Please enter different answers';
            }
        }
    }
}