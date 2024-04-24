<?php


namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;

class ProjectCest
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
    public function submitCreateProjectForm(AcceptanceTester $I)
    {
        // Navigate to the page where the form is located
        $I->amOnPage('/projects/1/create');
        // Check if the form is loaded correctly
        $I->see('Create Project', 'h1');
        $I->seeElement('form');
        $I->see('User Name');
        $I->seeElement('input', ['name' => 'start_date']);
        $I->seeElement('input', ['name' => 'expected_end_date']);
        $I->seeElement('textarea', ['id' => 'services']);

        // Fill in the form fields
        $I->fillField('input[name="start_date"]', '2024-04-13');
        $I->fillField('input[name="expected_end_date"]', '2024-04-14');

        // If there are other fields like employees, fill them too
        $I->selectOption('select[name="employees[]"]', 'admin');
        // $I->selectOption('select[name="employees[]"]', 'manager');

        // Submit the form
        $I->click('Create Project');
        // Assert that we are redirected to the correct page after form submission
        $I->seeCurrentUrlEquals('/projects'); // Adjust the URL as needed
    }
}
