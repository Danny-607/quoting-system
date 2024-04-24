<?php


namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;

class QuoteCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage('/login');
        $I->see('Email Address');
        $I->fillField('email', "admin@admin.com");
        
        $I->see('Password');
        $I->fillField('password', "password");
        $I->click('Login');
    }

    public function createQuote(AcceptanceTester $I){
        $I->amOnPage('quotes/create');
        $I->selectOption('select[name="services[]"]', 'Web Development - $1000');
        $I->fillField('textarea[name="description"]', 'Test');
        $I->click('submit');

        // $I->seeCurrentUrlEquals('/quotes');
        $I->seeInDatabase('quotes', ['description' => 'Test']);
        $I->seeInDatabase('quote_services', ['quote_id' => '1', 'service_id' => '16']);

    }
}
