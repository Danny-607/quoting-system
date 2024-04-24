<?php


namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;

class EmployeeCest
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

    // tests
    public function createEmployee(AcceptanceTester $I){
        $I->amOnPage('/employees/create');
        $I->see('Select the user you want to assign to an employee');
        $I->selectOption('select[name="user_name"]', 'admin');
        $I->see('Weekly contracted hours');
        $I->fillField('contracted_hours', '40');
        $I->see('Hourly or salary');
        $I->selectOption('select[name="wage_type"]', 'Salary' );
        $I->see('Wages');
        $I->fillField('wages', '30000');

        $I->click('Submit');
        $I->seeInDatabase('employees', ['user_id' => '1', 'contracted_hours' => '40','wage_type' => 'salary','wage_amount' => '30000']);
    }

    public function editEmployee(AcceptanceTester $I){
        $I->amOnPage('/employees');
        $I->see('User Name');
        $I->see('Contracted Hours');
        $I->see('Wage Type');
        $I->see('Wages');
        $I->see('Actions');
        $I->see('Edit');
        $I->see('Delete');

        $I->click('Edit');
        $I->seeCurrentUrlEquals('/employees/1/edit');
        $I->see('Contracted Hours');
        $I->fillField('contracted_hours', '50');
        $I->see('Wage Type');
        $I->selectOption('select[name="wage_type"]', 'Hourly' );
        $I->see('Wages');
        $I->fillField('wage_amount', '10');

        $I->click('Update Employee');

        $I->seeInDatabase('employees', ['user_id' => '1', 'contracted_hours' => '50','wage_type' => 'hourly','wage_amount' => '10']);

    }
    public function deleteEmployee(AcceptanceTester $I){
        $I->amOnPage('/employees');
        $I->see('User Name');
        $I->see('Contracted Hours');
        $I->see('Wage Type');
        $I->see('Wages');
        $I->see('Actions');
        $I->see('Edit');
        $I->see('Delete');

        $I->click('Delete');
        $I->dontSeeInDatabase('employees', ['user_id' => '1', 'contracted_hours' => '50','wage_type' => 'hourly','wage_amount' => '10']);
    }


}
