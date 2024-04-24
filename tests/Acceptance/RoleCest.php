<?php


namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;

class RoleCest
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
    public function testRoles(AcceptanceTester $I)
    {
        $I->amOnPage('/dashboard/admin');
        $I->see('Admin Dashboard');

        $I->click('Create a new role');
        $I->seeCurrentUrlEquals('/roles/create');
        
        $I->fillField('name', 'example_role');
        $I->checkOption('#permission_1');
        $I->click('Create Role');
        
        $I->seeInDatabase('roles', ['name' => 'example_role']);
    }
}
