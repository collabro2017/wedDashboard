<?php
namespace app\modules\site\models;

use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

class Media extends \app\models\ext\Media
{
    public $image;

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['image'], 'safe'],
            [['image'], 'file', 'extensions' => ['png', 'jpeg', 'jpg']]
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGuest()
    {
        return $this->hasOne(Guest::className(), ['id' => 'guest_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMediaComments()
    {
        return $this->hasMany(MediaComment::className(), ['media_id' => 'id']);
    }

    public function behaviors()
    {
        return [
            [
                'class'              => TimestampBehavior::className(),
                'value'              => new Expression('UTC_TIMESTAMP'),
                'updatedAtAttribute' => false
            ]
        ];
    }
}