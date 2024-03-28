<?php


namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;

class CreateServiceCest
{
    public function _before(AcceptanceTester $I)
    {
        // Any setup you may need before each test
    }

    public function _after(AcceptanceTester $I)
    {
        // Any teardown you may need after each test
    }

    // Test submitting the form with valid data
    public function submitFormWithValidData(AcceptanceTester $I)
    {
        $I->amOnPage('/services/create');

        $I->see('Enter the name of the service');
        $I->fillField('name', 'Web Development');
        $I->see('Enter the price of the service');
        $I->fillField('price', '1000');

        $I->click('Save a new service');

        // Assuming you are redirecting to a different page after successful form submission
        $I->seeCurrentUrlEquals('/services'); // Adjust the URL as per your application

    }

    // Test submitting the form with invalid data
    public function submitFormWithInvalidData(AcceptanceTester $I)
    {
        $I->amOnPage('/services/create');

        // Leave both fields empty
        $I->click('Save a new service');

        // Assert that the form is not submitted and stays on the same page
        $I->seeCurrentUrlEquals('/services/create');

        // Optionally, you can also check for validation error messages displayed on the page
        $I->see('The name field is required.');
        $I->see('The price field is required.');
    }
}
