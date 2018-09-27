<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 10/04/15
 * Time: 13:18
 */

namespace app\models\ext;

use yii\db\Expression;
use yii\web\BadRequestHttpException;
use yii2vm\components\ModelException;
use yii2vm\db\ActiveScopeTrait;
use yii2vm\pushes\PushProvider;

/**
 * Class Poll
 * @package app\models\ext
 */
class Poll extends \app\models\Poll
{
    /**
     *
     */
    const MAX_OPTIONS = 4;

    use ActiveScopeTrait;

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPollOptions()
    {
        return $this->hasMany(PollOption::className(), ['poll_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVotes()
    {
        return GuestPollOption::find()->joinWith([
            'pollOption'
        ])->andWhere([
            'poll_option.poll_id' => $this->id
        ]);
    }


    /**
     * @param $guest
     * @return array|null|\yii\db\ActiveRecord
     */
    public function voteOf($guest)
    {
        return $this->getVotes()->andWhere([
            'guest_id' => $guest->id
        ])->one();
    }

    /**
     * @throws BadRequestHttpException
     * @throws ModelException
     */
    public function start()
    {
        if ($this->started_at) {
            throw new BadRequestHttpException('Poll has already been started');
        }

        $this->started_at = new Expression('utc_timestamp');
        if (!($this->save() && $this->refresh())) {
            throw new ModelException($this);
        }

        /** @var PushProvider $provider */
        $provider = \Yii::$app->push;

        /** @var Guest $guest */
        foreach ($this->wedding->guests as $guest) {
            if ($guest->device_token && !empty($guest->device_token)) {
                try {
                    $provider->compose()
                             ->setTo($guest->device_token)
                             ->setBody('Hurry up! Poll has just been started')
                             ->send();
                } catch (\Exception $exception) {
                    \Yii::error($exception->getMessage());
                }
            }
        }
    }

    /**
     * @throws BadRequestHttpException
     * @throws ModelException
     */
    public function stop()
    {
        if ($this->ended_at) {
            throw new BadRequestHttpException('Poll has already been stopped');
        }

        $this->ended_at = new Expression('utc_timestamp');

        if (!($this->save() && $this->refresh())) {
            throw new ModelException($this);
        }
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function beforeDelete()
    {
        $result = true;
        foreach ($this->pollOptions as $option) {
            $result = $result && $option->delete();
        }

        return $result && parent::beforeDelete();
    }
}