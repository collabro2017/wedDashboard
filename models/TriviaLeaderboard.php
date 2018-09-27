<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "trivia_leaderboard".
 *
 * @property integer $guest_id
 * @property string $first_name
 * @property string $last_name
 * @property string $image_filename
 * @property string $table
 * @property integer $trivia_id
 * @property integer $wedding_id
 * @property string $score
 */
class TriviaLeaderboard extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'trivia_leaderboard';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['guest_id', 'first_name', 'last_name', 'table', 'trivia_id', 'wedding_id'], 'required'],
            [['guest_id', 'trivia_id', 'wedding_id'], 'integer'],
            [['score'], 'number'],
            [['first_name', 'last_name', 'table'], 'string', 'max' => 255],
            [['image_filename'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'guest_id' => Yii::t('app', 'Guest ID'),
            'first_name' => Yii::t('app', 'First Name'),
            'last_name' => Yii::t('app', 'Last Name'),
            'image_filename' => Yii::t('app', 'Image Filename'),
            'table' => Yii::t('app', 'Table'),
            'trivia_id' => Yii::t('app', 'Trivia ID'),
            'wedding_id' => Yii::t('app', 'Wedding ID'),
            'score' => Yii::t('app', 'Score'),
        ];
    }

    /**
     * @inheritdoc
     * @return TriviaLeaderboardQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TriviaLeaderboardQuery(get_called_class());
    }
}
