<?php


namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;

class UserCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage('/login');
        $I->see('Email Address');
        $I->fillField('email', "admin@admin.com");
        
        $I->see('Password');
        $I->fillField('password', "password");
        $I->click('#login');
    }

    // tests
    public function submitCreateFormWithValidData(AcceptanceTester $I){
        $I->amOnPage('/users/create');
        $I->fillField('first_name', 'Test');

        $I->fillField('last_name', 'Test');
        $I->fillField('phone_number', '12345678910');
        $I->fillField('email', 'test@test.com');
        $I->fillField('password', 'password');

        $I->selectOption('select[name="role"]', 'admin');

        $I->click('Create User');
        $I->seeInDatabase('users', ['first_name' => 'Test', 'last_name' => 'Test','phone_number' => '12345678910','email' => 'test@test.com']);
    }
    public function submitCreateFormWithEmptyData(AcceptanceTester $I){
        $I->amOnPage('/users/create');

        // Leave both fields empty
        $I->click('Create User');

        // Assert that the form is not submitted and stays on the same page
        $I->seeCurrentUrlEquals('/users/create');

        $I->see('The first name field is required.');
        $I->see('The last name field is required.');
        $I->see('The phone number field is required.');
        $I->see('The email field is required.');
        $I->see('The password field is required.');


        
    }


}
