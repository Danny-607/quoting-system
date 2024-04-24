<?php


namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;

class ManagerCest
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

    public function testDashboardPage(AcceptanceTester $I)
    {
        $I->amOnPage('/dashboard/manager'); 

        // Assert the presence of the Manager's Dashboard title
        $I->see('Manager\'s Dashboard', 'h2');

        // Assert the presence of profit information
        $I->see('Profit for', 'h3');
        $I->see('Total Profit', 'p');

        // Assert the presence of profit from previous months
        $I->see('Profit from Previous Months', 'h3');

        // Assert the presence of recent ongoing projects and assigned employees
        $I->see('Recent Ongoing Projects and Assigned Employees', 'h3');

        

        // Assert the presence of recent completed projects and assigned employees
        $I->see('Recent Completed Projects and Assigned Employees', 'h3');


        // Assert the presence of running costs information
        $I->see('This Months Running Costs', 'h3');
        $I->see('Repeating Costs', 'p');
        $I->see('Non-Repeating Costs', 'p');
    }
}
