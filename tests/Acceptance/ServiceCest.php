<?php


namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;

class ServiceCest
{
    // Logging in the correct account before accessing the page 
    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage('/login');
        $I->see('Email Address');
        $I->fillField('email', "admin@admin.com");
        
        $I->see('Password');
        $I->fillField('password', "password");
        $I->click('#login');
    }


    // Test submitting the services create form with valid data
    public function submitFormWithValidData(AcceptanceTester $I)
    {
        $I->amOnPage('/services/create');

        $I->see('Enter the name of the service');
        $I->fillField('name', 'Web Development');
        $I->see('Enter the cost of the service');
        $I->fillField('cost', '500');
        $I->see('Enter the price of the service');
        $I->fillField('price', '1000');

        $I->click('Save a new service');

        $I->seeInDatabase('services', ['name' => 'Web Development', 'cost'=>'500', 'price' => '1000']);
        $I->seeCurrentUrlEquals('/services'); 

    }

    // Test submitting the services create form with invalid data
    public function submitFormWithInvalidData(AcceptanceTester $I)
    {
        $I->amOnPage('/services/create');

        // Leave both fields empty
        $I->click('Save a new service');

        // Assert that the form is not submitted and stays on the same page
        $I->seeCurrentUrlEquals('/services/create');

        $I->see('The name field is required.');
        $I->see('The cost field is required.');
        $I->see('The price field is required.');
    }
    public function editService(AcceptanceTester $I){
        $I->amOnPage('/services');
        // Looks for the record in the table
        $I->see('Edit');
        // Clicks the edit button of the top record
        $I->click('Edit');
        // Checks that the fields are on the edit page
        $I->see('Name');
        $I->fillField('name', 'Testing2');
        $I->see('Cost');
        $I->fillField('cost', '400');
        $I->see('Price');
        $I->fillField('price', '700');
        $I->see('Update Service');

        
        
       
        $I->click('Update Service');
        // Checks that the redirect is to the correct page
        $I->seeCurrentUrlEquals('/services');
        // Checks the database that the record has been updated
        $I->seeInDatabase('services', ['name' => 'Testing2', 'cost' => '400', 'price' => '700']);
        
        
    }
    // Test index page of the admin section 
    public function deleteService(AcceptanceTester $I){
        $I->amOnPage('/services');
        // Checks that the record is in the table
        $I->see('Edit');
        // $I->see('Delete');
        // Clicks the delete button for the first record in the table. 
        $I->click('delete');
        // Checks the database to see that the record is deleted 
        $I->dontSeeInDatabase('services', ['name' => '5 pages']);
}


}
