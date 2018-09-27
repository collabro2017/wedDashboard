<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vendor".
 *
 * @property integer $id
 * @property string $type
 * @property string $name
 * @property string $facebook
 * @property string $website
 * @property integer $wedding_id
 * @property integer $order
 *
 * @property Wedding $wedding
 */
class Vendor extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vendor';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'name', 'wedding_id'], 'required'],
            [['type'], 'string'],
            [['wedding_id', 'order'], 'integer'],
            [['name', 'facebook', 'website'], 'string', 'max' => 255],
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
            'type' => Yii::t('app', 'Type'),
            'name' => Yii::t('app', 'Name'),
            'facebook' => Yii::t('app', 'Facebook'),
            'website' => Yii::t('app', 'Website'),
            'wedding_id' => Yii::t('app', 'Wedding ID'),
            'order' => Yii::t('app', 'Order'),
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
     * @return VendorQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new VendorQuery(get_called_class());
    }
}
