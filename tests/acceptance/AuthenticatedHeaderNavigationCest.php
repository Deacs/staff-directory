<?php
use \AcceptanceTester;

class AuthenticatedHeaderNavigationCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->loginUser($I);
    }

    public function _after(AcceptanceTester $I)
    {
    }

    public function seeUserName(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->see('Tom Leigh');
    }

    public function seeUserOptionsByClickingUserName(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->see('Tom Leigh');
        $I->click('Tom Leigh');
        $I->see('Profile');
        $I->see('Logout');
    }

    public function visitProfileFromUserOptions(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->see('Tom Leigh');
        $I->click('Tom Leigh');
        $I->see('Profile');
        $I->click('Profile');
        $I->seeCurrentUrlEquals('/member/tom-leigh');
    }

    public function canLogoutFromUserOptions(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->see('Tom Leigh');
        $I->click('Tom Leigh');
        $I->see('Logout');
        $I->click('Logout');
        $I->seeCurrentUrlEquals('/');
        $I->see('Successfully logged out', '.success');
        $I->seeElement('.close');
        $I->click(['class' => 'close']);
        $I->dontSee('Successfully logged out', '.success');
    }

    public function seeTeamsOptions(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->see('Teams');
        $I->click('Teams');
        $I->see('Exeter');
        $I->see('London');
        $I->see('Edinburgh');
    }

    public function cantSeeTheMyTeamOption(AcceptanceTester $I)
    {
        $I->dontSeeElement('My Team');
    }
}
