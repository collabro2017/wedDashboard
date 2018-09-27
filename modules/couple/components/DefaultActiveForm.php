<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 15/04/15
 * Time: 11:08
 */

namespace app\modules\couple\components;

class DefaultActiveForm extends ActiveForm
{
    public $fieldConfig = [
        'horizontalCssClasses' => [
            'label'   => 'col-xs-5 col-md-3',
            'wrapper' => 'col-xs-7 col-md-9'
        ]
    ];

}