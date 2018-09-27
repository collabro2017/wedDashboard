<?php
namespace app\models\ext;

use app\models\BeverageLike;
use app\models\MediaComment;
use app\models\MediaGuest;
use app\models\MediaLike;
use app\models\Song;
use app\models\SongLike;
use app\models\TriviaAnswer;
use app\models\TriviaLeaderboard;
use app\models\WeddingQuery;
use yii\helpers\ArrayHelper;

/**
 * Class Guest
 * @package app\models\ext
 *
 * @property Token $activeToken
 */
class Guest extends \app\models\Guest
{
    /**
     * @return Guest | null
     */
    public static function loggedIn()
    {
        if (\Yii::$app->user->isGuest) {
            return null;
        }

        /** @noinspection PhpUndefinedFieldInspection */
        return \Yii::$app->user->identity->guest;
    }

    public function clearData()
    {
        SongLike::deleteAll([
            'guest_id' => ArrayHelper::getColumn(Guest::findAll(['wedding_id' => $this->wedding_id]), 'id')
        ]);

        TriviaAnswer::deleteAll([
            'guest_id' => ArrayHelper::getColumn(Guest::findAll(['wedding_id' => $this->wedding_id]), 'id')
        ]);

        BeverageLike::deleteAll([
            'guest_id' => ArrayHelper::getColumn(Guest::findAll(['wedding_id' => $this->wedding_id]), 'id')
        ]);

        GuestPollOption::deleteAll([
            'guest_id' => ArrayHelper::getColumn(Guest::findAll(['wedding_id' => $this->wedding_id]), 'id')
        ]);

        MediaLike::deleteAll([
            'guest_id' => ArrayHelper::getColumn(Guest::findAll(['wedding_id' => $this->wedding_id]), 'id')
        ]);

        MediaGuest::deleteAll([
            'guest_id' => ArrayHelper::getColumn(Guest::findAll(['wedding_id' => $this->wedding_id]), 'id')
        ]);

        MediaComment::deleteAll([
            'guest_id' => ArrayHelper::getColumn(Guest::findAll(['wedding_id' => $this->wedding_id]), 'id')
        ]);

        Media::deleteAll([
            'guest_id' => ArrayHelper::getColumn(Guest::findAll(['wedding_id' => $this->wedding_id]), 'id')
        ]);

        Song::deleteAll([
            'guest_id' => ArrayHelper::getColumn(Guest::findAll(['wedding_id' => $this->wedding_id]), 'id')
        ]);

        Token::deleteAll([
            'guest_id' => ArrayHelper::getColumn(Guest::findAll(['wedding_id' => $this->wedding_id]), 'id')
        ]);
    }

    /**
     * @inheritDoc
     */
    public function beforeDelete()
    {
        $this->clearData();

        return parent::beforeDelete();
    }

    /**
     * @return string
     */
    public function getFullName()
    {
        return implode(' ', [$this->first_name, $this->last_name]);
    }

    /**
     * @return WeddingQuery
     */
    public function getWedding()
    {
        return $this->hasOne(Wedding::className(), ['id' => 'wedding_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrivia()
    {
        return Trivia::find()->where([
            'id' => ArrayHelper::map(TriviaLeaderboard::find()
                                                      ->where(['guest_id' => $this->id])
                                                      ->select('trivia_id')
                                                      ->asArray()->all(), 'trivia_id', 'trivia_id')
        ]);
    }

    /**
     * @param bool $triviaId
     *
     * @return int|string
     */
    public function getRank($triviaId = null)
    {
        $ranks =  TriviaLeaderboard::find()
                                ->andWhere(['wedding_id' => $this->wedding_id])
                                ->andFilterWhere(['trivia_id' => $triviaId])
//                                ->andWhere('guest_id >= :guest_id', [':guest_id' => $this->id])
                                ->orderBy('score desc')->all();
        foreach ($ranks as $key=>$value){
            if($this->id == $value->guest_id){
                return $key+1;
            }
        }
    }

    /**
     * @param bool $triviaId
     *
     * @return bool|mixed
     */
    public function getPoints($triviaId = null)
    {
        if ($points = TriviaLeaderboard::find()
                                       ->andWhere(['wedding_id' => $this->wedding_id])
                                       ->andFilterWhere(['trivia_id' => $triviaId])
                                       ->andWhere(['guest_id' => $this->id])->one()
        ) {
            return $points->score;
        }

        return 0;
    }

    /**
     * @return Token
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
    public function getPhotoComments()
    {
        return $this->hasMany(MediaComment::className(), ['guest_id' => 'id'])
                    ->joinWith('media')
                    ->where(['media.kind' => 'photo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVideoComments()
    {
        return $this->hasMany(MediaComment::className(), ['guest_id' => 'id'])
                    ->joinWith('media')
                    ->where(['media.kind' => 'video']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPhotoLikes()
    {
        return $this->hasMany(MediaLike::className(), ['guest_id' => 'id'])
                    ->joinWith('media')
                    ->where(['media.kind' => 'photo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVideoLikes()
    {
        return $this->hasMany(MediaLike::className(), ['guest_id' => 'id'])
                    ->joinWith('media')
                    ->where(['media.kind' => 'video']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPhotos()
    {
        return $this->hasMany(Media::className(), ['guest_id' => 'id'])->where(['kind' => 'photo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVideo()
    {
        return $this->hasMany(Media::className(), ['guest_id' => 'id'])->where(['kind' => 'video']);
    }
}