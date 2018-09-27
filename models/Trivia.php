<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "trivia".
 *
 * @property integer $id
 * @property string $type
 * @property string $icon_filename
 * @property integer $wedding_id
 * @property integer $max_score
 * @property integer $order
 * @property integer $is_removable
 *
 * @property Question[] $questions
 * @property Wedding $wedding
 */
class Trivia extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'trivia';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type'], 'string'],
            [['wedding_id'], 'required'],
            [['wedding_id', 'max_score', 'order', 'is_removable'], 'integer'],
            [['icon_filename'], 'string', 'max' => 45],
            [['wedding_id', 'type'], 'unique', 'targetAttribute' => ['wedding_id', 'type'], 'message' => 'The combination of Type and Wedding ID has already been taken.'],
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
            'icon_filename' => Yii::t('app', 'Icon Filename'),
            'wedding_id' => Yii::t('app', 'Wedding ID'),
            'max_score' => Yii::t('app', 'Max Score'),
            'order' => Yii::t('app', 'Order'),
            'is_removable' => Yii::t('app', 'Is Removable'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestions()
    {
        return $this->hasMany(Question::className(), ['trivia_id' => 'id']);
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
     * @return TriviaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TriviaQuery(get_called_class());
    }
}
