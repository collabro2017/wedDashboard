<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 24/04/15
 * Time: 17:22
 */

namespace app\modules\couple\components\widgets;

use yii\base\Widget;

class EditButton extends Widget
{
    public $url;

    public function run()
    {
        return $this->render('edit-button', ['url' => $this->url]);
    }
}