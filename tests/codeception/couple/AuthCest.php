<?php

class AuthCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    public function _after(AcceptanceTester $I)
    {
    }

    public function signIn(AcceptanceTester $I)
    {
        $I->wantTo('log in as a bride or groom');
        $I->amOnPage('couple/default/sign-in');
        $I->see('Admin Login');

        $code = 'FUGIT';

        $I->fillField('Wedding ID', $code);
        $I->fillField('Admin Email', 'm@h.com');
        $I->fillField('Admin Password', '123');
        $I->click('SIGN IN');

        $I->seeInCurrentUrl('/couple/info/index');
        $I->see('WEDDING INFO');
        $I->see($code);
        $I->see('Logout');
    }

    /**
     * @param AcceptanceTester $I
     */
    public function register(AcceptanceTester $I)
    {
        $I->wantTo('register a new wedding');
        $I->amOnPage('couple/default/register');
        $I->see('Create New Wedding');

        $faker = Faker\Factory::create();

        $weddingDate = $faker->dateTimeBetween( '2016-08-09', '2018-04-07')->format('Y-m-d');
        $weddingCode = strtoupper($faker->word.$faker->year);
        $brideFirstName = $faker->firstName;
        $brideLastName = $faker->lastName;
        $groomFirstName = $faker->firstName;
        $groomLastName = $faker->lastName;
        $adminEmail = $faker->email;

        // Set up all fields
        $I->fillField('Wedding ID', $weddingCode);
        $I->fillField('Bride\'s First Name', $brideFirstName);
        $I->fillField('Bride\'s Last Name', $brideLastName);
        $I->fillField('Groom\'s First Name', $groomFirstName);
        $I->fillField('Groom\'s Last Name', $groomLastName);
        $I->fillField('Wedding Date', $weddingDate);
        $I->fillField('Admin Email', $adminEmail);
        $I->fillField('Admin Password', $faker->password);
        $I->click('Create Wedding Now!');

        $I->see('WEDDING INFO');
        $I->seeInField('Bride First Name', $brideFirstName);
        $I->seeInField('Bride Last Name', $brideLastName);
        $I->seeInField('Groom First Name', $groomFirstName);
        $I->seeInField('Groom Last Name', $groomLastName);
        $I->seeInField('Admin Email', $adminEmail);
        $I->see('Logout');
    }

    public function logout(AcceptanceTester $I)
    {
        $this->signIn($I);
        $I->wantTo('logout');
        $I->amOnPage('couple/info/index');

        $I->see('Logout');
        $I->click('Logout');
    }
}