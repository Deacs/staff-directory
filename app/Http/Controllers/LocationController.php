<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use DB;
use App\Location;
use Illuminate\Http\Request;
use App\Repositories\LocationRepository;

class LocationController extends Controller
{

	protected $locationRepository;

	public function __construct(LocationRepository $locationRepository)
	{
		$this->locationRepository = $locationRepository;
	}

	public function index()
	{
		return Location::with('departments.lead')->get();
	}

	public function show($slug)
	{
		$location = Location::where('slug', $slug)->firstOrFail();
		return view('location.home')->with('location', $location)->with('departments', $location->departments);
	}

	public function departments($slug)
	{
		return $this->locationRepository->getLocationBySlug($slug);
	}

	public function departmentTeams($slug)
	{
		return $this->locationRepository->getLocationDepartmentTeams($slug);
//		return Location::where('slug', $location)->with('departments.team')->firstOrFail();
	}



	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return bool
	 */
	public function store(Request $request)
	{
		$this->validate($request, [
			'name' 			=> 'required|unique:locations',
			'address' 		=> 'required',
			'telephone' 	=> 'required',
			'lat' 			=> 'required|numeric',
			'lon' 			=> 'required|numeric',
		]);

		// Slug is generated within the UserObserver
		$user = Location::create($request->all());

		return $user;
	}

}
