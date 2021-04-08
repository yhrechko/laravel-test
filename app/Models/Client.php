<?php

namespace App\Models;

use Carbon\Carbon;
use GoogleMaps\Facade\GoogleMapsFacade;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class Client extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'address_1',
        'address_2',
        'city',
        'state',
        'country',
        'zip',
        'phone_1',
        'phone_2',
    ];

    public $sortable = [
        'id',
        'name',
        'address_1',
        'address_2',
        'city',
        'state',
        'country',
        'latitude',
        'longitude',
        'phone_1',
        'phone_2',
        'zip',
        'start_validity',
        'end_validity',
        'status',
        'created_at',
        'updated_at',
    ];

    public $filterable = [
        'id',
        'name',
        'address_1',
        'address_2',
        'city',
        'state',
        'country',
        'latitude',
        'longitude',
        'phone_1',
        'phone_2',
        'zip',
        'start_validity',
        'end_validity',
        'status',
        'created_at',
        'updated_at',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($query) {
            $query->start_validity = $query->start_validity ?? Carbon::now();
            $query->end_validity = $query->end_validity ?? Carbon::now()->addDays(15);
        });
    }

    public function getFullAddressAttribute()
    {
        return $this->country . ' ' . $this->state . ' ' . $this->city . ' ' . $this->address_1;
    }

    public function getTotalUserAttribute()
    {
        return [
            'all' => $this->users()->count(),
            'active' => $this->activeUsers()->count(),
            'inactive' => $this->inactiveUsers()->count(),
        ];
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function activeUsers(): HasMany
    {
        return $this->users()->where(['status' => 'Active']);
    }

    public function inactiveUsers(): HasMany
    {
        return $this->users()->where(['status' => 'Inactive']);
    }

    public function fillGeocodingData()
    {
        $geoData = Cache::rememberForever($this->full_address, function () {
            $geoData = GoogleMapsFacade::load('geocoding')
                ->setParam(['address' => $this->full_address])
                ->get();

            return json_decode($geoData, true);
        });

        if (count($geoData['results']) > 0) {
            $coordinates = $geoData['results'][0]['geometry']['location'];

            $this->latitude = $coordinates['lat'];
            $this->longitude = $coordinates['lng'];
        }

        return $this;
    }
}
