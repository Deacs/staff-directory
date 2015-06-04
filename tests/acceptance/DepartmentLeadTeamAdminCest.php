<?php
use \AcceptanceTester;

class DepartmentLeadTeamAdminCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->loginEngineeringLeadUser($I);
        $I->am('Engineering Lead');
    }

    public function _after(AcceptanceTester $I)
    {
    }

    public function seeTeamMembers(AcceptanceTester $I)
    {
        $I->amOnPage('/department/engineering');
        $I->see('David Ives', '.member-link');
        $I->see('Rob Crowe', '.member-link');
        $I->see('Ben Christine', '.member-link');
    }

    public function seeHolidayRequestManagementOptions(AcceptanceTester $I)
    {
        $I->amOnPage('/department/engineering');
        $I->seeElement('#team-holiday-status');
        $I->seeElement('a', ['data-balance-type' => 'pending']);
        $I->seeElement('a', ['data-balance-type' => 'approved']);
        $I->seeElement('a', ['data-balance-type' => 'available']);
    }

    public function canViewMemberProfileFromDepartmentListing(AcceptanceTester $I)
    {
        $I->amOnPage('/department/engineering');
        $I->click('Rob Crowe');
        $I->seeCurrentUrlEquals('/member/rob-crowe');
    }

    public function canEmailMemberFromDepartmentListing(AcceptanceTester $I)
    {
        $I->amOnPage('/department/engineering');
        $I->see('rob@crowdcube.com', 'a');
    }

    public function seeHolidayAdministrationOptionsForMembers(AcceptanceTester $I)
    {
        $I->amOnPage('/member/rob-crowe');
        $I->see('No approved holiday requests');
    }

    public function cannotSeeAdministrationOptionsForOtherDepartments(AcceptanceTester $I)
    {
        $I->amOnPage('/department/marketing');
        $I->dontSee('#team-holiday-status');
    }

    public function canSeeAddNewDepartmentMemberForm(AcceptanceTester $I)
    {
        $I->amOnPage('/department/engineering');
        $I->see('Add New Team Member', 'legend');
    }

    public function canSeeCorrectAddNewTeamMemberFormFields(AcceptanceTester $I)
    {
        $I->amOnPage('/department/engineering');
        // Can be written as $I->seeElement('input[name=first_name]');
        $I->seeElement('input', ['name' => 'first_name']);
        $I->seeElement('input', ['name' => 'last_name']);
        $I->seeElement('input', ['name' => 'role']);
        $I->seeElement('input', ['name' => 'email']);
        $I->seeElement('input', ['name' => 'telephone']);
        $I->seeElement('select', ['name' => 'location_id']);
        $I->seeElement('select', ['name' => 'department_id']);
    }

    /**
     * @group new
     */
    public function canCreateNewMemberForEngineeringDepartment(AcceptanceTester $I)
    {
        $I->amOnPage('/department/engineering');
        $I->fillField('first_name', 'Jack');
        $I->fillField('last_name', 'Way');
        $I->fillField('role', 'Front End Engineer');
        $I->fillField('email', 'jack.way@crowdcube.com');
        $I->selectOption('location_id', '1');
        $I->selectOption('department_id', '1');
        $I->click('Add');
        $I->seeCurrentUrlEquals('/department/engineering');
        $I->see('Member Successfully Added', '.success');
    }
}
