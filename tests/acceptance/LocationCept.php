<?php 
$I = new AcceptanceTester($scenario);
$I->am('a team member');
$I->wantTo('visit the Location home page and see the correct data');

$I->amOnPage('/location/1');
$I->see('Exeter');