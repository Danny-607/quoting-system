<?php


namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;

class CategoryCest
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
    public function createServiceCategory(AcceptanceTester $I){
        $I->amOnPage('/categories/create');
        $I->see('Create Category');

        $I->fillField('name', 'Test service category');
        $I->selectOption('type', 'Service');

        $I->click('Create Category');

        $I->seeInDatabase('service_categories', ['name'=>'Test service category']);
    }

    public function createRunningCostCategory(AcceptanceTester $I){
        $I->amOnPage('/categories/create');
        $I->see('Create Category');

        $I->fillField('name', 'Test running cost category');
        $I->selectOption('type', 'Running Costs');

        $I->click('Create Category');

        $I->seeInDatabase('running_cost_categories', ['name'=>'Test running cost category']);
    }
}
