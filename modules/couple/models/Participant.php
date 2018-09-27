<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 13/04/15
 * Time: 15:16
 */

namespace app\modules\couple\models;

/**
 * Class Participant
 * @package app\modules\couple\models
 */
class Participant extends \app\models\Participant
{
    /**
     * @var
     */
    public $image;

    /**
     * @return array
     */
    public static function members()
    {
        return [
            'Best Man'        => 'Best Man',
            'Maid of Honor'   => 'Maid of Honor',
            'Matron of Honor' => 'Matron of Honor',
            'Bridesmaid'      => 'Bridesmaid',
            'Flower Girl'     => 'Flower Girl',
            'Flower Child'    => 'Flower Child',
            'Groomsmen'       => 'Groomsmen',
            'Ring Bearer'     => 'Ring Bearer',
        ];
    }

    /**
     * @return Participant
     */
    public static function bride()
    {
        $groom = new Participant();
        /** @var Wedding $wedding */
        $wedding = Wedding::current();

        $groom->attributes = [
            'fullname'   => $wedding->bride_first_name . ' ' . $wedding->bride_last_name,
            'member'     => 'Bride',
            'wedding_id' => $wedding->id,
        ];

        return $groom;
    }

    /**
     * @return Participant
     */
    public static function groom()
    {
        $groom = new Participant();
        /** @var Wedding $wedding */
        $wedding = Wedding::current();

        $groom->attributes = [
            'fullname'   => $wedding->groom_first_name . ' ' . $wedding->groom_last_name,
            'member'     => 'Groom',
            'wedding_id' => $wedding->id,
        ];

        return $groom;
    }

    /**
     * @param bool $insert
     *
     * @return bool
     */
    public function beforeSave($insert)
    {
        if ($insert) {
            $this->order = static::find()->count() + 1;
        }

        return parent::beforeSave($insert);
    }
}