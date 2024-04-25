<?php


namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;

class ManagerCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage('/login');
        $I->see('Email Address');
        $I->fillField('email', "manager@manager.com");
        
        $I->see('Password');
        $I->fillField('password', "password");
        $I->click('#login');
    }

    public function testDashboardPage(AcceptanceTester $I)
    {
        $I->amOnPage('/dashboard/manager'); 

        // Assert the presence of the Manager's Dashboard title
        $I->see('Dashboard', 'h1');

        $I->see('Profit', 'h2');
        // Assert the presence of profit information
        $I->see('Profit for April 2024', 'h3');
        $I->see('Total Profit: ', 'p');

        // Assert the presence of profit from previous months
        $I->see('Profit from Previous Months', 'h3');

        // Assert the presence of recent ongoing projects and assigned employees
        $I->see('Ongoing Projects', 'h2');

        

        // Assert the presence of recent completed projects and assigned employees
        $I->see('Recently Completed Projects', 'h2');


        // Assert the presence of running costs information
        $I->see('Running Costs', 'h2');
        $I->see('Repeating Costs', 'h3');
        $I->see('Non-Repeating Costs', 'h3');
    }
}
