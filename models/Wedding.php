<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "wedding".
 *
 * @property integer $id
 * @property string $bride_first_name
 * @property string $groom_first_name
 * @property string $bride_last_name
 * @property string $groom_last_name
 * @property string $code
 * @property string $admin_email
 * @property string $admin_password
 * @property string $wedding_date
 * @property integer $enable_sharing
 * @property string $welcome_filename
 * @property string $admin_access_token
 * @property string $groom_filename
 * @property string $bride_filename
 * @property string $city
 * @property string $state
 * @property string $country
 *
 * @property DrinkCategory[] $drinkCategories
 * @property FoodCategory[] $foodCategories
 * @property Guest[] $guests
 * @property Participant[] $participants
 * @property Poll[] $polls
 * @property Trivia[] $trivias
 * @property Vendor[] $vendors
 */
class Wedding extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    
    public static function tableName()
    {
        return 'wedding';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['bride_first_name', 'groom_first_name', 'bride_last_name', 'groom_last_name', 'code', 'admin_email', 'admin_password'], 'required'],
            [['wedding_date'], 'safe'],
            [['enable_sharing'], 'integer'],
            [['bride_first_name', 'groom_first_name', 'bride_last_name', 'groom_last_name', 'code'], 'string', 'max' => 45],
            [['admin_email', 'admin_password', 'welcome_filename', 'admin_access_token', 'groom_filename', 'bride_filename', 'city', 'state', 'country'], 'string', 'max' => 255],
            [['code'], 'unique'],
            [['admin_email'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'bride_first_name' => Yii::t('app', 'Bride First Name'),
            'groom_first_name' => Yii::t('app', 'Groom First Name'),
            'bride_last_name' => Yii::t('app', 'Bride Last Name'),
            'groom_last_name' => Yii::t('app', 'Groom Last Name'),
            'code' => Yii::t('app', 'Code'),
            'admin_email' => Yii::t('app', 'Admin Email'),
            'admin_password' => Yii::t('app', 'Admin Password'),
            'wedding_date' => Yii::t('app', 'Wedding Date'),
            'enable_sharing' => Yii::t('app', 'Enable Sharing'),
            'welcome_filename' => Yii::t('app', 'Welcome Filename'),
            'admin_access_token' => Yii::t('app', 'Admin Access Token'),
            'groom_filename' => Yii::t('app', 'Groom Filename'),
            'bride_filename' => Yii::t('app', 'Bride Filename'),
            'city' => Yii::t('app', 'City'),
            'state' => Yii::t('app', 'State'),
            'country' => Yii::t('app', 'Country'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDrinkCategories()
    {
        return $this->hasMany(DrinkCategory::className(), ['wedding_id' => 'id']);
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
     * @inheritdoc
     * @return WeddingQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new WeddingQuery(get_called_class());
    }
    
    /*
     * @return bool
     */
    public function updateWedding() {
        /** @var Wedding $wedding */
        $wedding = Wedding::findOne(['code' => $this->code]);
//        echo '<pre>';
//        print_r($this);exit;
        if (!$this->validate()) {
            return false;
        }

        return $wedding->update();
    }
}
