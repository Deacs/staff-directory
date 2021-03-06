<?php namespace App;

use App\Location as Location;
use Illuminate\Database\Eloquent\Model;

class Department extends Model {

	protected $table = 'departments';

	protected $name;

	protected $appends = [
		'url'
	];

	protected $fillable = [
		'name',
		'slug',
		'location_id',
		'lead_id'
	];

	protected $casts = [
		'lead_id' 		=> 'integer',
		'location_id' 	=> 'integer'
	];

	const ENGINEERING 			= 1;
	const MARKETING 			= 2;
	const INVESTMENTS 			= 3;
	const PRODUCT 				= 4;
	const COMPLETIONS 			= 5;
	const FINANCE 				= 6;
	const LEGAL 				= 7;
	const BONDS 				= 8;
	const BUSINESS_DEVELOPMENT 	= 9;

	public function location()
	{
		return $this->belongsTo('App\Location');
	}

	public function team()
	{
		return $this->hasMany('App\User');
	}

	public function lead()
	{
		return $this->hasOne('App\User', 'id', 'lead_id');
	}

	public function org_charts()
	{
		return $this->hasMany('App\OrgChart');
	}

	public function scopeExeter($query)
	{
		return $query->where('location_id', Location::EXETER_ID);
	}

	public function scopeLondon($query)
	{
		return $query->where('location_id', Location::LONDON_ID);
	}

	public function scopeScotland($query)
	{
		return $query->where('location_id', Location::SCOTLAND_ID);
	}

	public function scopeManchester($query)
	{
		return $query->where('location_id', Location::MANCHESTER_ID);
	}

	public function scopeBarcelona($query)
	{
		return $query->where('location_id', Location::BARCELONA_ID);
	}

	public function getUrlAttribute()
	{
		return '/departments/'.$this->slug;
	}

	/**
	 * Has an Organisational Chart been uploaded for this Department
	 *
	 * @return boolean
	 */
	public function hasOrgChart()
	{
		return !is_null($this->org_charts()->first());
	}

	/**
	 * Return the Organisational Chart for this Department
	 *
	 * @return string
	 */
	public function getOrgChart()
	{
		return $this->org_charts()->latest()->first();

	}
}
