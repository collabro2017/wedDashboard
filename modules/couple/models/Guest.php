<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 14/04/15
 * Time: 15:51
 */

namespace app\modules\couple\models;

/**
 * Class Guest
 * @package app\modules\couple\models
 */
class Guest extends \app\models\ext\Guest
{
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGuests()
    {
        return $this->hasMany(Guest::className(), ['wedding_id' => 'id']);
    }
}