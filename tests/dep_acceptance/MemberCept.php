<?php

$I = new AcceptanceTester($scenario);

$I->am('a member');
$I->wantTo('view my own page and view the correct data');

$I->amOnPage('/member/tom-leigh');
$I->see('Tom Leigh');
$I->see('Business Development Manager');
$I->see('tom.leigh@crowdcube.com');
