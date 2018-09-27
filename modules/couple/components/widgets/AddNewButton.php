<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 25/03/15
 * Time: 20:11
 */

namespace app\modules\couple\components\widgets;

use app\modules\couple\models\Wedding;
use yii\base\Widget;

class AddNewButton extends Widget
{
    public $url;
    public $text;
    public $options = [];

    public function run()
    {
        if (Wedding::current()->editable) {
            return $this->render('add-new-button', [
                'text'    => $this->text,
                'url'     => $this->url,
                'options' => $this->options,
            ]);
        }

        return null;
    }
}