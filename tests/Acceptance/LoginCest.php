<?php


namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;

class LoginCest
{
    public function testLogin(AcceptanceTester $I)
    {
        $I->amOnPage('/login');
        $I->see('Email Address');
        $I->fillField('email', "admin@admin.com");
        
        $I->see('Password');
        $I->fillField('password', "password");
        $I->click('#login');
        $I->see('AFFORDABLE WEB DESIGN');
    }
}
