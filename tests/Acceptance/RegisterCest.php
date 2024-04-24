<?php


namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;

class RegisterCest
{
    public function testRegistration(AcceptanceTester $I){
        $I->amOnPage('/register');

        $I->see('First Name');
        $I->fillField('first_name','Testfirstname');

        $I->see('Last Name');
        $I->fillField('last_name', 'Testlastname');

        $I->see('Phone Number');
        $I->fillField('phone_number','12345678901');

        $I->see('Email Address');
        $I->fillField('email', 'tester@tester.com');

        $I->see('Password');
        $I->fillField('password', 'password');

        $I->see('Confirm Password');
        $I->fillField('password_confirmation', 'password');

        $I->click('Register');
    }
}
