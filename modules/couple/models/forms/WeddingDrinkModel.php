<?php
namespace app\modules\couple\models\forms;

use app\models\ext\Alcohol;
use app\models\ext\WeddingDrink;
use app\modules\couple\models\DrinkCategory;
use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * Class WeddingDrinkModel
 * @package app\modules\couple\models\forms
 */
class WeddingDrinkModel extends Model
{
    /**
     * @var
     */
    public $alcoholId;

    /** @var WeddingDrink $weddingDrink */
    protected $weddingDrink;

    /**
     * @var
     */
    public $brandId;

    /**
     * @var
     */
    public $exclusiveBrandName;

    /** @var DrinkCategory $category */
    protected $category;

    /**
     * @inheritDoc
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['alcoholId', 'brandId', 'exclusiveBrandName'], 'safe'],
            [['alcoholId'], 'required']
        ]);
    }

    /**
     * @inheritDoc
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'alcoholId' => 'Drink type',
            'brandId' => 'Brand',
            'exclusiveBrandName' => 'Exclusive Brand Name'
        ]);
    }

    /**
     * @return bool
     */
    public function save()
    {
        if (!$this->validate()) {
            return false;
        }

        if (!$this->weddingDrink) {
            return $this->create();
        } else {
            return $this->update();
        }
    }

    /**
     * @param $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }

    /**
     * @param $drink
     */
    public function setWeddingDrink($drink)
    {
        $this->weddingDrink = $drink;
        if ($this->weddingDrink->alcohol->parent_id) {
            $this->alcoholId = $this->weddingDrink->alcohol->parent_id;

            if ($drink->alcohol->wedding_id) {
                $this->exclusiveBrandName = $this->weddingDrink->alcohol->name;
            } else {
                $this->brandId = $this->weddingDrink->alcohol->id;
            }
        } else {
            $this->alcoholId = $this->weddingDrink->alcohol->id;
        }
    }

    /**
     * @return bool
     */
    protected function create()
    {
        /** @var Alcohol $brand */
        if ($this->brandId) {
            return $this->createFromBrand();
        }

        if ($this->alcoholId && !$this->exclusiveBrandName) {
            return $this->createFromAlcohol();
        }

        if ($this->exclusiveBrandName) {
            return $this->createFromExclusiveBrand();
        }

        return false;
    }

    /**
     * @return bool
     */
    protected function update()
    {
        if ($this->brandId) {
            return $this->updateFromBrand();
        }

        if ($this->alcoholId && !$this->exclusiveBrandName) {
            return $this->updateFromAlcohol();
        }

        if ($this->exclusiveBrandName) {
            return $this->updateFromExclusiveBrand();
        }

        return false;
    }

    /**
     * @return bool
     */
    protected function updateFromExclusiveBrand()
    {
        $parent = Alcohol::findOne($this->alcoholId);
        $alcohol = Alcohol::find()->where([
            'name' => $this->exclusiveBrandName,
            'parent_id' => $this->alcoholId,
            'wedding_id' => $this->weddingDrink->drinkCategory->wedding_id
        ])->one();

        if (!$alcohol) {
            $alcohol = new Alcohol();
            $alcohol->setAttributes([
                'parent_id' => $this->alcoholId,
                'name' => $this->exclusiveBrandName,
                'wedding_id' => $this->weddingDrink->drinkCategory->id,
                'can_combine' => $parent->can_combine
            ]);

            if (!$alcohol->save() || !$alcohol->refresh()) {
                $this->addError('exclusiveBrandName', 'Incorrect exclusive brand name');
                return false;
            }
        }

        $oldAlcohol = null;
        if ($this->weddingDrink->alcohol_id != $alcohol->id) {
            $oldAlcohol = $this->weddingDrink->alcohol;
        }


        $this->weddingDrink->alcohol_id = $alcohol->id;
        if (!$this->weddingDrink->save()) {
            $this->addError('exclusiveBrandName', 'Incorrect exclusive brand name');
            return false;
        }

        if ($oldAlcohol) {
            $oldAlcohol->delete();
        }

        return true;
    }

    /**
     * @return bool
     */
    protected function updateFromBrand()
    {
        $isSameExist = WeddingDrink::find()->where([
            'alcohol_id' => $this->alcoholId,
            'drink_category_id' => $this->weddingDrink->drinkCategory->id,
        ])->andWhere(['not', 'id' => $this->weddingDrink->id])->exists();

        if ($isSameExist) {
            $this->addError('brandId', 'This drink already added');
            return false;
        }

        $this->weddingDrink->alcohol_id = $this->brandId;
        if (!$this->weddingDrink->save()) {
            $this->addError('brandId', 'Incorrect brand');
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    protected function updateFromAlcohol()
    {
        $isSameExist = WeddingDrink::find()->where([
            'alcohol_id' => $this->alcoholId,
            'drink_category_id' => $this->weddingDrink->drinkCategory->id,
        ])->andWhere(['not', 'id' => $this->weddingDrink->id])->exists();

        if ($isSameExist) {
            $this->addError('alcoholId', 'This drink already added');
            return false;
        }

        $this->weddingDrink->alcohol_id = $this->brandId;
        if (!$this->weddingDrink->save()) {
            $this->addError('alcoholId', 'Incorrect brand');
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    protected function createFromBrand()
    {
        $weddingDrink = $this->getWeddingDrink(Alcohol::findOne($this->brandId));

        if (!$weddingDrink->isNewRecord) {
            $this->addError('brandId', 'This drink already added');
            return false;
        }

        if (!$weddingDrink->save()) {
            $this->addError('brandId', 'Incorrect brand');
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    protected function createFromAlcohol()
    {
        $weddingDrink = $this->getWeddingDrink(Alcohol::findOne($this->alcoholId));
        if (!$weddingDrink->isNewRecord) {
            $this->addError('alcoholId', 'This drink already added');
            return false;
        }

        if (!$weddingDrink->save()) {
            $this->addError('alcoholId', 'Incorrect drink type');
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    protected function createFromExclusiveBrand()
    {
        $parent = Alcohol::findOne($this->alcoholId);
        $alcohol = new Alcohol();
        $alcohol->name = $this->exclusiveBrandName;
        $alcohol->parent_id = $this->alcoholId;
        $alcohol->wedding_id = $this->category->wedding_id;
        $alcohol->can_combine = $parent->can_combine;

        if (!$alcohol->save() || !$alcohol->refresh()) {
            $this->addError('exclusiveBrandName', 'Incorrect exclusive brand name');
        }

        $weddingDrink = new WeddingDrink();
        $weddingDrink->alcohol_id = $alcohol->id;
        $weddingDrink->drink_category_id = $this->category->id;

        if (!$weddingDrink->save()) {
            $this->addError('exclusiveBrandName', 'Incorrect exclusive brand name');

            return false;
        }

        return true;
    }

    /**
     * @param $alcohol
     *
     * @return WeddingDrink|\app\models\WeddingDrink|array|null
     */
    protected function getWeddingDrink($alcohol)
    {
        $weddingDrink = WeddingDrink::find()->where([
            'alcohol_id' => $alcohol->id,
            'drink_category_id' => $this->category->id
        ])->one();

        if ($weddingDrink) {
            return $weddingDrink;
        }

        $weddingDrink = new WeddingDrink();
        $weddingDrink->drink_category_id = $this->category->id;
        $weddingDrink->alcohol_id = $alcohol->id;

        return $weddingDrink;
    }
}