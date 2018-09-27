<?php

namespace app\modules\couple\models;

use app\modules\couple\components\ReorderAction;

/**
 * Class Vendor
 * @package app\modules\couple\models
 */
class Vendor extends \app\models\Vendor
{
    /**
     * @return array
     */
    public function actions()
    {
        return [
            'reorder' => [
                'class'    => ReorderAction::className(),
                'allQuery' => Wedding::current()->getVendors(),
            ],
        ];
    }

    /**
     * @return bool
     */
    public function beforeValidate()
    {
        $this->website = $this->addScheme($this->website);

        return parent::beforeValidate();
    }

    /**
     * @param bool $insert
     *
     * @return bool
     */
    public function beforeSave($insert)
    {
        if ($insert) {
            $this->order = static::find()->count() + 1;
        }

        return parent::beforeSave($insert);
    }

    /**
     * @param        $url
     * @param string $scheme
     *
     * @return string
     */
    private function addScheme($url, $scheme = 'http://')
    {
        return parse_url($url, PHP_URL_SCHEME) === null ?
            $scheme . $url : $url;
    }
}