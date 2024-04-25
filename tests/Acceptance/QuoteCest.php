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
        $I->click('#login');
    }

    public function createQuote(AcceptanceTester $I){
        $I->wantTo('ensure that Get a Quote page works');
        $I->amOnPage('/quotes/create'); // Adjust URL as per your routes.

        $I->see('Select from a wide range of services', 'h2');
        $I->seeElement('input', ['name' => 'services[]']);

        // Simulate selecting a few services
        $I->checkOption('//input[@value="1"]');
        $I->checkOption('//input[@value="2"]');

        // Add some additional information
        $I->fillField('#description', 'Test');

        // Submit the form
        $I->click('Submit');

        // Assuming a redirect and a success message on the next page
        $I->seeCurrentUrlEquals('/quotes');

        // $I->seeCurrentUrlEquals('/quotes');
        $I->seeInDatabase('quotes', ['description' => 'Test']);
        $I->seeInDatabase('quote_services', ['quote_id' => '2', 'service_id' => '1']);

    }
    
    public function editQuote(AcceptanceTester $I){
        $I->amOnPage('/quotes');

        $I->see('Accept');
        $I->see('Deny');
        $I->see('Edit');

        $I->click('Edit');

        $I->seeCurrentUrlEquals('/quotes/1/edit');

        $I->fillField('description', '123');
        $I->click('Update Quote');
        $I->seeInDatabase('quotes', ['description' => '123']);
    }
    public function acceptQuote(AcceptanceTester $I){
        $I->amOnPage('/quotes');

        $I->see('Accept');
        $I->see('Deny');
        $I->see('Edit');

        $I->click('Accept');

        $I->seeCurrentUrlEquals('/projects/1/create');

        $I->fillField('start_date', '2024-04-10');
        $I->fillField('expected_end_date', '2024-04-11');
        $I->click('Create Project');
        $I->seeInDatabase('projects', ['start_date' => '2024-04-10', 'expected_end_date'=> '2024-04-11']);
    }
    public function denyQuote(AcceptanceTester $I){
        $I->amOnPage('/quotes');

        $I->see('Accept');
        $I->see('Deny');
        $I->see('Edit');

        $I->click('Deny');

        $I->dontSeeInDatabase('quotes', ['id' =>'2']);
    }
}
