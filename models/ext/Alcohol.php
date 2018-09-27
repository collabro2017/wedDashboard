<?php
namespace app\models\ext;

class Alcohol extends \app\models\Alcohol
{
    public function getTitle()
    {
        $brandName     = null;
        $baseDrinkName = null;


        if (!$this->parent_id) {
            $baseDrinkName = $this->name;
        } else {
            $brandName = $this->name;
            $baseDrinkName = $this->parent->name;
        }

        return sprintf('%s %s', $baseDrinkName, $brandName);
    }
}