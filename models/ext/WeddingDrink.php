<?php
namespace app\models\ext;

class WeddingDrink extends \app\models\WeddingDrink
{
    public function getTitle()
    {
        $brandName     = null;
        $baseDrinkName = null;

        $alcohol = $this->alcohol;
        if (!$alcohol->parent_id) {
            $baseDrinkName = $alcohol->name;
        } else {
            $brandName = $alcohol->name;
            $baseDrinkName = $alcohol->parent->name;
        }

        return sprintf('%s %s', $baseDrinkName, $brandName);
    }

    public function afterDelete()
    {
        if ($this->alcohol->wedding_id) {
            $this->alcohol->delete();
        }
    }
}