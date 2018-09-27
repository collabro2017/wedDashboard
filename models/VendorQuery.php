<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Vendor]].
 *
 * @see Vendor
 */
class VendorQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Vendor[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Vendor|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
