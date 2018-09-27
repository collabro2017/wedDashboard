<?php

namespace app\commands;

use app\models\BaseDrink;
use app\models\DrinkBrand;
use app\models\DrinkLike;
use app\models\DrinkMixer;
use app\models\DrinkType;
use app\models\ExistingDrinkBaseDrink;
use app\models\ExistingDrinkBrand;
use app\models\ExistingDrinkMixer;
use app\models\ext\ExistingDrink;
use app\modules\couple\models\AvailableDrink;
use yii\console\Exception;

class DatabaseController extends \yii\console\Controller
{

    public function actionCleanDrinks()
    {
        ExistingDrinkBaseDrink::deleteAll();
        ExistingDrinkBrand::deleteAll();
        ExistingDrinkMixer::deleteAll();
        AvailableDrink::deleteAll();
        DrinkLike::deleteAll();

        ExistingDrink::deleteAll();
        DrinkBrand::deleteAll();
        BaseDrink::deleteAll();
        DrinkMixer::deleteAll();


        \Yii::$app->db->createCommand('ALTER TABLE '.DrinkLike::tableName().' AUTO_INCREMENT = 1')->execute();
        \Yii::$app->db->createCommand('ALTER TABLE '.ExistingDrink::tableName().' AUTO_INCREMENT = 1')->execute();
        \Yii::$app->db->createCommand('ALTER TABLE '.DrinkBrand::tableName().' AUTO_INCREMENT = 1')->execute();
        \Yii::$app->db->createCommand('ALTER TABLE '.BaseDrink::tableName().' AUTO_INCREMENT = 1')->execute();
        \Yii::$app->db->createCommand('ALTER TABLE '.DrinkMixer::tableName().' AUTO_INCREMENT = 1')->execute();

        \Yii::$app->db->createCommand('ALTER TABLE '.ExistingDrinkBaseDrink::tableName().' AUTO_INCREMENT = 1')->execute();
        \Yii::$app->db->createCommand('ALTER TABLE '.ExistingDrinkBrand::tableName().' AUTO_INCREMENT = 1')->execute();
        \Yii::$app->db->createCommand('ALTER TABLE '.ExistingDrinkMixer::tableName().' AUTO_INCREMENT = 1')->execute();
        \Yii::$app->db->createCommand('ALTER TABLE '.AvailableDrink::tableName().' AUTO_INCREMENT = 1')->execute();
    }

    protected function importBaseDrinksAndMixers($handle)
    {

        $data = fgetcsv($handle);
        $baseDrinkKey = null;
        $mixerKey = null;

        foreach ($data as $key => $value) {
            if ($value === 'Base Drink') {
                $baseDrinkKey = $key;
            }
            if ($value === 'Mixers') {
                $mixerKey = $key;
            }
        }

        if (!$baseDrinkKey || !$mixerKey) {
            throw new Exception('Base Drink or Mixers columns does not exist');
        }

        while (($data = fgetcsv($handle)) !== false) {
            if (trim($data[$baseDrinkKey])) {
                $baseDrink = new BaseDrink();
                $baseDrink->name = trim($data[$baseDrinkKey]);
                $baseDrink->save();
            }

            if (trim($data[$mixerKey])) {
                $mixer = new DrinkMixer();
                $mixer->name = trim($data[$mixerKey]);
                $mixer->save();
            }
        }
    }

    public function actionImportDrinkTypes()
    {
        $path   = '../../data/CSVData/Wedo-Drink-Database-Drink-Types.csv';
        $handle = fopen($path, 'r');

        $this->importBaseDrinksAndMixers($handle);
        fclose($handle);

        $handle = fopen($path, 'r');

        $baseDrinkIdToBrandColumnMap = [];
        $data = fgetcsv($handle);
        foreach ($data as $key => $value) {
            if ($value === 'Base Drink' || $value === 'Mixers' || !trim($value)) {
                continue;
            }

            echo $value . "\n";
            /** @var BaseDrink $baseDrink */
            $baseDrink = BaseDrink::find()->where(['name' => trim($value)])->one();
            if (!$baseDrink) {
                $baseDrink = new BaseDrink();
                $baseDrink->name = trim($value);
                $baseDrink->save();
                $baseDrink->refresh();
            }
            $baseDrinkIdToBrandColumnMap[$key] = $baseDrink->id;
        }

        while (($data = fgetcsv($handle)) !== false) {

            foreach($baseDrinkIdToBrandColumnMap as $column => $baseDrinkId) {
                if (trim($data[$column])) {
                    $drinkBrand = new DrinkBrand();
                    $drinkBrand->name = trim($data[$column]);
                    $drinkBrand->base_drink_id = $baseDrinkId;
                    $drinkBrand->save();
                }
            }
        }
    }

