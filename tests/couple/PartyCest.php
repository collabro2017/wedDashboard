<?php
use \AcceptanceTester;

class PartyCest
{
    public function _before(AcceptanceTester $I)
    {
        (new AuthCest())->signIn($I);

        $I->amOnPage('couple/party/index');
    }

    public function _after(AcceptanceTester $I)
    {
    }

    public function index(AcceptanceTester $I)
    {
        $I->wantTo('see the list of participants');
    }
}