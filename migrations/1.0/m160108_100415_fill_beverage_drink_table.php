<?php

use yii\db\Migration;
use app\models\ExistingDrinkBrand;
use app\models\Alcohol;
use app\models\BeverageAlcohol;
use app\models\ExistingDrinkBaseDrink;

class m160108_100415_fill_beverage_drink_table extends Migration
{
    public function up()
    {
        /** @var ExistingDrinkBrand $drinkBrand */

        $count = 0;
        foreach (ExistingDrinkBrand::find()->each() as $drinkBrand) {

            $count++;
            $alcohol = Alcohol::find()->where([
                'name' => $drinkBrand->drinkBrand->name
            ])->one();

            $beverageAlcohol = new BeverageAlcohol();
            $beverageAlcohol->alcohol_id = $alcohol->id;
            $beverageAlcohol->beverage_id = $drinkBrand->existing_drink_id;
            $beverageAlcohol->save();

            if ($count % 100 == 0) {
                echo $count."\n";
            }
        }


        /** @var ExistingDrinkBaseDrink $drinkBaseDrink */
        foreach (ExistingDrinkBaseDrink::find()->each() as $drinkBaseDrink) {
            $count++;

            $baseDrink = $drinkBaseDrink->baseDrink;

            $isBrandedAlcohol = BeverageAlcohol::find()->joinWith('alcohol')->join(
                'left join',
                'alcohol as parent',
                'alcohol.parent_id = parent.id'
            )->where([
                'parent.name' => $baseDrink->name,
                'beverage_alcohol.beverage_id' => $drinkBaseDrink->existing_drink_id
            ])->exists();

            if (!$isBrandedAlcohol) {

                try {
                    $alcohol = Alcohol::find()->where([
                        'name' => $drinkBaseDrink->baseDrink->name
                    ])->one();

                    if (!BeverageAlcohol::find()->where([
                        'alcohol_id' => $alcohol->id,
                        'beverage_id' => $drinkBaseDrink->existing_drink_id])->exists()
                    ) {
                        $beverageAlcohol = new BeverageAlcohol();
                        $beverageAlcohol->alcohol_id = $alcohol->id;
                        $beverageAlcohol->beverage_id = $drinkBaseDrink->existing_drink_id;
                        $beverageAlcohol->save();
                    }


                } catch (Exception $e) {
                    throw new \yii\base\Exception($drinkBaseDrink->baseDrink->name. $e->getMessage());
                }
            }
            if ($count % 100 == 0) {
                echo $count."\n";
            }
        }
    }

    public function down()
    {
        echo "m160108_100415_fill_beverage_drink_table cannot be reverted.\n";
    }
}
