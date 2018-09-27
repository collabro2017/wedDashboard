<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 09/04/15
 * Time: 21:38
 */

namespace app\modules\couple\components;

class ActiveForm extends \yii\bootstrap\ActiveForm
{
    public $fieldConfig = [
        'horizontalCssClasses' => [
            'label'   => 'col-xs-4 col-md-2',
            'wrapper' => 'col-xs-5 col-md-4'
        ]
    ];

    public function __construct($config = [])
    {
        $config += [
            'layout'                 => 'horizontal',
            'enableAjaxValidation'   => false,
            'enableClientValidation' => false
        ];

        parent::__construct($config);
    }
}