    protected function getBaseDrinkByName($name)
    {
        $name = trim($name);
        static $baseDrinkCache = [];

        if (!array_key_exists($name, $baseDrinkCache)) {
            $baseDrink = BaseDrink::find()->where(['name' => $name])->one();
            if (!$baseDrink) {
                $baseDrink = new BaseDrink();
                $baseDrink->name = $name;
                $baseDrink->save();
                $baseDrink->refresh();
            }
            $baseDrinkCache[$name] = $baseDrink;
        }

        return $baseDrinkCache[$name];
    }

    protected function getDrinkBrandByName($name)
    {
        $name = trim($name);

        static $drinkBrandCache = [];

        if (!array_key_exists($name, $drinkBrandCache)) {
            $drinkBrand = DrinkBrand::find()->where(['name' => $name])->one();
            if (!$drinkBrand) {
                $drinkBrand = new DrinkBrand();
                $drinkBrand->name = $name;
                $drinkBrand->save();
                $drinkBrand->refresh();
            }
            $drinkBrandCache[$name] = $drinkBrand;
        }

        return $drinkBrandCache[$name];
    }

    protected function getDrinkMixerByName($name)
    {
        $name = trim($name);

        static $drinkMixerCache = [];

        if (!array_key_exists($name, $drinkMixerCache)) {
            $drinkMixer = DrinkMixer::find()->where(['name' => $name])->one();
            if (!$drinkMixer) {
                $drinkMixer = new DrinkMixer();
                $drinkMixer->name = $name;
                $drinkMixer->save();
                $drinkMixer->refresh();
            }
            $drinkMixerCache[$name] = $drinkMixer;
        }

        return $drinkMixerCache[$name];
    }

    protected function getDrinkCategoryByName($name)
    {
        $name = strtolower(trim($name));

        static $drinkCategoryCache = [];

        if (!array_key_exists($name, $drinkCategoryCache)) {

            $drinkCategory = DrinkType::find()->where(['name' => $name])->one();
            if (!$drinkCategory) {

                $drinkCategory = new DrinkType();
                $drinkCategory->name = $name;
                $drinkCategory->save();
                $drinkCategory->refresh();

            }
            $drinkCategoryCache[$name] = $drinkCategory;
        }

        return $drinkCategoryCache[$name];
    }

    public function actionImportDrinkDb()
    {


        $path   = '../../data/CSVData/Wedo-Drink-Database-DrinkDB.csv';
        $handle = fopen($path, 'r');
        $data = fgetcsv($handle);

        $counter = 0;
        while (($data = fgetcsv($handle)) !== false) {
            $counter++;
            if ($counter % 50 === 0) {
                echo $counter / 100 . "\n";
            }
            $existingDrink = new ExistingDrink();
            $existingDrink->name = $data[0];
            $existingDrink->ingredients = $data[1];
            $existingDrink->instructions = $data[2];
            $existingDrink->save();
            $existingDrink->refresh();

            if (trim($data[3])) {
                $baseDrinks = explode(',', trim($data[3]));
                foreach ($baseDrinks as $baseDrinkName) {
                    if (trim($baseDrinkName));
                    $existingDrink->link('baseDrinks', $this->getBaseDrinkByName(trim($baseDrinkName)));
                }
            }

            if (trim($data[4])) {
                $drinkBrands = explode(',', trim($data[4]));
                foreach ($drinkBrands as $drinkBrandName) {
                    $existingDrink->link('drinkBrands', $this->getDrinkBrandByName(trim($drinkBrandName)));
                }
            }

            if (trim($data[5])) {
                $drinkMixers = explode(',', trim($data[5]));
                foreach ($drinkMixers as $drinkMixerName) {
                    $existingDrink->link('drinkMixers', $this->getDrinkMixerByName(trim($drinkMixerName)));
                }
            }

            if (trim($data[6])) {
                $drinkTypeName = trim($data[6]);
                $existingDrink->link('type', $this->getDrinkCategoryByName(strtolower(trim($drinkTypeName))));
            }
        }
    }
}