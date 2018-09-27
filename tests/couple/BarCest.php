<?php

class BarCest
{
    private $cest;

    public function _before(AcceptanceTester $I)
    {
        $this->cest = new AuthCest();
        $this->cest->signIn($I);
    }

    public function _after(AcceptanceTester $I)
    {
    }

    // tests
    public function index(AcceptanceTester $I)
    {
        $I->wantTo('see the list of drink categories');
        $I->amOnPage('couple/bar/index');
    }
}