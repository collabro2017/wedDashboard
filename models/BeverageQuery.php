<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Beverage]].
 *
 * @see Beverage
 */
class BeverageQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Beverage[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Beverage|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function forWedding($wedding)
    {
        $this->joinWith('beverageAlcohols', true, 'RIGHT JOIN');

        $this->leftJoin([
            'wedding_alcohol' => Alcohol::find()
                                   ->joinWith('weddingDrinks.drinkCategory')
                                   ->where([
                                           'drink_category.wedding_id' => $wedding->id
                                   ])
        ],
            '(wedding_alcohol.id = beverage_alcohol.alcohol_id) or (beverage_alcohol.alcohol_id = wedding_alcohol.parent_id)'
        );

        $this->groupBy('beverage.id')
             ->having('
                count(wedding_alcohol.id) = count(beverage_alcohol.alcohol_id)
            '
        );

        return $this;
    }

    public function random($wedding, $alcoholId, $mixerId, $typeId)
    {
        $this->forWedding($wedding);
        $this->join('LEFT JOIN', 'beverage_alcohol as ba', 'beverage.id = ba.beverage_id');
        $this->join('LEFT JOIN', 'alcohol as alc', '(ba.alcohol_id = alc.id) OR (ba.alcohol_id = alc.parent_id)');
        $this->joinWith(['mixers', 'type']);

        $this->andFilterWhere(['alc.id' => $alcoholId]);
        $this->andFilterWhere(['mixer.id' => $mixerId]);
        $this->andFilterWhere(['beverage_type.id' => $typeId]);
        $this->addOrderBy('RAND()');

        return $this;
    }
}
