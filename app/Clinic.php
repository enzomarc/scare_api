<?php
	
	namespace App;
	
	use Illuminate\Database\Eloquent\Model;
	
	class Clinic extends Model
	{
		/**
		 * The attributes that are mass assignable.
		 *
		 * @var array
		 */
		protected $fillable = [
			'name', 'country', 'region', 'city', 'phone', 'email', 'logo', 'active'
		];
		
		/**
		 * Get the clinic users.
		 *
		 * @return \Illuminate\Database\Eloquent\Relations\HasMany
		 */
		public function users()
		{
			return $this->hasMany(User::class, 'clinic');
		}
	}
