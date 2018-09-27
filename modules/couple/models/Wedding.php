<?php
namespace app\modules\couple\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;
use yii2vm\components\ModelException;

/**
 * Class Wedding
 * @package app\modules\couple\models
 * @property bool $editable
 */
class Wedding extends \app\models\ext\Wedding implements IdentityInterface
{
    /**
     * @return self
     */
    public static function current()
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return Yii::$app->user->identity;
    }

    /**
     * Finds an identity by the given ID.
     *
     * @param string|integer $id the ID to be looked for
     *
     * @return IdentityInterface the identity object that matches the given ID.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentity($id)
    {
        return Wedding::findOne($id);
    }

    /**
     * Finds an identity by the given token.
     *
     * @param mixed $token the token to be looked for
     * @param mixed $type  the type of the token. The value of this parameter depends on the implementation.
     *                     For example, [[\yii\filters\auth\HttpBearerAuth]] will set this parameter to be
     *                     `yii\filters\auth\HttpBearerAuth`.
     *
     * @return IdentityInterface the identity object that matches the given token.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return Wedding::findOne(['code' => $token]);
    }

    /**
     * Returns an ID that can uniquely identify a user identity.
     * @return string|integer an ID that uniquely identifies a user identity.
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns a key that can be used to check the validity of a given identity ID.
     * The key should be unique for each individual user, and should be persistent
     * so that it can be used to check the validity of the user identity.
     * The space of such keys should be big enough to defeat potential identity attacks.
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @return string a key that is used to check the validity of a given identity ID.
     * @see validateAuthKey()
     */
    public function getAuthKey()
    {
        return $this->code;
    }

    /**
     * Validates the given auth key.
     * This is required if [[User::enableAutoLogin]] is enabled.
     *
     * @param string $authKey the given auth key
     *
     * @return boolean whether the given auth key is valid.
     * @see getAuthKey()
     */
    public function validateAuthKey($authKey)
    {
        return $this->code == $authKey;
    }

    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['wedding_date'], 'default', 'value' => null],

            [['admin_email'], 'trim'],
            [['groom_first_name', 'groom_last_name', 'bride_first_name', 'bride_last_name'], 'trim'],
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFoodCategories()
    {
        return $this->hasMany(FoodCategory::className(), ['wedding_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGuests()
    {
        return $this->hasMany(Guest::className(), ['wedding_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParticipants()
    {
        return $this->hasMany(Participant::className(), ['wedding_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPolls()
    {
        return $this->hasMany(Poll::className(), ['wedding_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrivias()
    {
        return $this->hasMany(Trivia::className(), ['wedding_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVendors()
    {
        return $this->hasMany(Vendor::className(), ['wedding_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDrinkCategories()
    {
        return $this->hasMany(DrinkCategory::className(), ['wedding_id' => 'id']);
    }

    /**
     * @return bool
     * @throws ModelException
     */
    public function create()
    {
        $wedding                 = new Wedding();
        $wedding->attributes     = $this->attributes;
        $wedding->enable_sharing = 1;
        $wedding->wedding_date   = (new \DateTime($wedding->wedding_date))->format('Y-m-d');

        $wedding->admin_email      = strtolower($wedding->admin_email);
        $wedding->bride_first_name = ucfirst($wedding->bride_first_name);
        $wedding->bride_last_name  = ucfirst($wedding->bride_last_name);

        $wedding->groom_first_name = ucfirst($wedding->groom_first_name);
        $wedding->groom_last_name  = ucfirst($wedding->groom_last_name);

        if (!($wedding->save() && $wedding->refresh())) {
            throw new ModelException($wedding);
        }

        $trivia               = new Trivia();
        $trivia->is_removable = 0;
        $trivia->type         = 'bride-and-groom';

        $wedding->link('trivias', $trivia);

        return Yii::$app->user->login($wedding);
    }

    /**
     * @throws ModelException
     * @throws \Exception
     */
    public function clearData()
    {
        /** @var Guest $guest */
        foreach ($this->guests as $guest) {
            $guest->delete();
        }

        foreach ($this->polls as $poll) {
            $poll->started_at = null;
            $poll->ended_at   = null;
            if (!$poll->save()) {
                throw new ModelException($poll);
            }
        }
    }

    public function getEditable()
    {
        $date = new \DateTime($this->wedding_date);
        $now  = new \DateTime();

        return YII_DEBUG || ($this->wedding_date && $date && ($date > $now));
    }
}