<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 13/04/15
 * Time: 11:26
 */

namespace app\modules\couple\components\widgets;

use yii\widgets\InputWidget;

class FilePreview extends InputWidget
{
    public $ajaxSubmit = false;

    public function run()
    {
        return $this->render('file-preview', [
            'model'      => $this->model,
            'attribute'  => $this->attribute,
            'ajaxSubmit' => $this->ajaxSubmit,
        ]);
    }
}