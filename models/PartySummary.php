<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "party_summary".
 *
 * @property integer $songs
 * @property integer $wedding_id
 * @property string $table
 */
class PartySummary extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'party_summary';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['songs', 'wedding_id'], 'integer'],
            [['table'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'songs' => Yii::t('app', 'Songs'),
            'wedding_id' => Yii::t('app', 'Wedding ID'),
            'table' => Yii::t('app', 'Table'),
        ];
    }

    /**
     * @inheritdoc
     * @return PartySummaryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PartySummaryQuery(get_called_class());
    }
}
