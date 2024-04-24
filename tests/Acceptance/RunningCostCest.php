<?php


namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;

class RunningCostCest
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
    public function createRunningCost(AcceptanceTester $I)
    {
        $I->amOnPage('/runningcosts/create');
        $I->see('Name');
        $I->see('Cost');
        $I->see('Date Incurred');
        $I->see('Category');
        $I->see('Repeating');
    
        $I->fillField('name', 'Electricity Bill');
        $I->fillField('cost', '200.00');
        $I->fillField('date_incurred', '2024-04-01');
        $I->selectOption('select[name="category"]', '1');
        $I->checkOption('repeating');
    
        $I->click('Submit');
        $I->seeInDatabase('running_costs', ['name' => 'Electricity Bill', 'cost' => '200.00', 'category_id' => '1', 'repeating' => '1']);
    }
    
    public function editRunningCost(AcceptanceTester $I)
    {
        $I->amOnPage('/runningcosts');
        $I->see('Expense');
        $I->see('Cost');
        $I->see('Date Incurred');
        $I->see('Category');
        $I->see('Repeating');
        $I->see('Actions');
        $I->see('Edit');
        $I->see('Delete');
    
        $I->click('Edit');
        $I->seeCurrentUrlEquals('/runningcosts/1/edit');
        $I->see('Name');
        $I->fillField('name', 'Updated Electricity Bill');
        $I->fillField('cost', '250.00');
        $I->fillField('date_incurred', '2024-04-10');
        $I->selectOption('select[name="category"]', '2');
        $I->uncheckOption('repeating');
    
        $I->click('Update Running Cost');
    
        $I->seeInDatabase('running_costs', ['name' => 'Updated Electricity Bill', 'cost' => '250.00', 'category_id' => '2', 'repeating' => '0']);
    }
    
    public function deleteRunningCost(AcceptanceTester $I)
    {
        $I->amOnPage('/runningcosts');
        $I->see('Expense');
        $I->see('Cost');
        $I->see('Date Incurred');
        $I->see('Category');
        $I->see('Repeating');
        $I->see('Actions');
        $I->see('Edit');
        $I->see('Delete');
    
        $I->click('Delete');
        $I->dontSeeInDatabase('running_costs', ['name' => 'Updated Electricity Bill', 'cost' => '250.00', 'category_id' => '2', 'repeating' => '0']);
    }
    
    // tests

}
