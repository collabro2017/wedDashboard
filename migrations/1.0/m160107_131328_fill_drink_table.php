<?php

use yii\db\Migration;
use app\models\BaseDrink;
use app\models\Alcohol;
use yii2vm\components\ModelException;
use app\models\DrinkBrand;
use yii\helpers\ArrayHelper;

class m160107_131328_fill_drink_table extends Migration
{
    protected $drinks = [
        "Captain Morgan's Spiced rum" => 'Rum',
        "Captain Morgan's Rum" => 'Rum',
        "Canadian Club Whiskey" => 'Whiskey',
        'Goldschlager' => 'Vodka',
        "Seagram's 7 Crown" => 'Whiskey',
        'Jägermeister' => 'Liqueurs',
        'Ketel One Vodka' => 'Vodka',
        'Jose Cuervo Tequila' => 'Tequila',
        'Jim Beam' => 'Whiskey',
        'Amaretto' => 'Amaretto',
        "Baliey's Irish Cream" => 'Liqueurs',
        'Rimple Minze' => 'Liqueurs',
        'Chivas Regal Scotch' => 'Whiskey',
        'Creme de Banane' => 'Creme de Banane',
        'Baileys Irish Cream' => 'Liqueurs',
        'Johnnie Walker Red Label Scotch' => 'Whiskey',
        'Glenlivet Scotch' => 'Whiskey',
        'Sothern Comfort' => 'Liqueurs',
        'Bacradi Rum' => 'Rum',
        "Myers Dark Rum" => 'Rum',
        "Myer's Dark Rum" => 'Rum',
        "Myer's Rum" => 'Rum',
        'Beefeater 24' => 'Gin',
        'Smirnoff Ice' => 'Vodka',
        'Grey Goose Vodka' => 'Vodka',
        'Belvedere Vodka' => 'Vodka',
        "Tito's Handmade Vodka" => 'Vodka',
        'Hennessy Cognac' => 'Cognac',
        'Courvoisier Cognac' => 'Cognac',
    ];

    public function up()
    {
        /** @var BaseDrink $baseDrink */
        foreach(BaseDrink::find()->each() as $baseDrink) {
            $drink = new Alcohol();
            $drink->name = $baseDrink->name;

            if ($drink->name == 'Beer') {
                $drink->can_combine = 0;
            }
            if (!$drink->save() || !$drink->refresh()) {
                throw new ModelException($drink);
            }
        }

        /** @var DrinkBrand $brand */
        foreach(DrinkBrand::find()->each() as $brand) {
            $baseDrink = BaseDrink::findOne($brand->base_drink_id);

            if (!$baseDrink) {
                $baseDrink = BaseDrink::find()->where(['name' => ArrayHelper::getValue($this->drinks, $brand->name)])->one();
            }

            if (!$baseDrink) {
                echo $brand->name;
            }

            $drinkWithBrand = new Alcohol();
            $drinkWithBrand->setAttributes([
                'parent_id' => $baseDrink->id,
                'name' => $brand->name,
            ]);
            if (!$drinkWithBrand->save()) {
                throw new ModelException($baseDrink);
            }
        }
    }

    public function down()
    {
        echo "m160107_131328_fill_drink_table cannot be reverted.\n";

        return false;
    }
}
