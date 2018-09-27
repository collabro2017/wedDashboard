<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 29/01/15
 * Time: 05:39
 */

namespace app\models\ext;

use yii\db\ActiveQuery;
use yii\helpers\Url;

/**
 * Class Wedding
 * @package app\models\ext
 */
class Wedding extends \app\models\Wedding
{
    /**
     * @var
     */
    public $welcome;
    /**
     * @var
     */
    public $bride;
    /**
     * @var
     */
    public $groom;

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPolls()
    {
        return $this->hasMany(Poll::className(), ['wedding_id' => 'id']);
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return sprintf('%s & %s', $this->bride_first_name, $this->groom_first_name);
    }

    /**
     * @return string
     */
    public function getWelcomeUrl()
    {
        return Url::to('@web/' . $this->welcome_filename . '?utm=' . crc32(uniqid()));
    }

    /**
     * @inheritDoc
     */
    public function toArray(array $fields = [], array $expand = [], $recursive = true)
    {
        $parentData = parent::toArray();

        unset(
            $parentData['admin_password']
        );

        return $parentData;
    }
}