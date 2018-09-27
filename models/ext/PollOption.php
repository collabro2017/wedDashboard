<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 10/04/15
 * Time: 13:31
 */

namespace app\models\ext;


use yii2vm\db\ActiveScopeTrait;

class PollOption extends \app\models\PollOption
{
    use ActiveScopeTrait;

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGuestPollOptions()
    {
        return $this->hasMany(GuestPollOption::className(), ['poll_option_id' => 'id']);
    }

    public function beforeDelete()
    {
        $result = true;
        foreach ($this->guestPollOptions as $option) {
            $result = $result && $option->delete();
        }

        return $result && parent::beforeDelete();
    }
}