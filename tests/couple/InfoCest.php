<?php

class InfoCest
{
    public function _before(AcceptanceTester $I)
    {
        (new AuthCest())->signIn($I);

        $I->amOnPage('couple/info/index');

        $I->see('Welcome Screen Picture');
        $I->see('Password Settings');
    }

    public function _after(AcceptanceTester $I)
    {
    }

    // tests
    public function index(AcceptanceTester $I)
    {
        $I->wantTo('open the index page and make sure it works');
    }

    public function save(AcceptanceTester $I)
    {
        $I->wantTo('change some parameters and save them');

        $I->fillField('Groom Last Name', 'Orange');
        $I->fillField('Bride Last Name', 'Apple');
        $I->click('Save');
    }

//    public function clear(AcceptanceTester $I)
//    {
//        $I->click('Clear', '.confirm-delete');
//        $I->see('Are you sure?');
//        $I->seeLink('Yes, please!');
//    }
}