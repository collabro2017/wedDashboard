<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "participant".
 *
 * @property integer $id
 * @property string $fullname
 * @property string $member
 * @property string $image_filename
 * @property integer $wedding_id
 * @property integer $order
 * @property string $relation_to
 *
 * @property Wedding $wedding
 */
class Participant extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'participant';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fullname', 'wedding_id'], 'required'],
            [['wedding_id', 'order'], 'integer'],
            [['fullname', 'image_filename'], 'string', 'max' => 45],
            [['member', 'relation_to'], 'string', 'max' => 255],
            [['wedding_id'], 'exist', 'skipOnError' => true, 'targetClass' => Wedding::className(), 'targetAttribute' => ['wedding_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'fullname' => Yii::t('app', 'Fullname'),
            'member' => Yii::t('app', 'Member'),
            'image_filename' => Yii::t('app', 'Image Filename'),
            'wedding_id' => Yii::t('app', 'Wedding ID'),
            'order' => Yii::t('app', 'Order'),
            'relation_to' => Yii::t('app', 'Relation To'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWedding()
    {
        return $this->hasOne(Wedding::className(), ['id' => 'wedding_id']);
    }

    /**
     * @inheritdoc
     * @return ParticipantQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ParticipantQuery(get_called_class());
    }
}
