<?php

use App\User;
use Illuminate\Http\Request;

Route::group(['middleware' => 'auth'], function() {

	get('/',
		[
			'as' 	=> 'home',
			'uses' 	=> 'ManagerController@index'
		]
	);

	get('directory',
		[
			'as' 	=> 'directory.home',
			'uses' 	=> 'StaffDirectoryController@index'
		]
	);
});

/**
 * Session handling
 */
get('login',
	[
		'as' 	=> 'login.home',
		'uses' 	=> 'LoginController@index'
	]
);

post('login',
	[
		'as' 	=> 'login.attempt',
		'uses' 	=> 'LoginController@authenticate'
	]
);

get('logout',
	[
		'as' 	=> 'logout',
		'uses' 	=> 'LoginController@logout'
	]
);

Route::group(['middleware' => 'auth', 'prefix' => 'departments', 'as' => 'department.'], function () {

	get('/',
		[
			'as' 	=> 'index',
			'uses' 	=> 'DepartmentController@index'
		]
	);

	get('{slug}',
		[
			'as' 	=> 'home',
			'uses' 	=> 'DepartmentController@show'
		]
	);

	get('{slug}/manage',
		[
			'middleware' 	=> 'lead',
			'as' 			=> 'manage',
			'uses' 			=> 'DepartmentController@manage'
		]
	);
});

Route::group(['middleware' => 'auth', 'prefix' => 'member', 'as' => 'member.'], function () {

	get('{slug}',
		[
			'as' 	=> 'home',
			'uses' 	=> 'UserController@show'
		]
	);

	post('add',
		[
			'as' 	=> 'add',
			'uses' 	=> 'UserController@store'
		]
	);

	get('confirm/{token}',
		[
			'as' 	=> 'confirm',
			'uses'	=> 'UserController@confirm'
		]
	);

	post('confirm',
		[
			'as' 	=> 'complete-confirmation',
			'uses' 	=> 'UserController@completeConfirmation'
		]
	);
});

Route::group(['middleware' => 'auth', 'prefix' => 'location', 'as' => 'location.'], function () {

	get('add',
		[
			'as' 			=> 'location.create',
			'uses' 			=> 'LocationController@create',
			//'middleware' 	=> 'superuser',
		]
	);

	post('add',
		[
			'as' 			=> 'add',
			'uses' 			=> 'LocationController@store',
			'middleware' 	=> 'superuser'
		]
	);

	get('{slug}',
		[
			'as' 	=> 'home',
			'uses' 	=> 'LocationController@show'
		]
	);
});

/**
 * API : Powered by VueJS
 */
get('beta', function () {
	return view('beta');
});

Route::group(['prefix' => 'api', 'as' => 'api.'], function () {

	get('location/{location_slug}/departments/teams',
		[
			'as' 	=> 'location.department.teams',
			'uses' 	=> 'LocationController@departmentTeams'
		]
	);

	get('location/{slug}/departments',
		[
			'as' 	=> 'location.departments',
			'uses' 	=> 'LocationController@departments'
		]
	);

	get('locations',
		[
			'as' 	=> 'locations',
			'uses'	=> 'LocationController@index'
		]
	);

	get('departments/{slug}/team',
		[
			'as' 	=> 'department.team',
			'uses' 	=> 'DepartmentController@team'
		]
	);

	get('departments/{slug}',
		[
			'as' 	=> 'department.show',
			'uses' 	=> 'DepartmentController@profile'
		]
	);

	get('departments',
		[
			'as' 	=> 'departments',
			'uses' 	=> 'DepartmentController@listing'
		]
	);

	get('member/{slug}',
		[
			'as' 	=> 'member.show',
			'uses' 	=> 'UserController@profile',
		]
	);

	get('members',
		[
			'as' 	=> 'members',
			'uses' 	=> 'UserController@index'
		]
	);

	post('member/add',
		[
			'as' 	=> 'member.add',
			'uses' 	=> 'UserController@store'
		]
	);

	get('member/holiday-requests',
		[
			'as' 	=> 'member.holiday-requests',
			'uses' 	=> 'UserController@holidayRequests'
		]
	);

	post('holiday/request',
		[
			'as' 	=> 'holiday.request',
			'uses' 	=> 'HolidayRequestController@store'
		]
	);
});

Route::controllers([
	'auth' 		=> 'Auth\AuthController',
	'password' 	=> 'Auth\PasswordController',
]);
