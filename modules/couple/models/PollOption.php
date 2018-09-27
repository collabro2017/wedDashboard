<?php

namespace app\modules\couple\models;

use yii\validators\UniqueValidator;

class PollOption extends \app\models\ext\PollOption
{
    public function init()
    {
        parent::init();

        foreach ($this->activeValidators as $validator) {
            if ($validator->className() == UniqueValidator::className()) {
                /** @var UniqueValidator $validator */
                $validator->message = 'Please enter different options';
            }
        }
    }
}