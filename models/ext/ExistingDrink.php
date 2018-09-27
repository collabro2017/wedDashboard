<?php
namespace app\models\ext;

use app\models\DrinkLike;

class ExistingDrink extends \app\models\ExistingDrink
{
    public function isLikedByGuest($id)
    {
        return DrinkLike::find()->where([
            'existing_drink_id' => $this->id,
            'guest_id' => $id
        ])->count() > 0;
    }

    public function beforeDelete()
    {
        foreach ($this->drinkLikes as $like) {
            $like->delete();
        }

        return parent::beforeDelete();
    }
}