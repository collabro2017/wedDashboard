<?php

class FoodCest
{
    public function _before(AcceptanceTester $I)
    {
        (new AuthCest())->signIn($I);

        $I->amOnPage('couple/food/index');
    }

    public function _after(AcceptanceTester $I)
    {
    }

    public function index(AcceptanceTester $I)
    {
        $I->wantTo('see the list of food categories');
    }
}