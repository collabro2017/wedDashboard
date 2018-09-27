<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[ExistingDrink]].
 *
 * @see ExistingDrink
 */
/**
 * Class ExistingDrinkQuery
 * @package app\models
 */
class ExistingDrinkQuery extends \yii\db\ActiveQuery
{
    /**
     * @param $weddingId
     *
     * @return $this
     */
    public function availableDrinks($weddingId)
    {
        $this->joinWith('baseDrinks', true, 'RIGHT JOIN');

        $this->leftJoin([
            'available_drink' => AvailableDrink::find()
                                               ->joinWith('drinkCategory')
                                               ->where(['drink_category.wedding_id' => $weddingId])
        ],
            'available_drink.base_drink_id = existing_drink_base_drink.base_drink_id'
        );

        $this->groupBy('existing_drink.id')
             ->having('count(existing_drink_base_drink.base_drink_id) = count(available_drink.base_drink_id)');

        return $this;
    }

    /**
     * @param      $weddingId
     * @param null $baseDrinkId
     * @param null $mixerId
     * @param null $brandId
     * @param null $drinkTypeId
     *
     * @return $this
     */
    public function random(
        $weddingId,
        $baseDrinkId = null,
        $mixerId = null,
        $brandId = null,
        $drinkTypeId = null
    )
    {
        $this->availableDrinks($weddingId)->joinWith(['drinkMixers', 'drinkBrands']);

        if ($baseDrinkId) {

            $this->join('LEFT JOIN', 'existing_drink_base_drink as edbd', 'existing_drink_base_drink.existing_drink_id = edbd.existing_drink_id');
            $this->andWhere(['edbd.base_drink_id' => $baseDrinkId]);
            $this->andWhere(['existing_drink_brand.existing_drink_id' => null]);

            if ($brandId) {
                $this->orWhere(['drink_brand.id' => $brandId]);
            }
        }

        if ($mixerId) {
            $this->andWhere(['drink_mixer.id' => $mixerId]);
        }

        if ($drinkTypeId) {
            $this->andWhere(['existing_drink.type_id' => $drinkTypeId]);
        }

        $this->addOrderBy('RAND()');

        return $this;

    }

    /**
     * @inheritdoc
     * @return ExistingDrink[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ExistingDrink|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
