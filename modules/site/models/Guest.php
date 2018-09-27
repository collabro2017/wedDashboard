<?php

namespace app\modules\site\models;

use yii\helpers\Url;

class Guest extends \app\models\ext\Guest
{

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActiveToken()
    {
        $token = $this->hasOne(Token::className(), ['guest_id' => 'id'])->orderBy('created_at desc')->one();

        if ($token && !$token->is_valid) {
            return null;
        }

        if (!$token) {
            $token = Token::create($this);
        }

        return $token;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMedia()
    {
        return $this->hasMany(Media::className(), ['guest_id' => 'id']);
    }

    public function getAvatarUrl()
    {
        if ($this->image_filename) {
            return Url::to(['/' . $this->image_filename . '?utm=' . crc32(uniqid())]);
        }

        return 'http://www.gravatar.com/avatar/' . md5($this->email);
    }
}