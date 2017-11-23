<?php

namespace App\Models\Meter\Traits\Relationship;
use App\Models\Region\Region;
use App\Models\Township\Township;
use App\Models\District\District;
use App\Models\VillageTract\VillageTract;
use App\Models\Community\Community;
use App\Models\MeterOwner\MeterOwner;

/**
 * Class MeterRelationship.
 */
trait MeterRelationship
{
    /**
     * @return mixed
     */
    public function owner()
    {
        return $this->belongsTo(MeterOwner::class,'owner_id');
    }

    public function region()
    {
        return $this->belongsTo(Region::class,'region_id');
    }

    public function district()
    {
        return $this->belongsTo(District::class,'district_id');
    }

    public function township()
    {
        return $this->belongsTo(Township::class,'township_id');
    }

    public function village()
    {
        return $this->belongsTo(VillageTract::class,'village_tract_id');
    }

    public function community()
    {
        return $this->belongsTo(Community::class,'community_id');
    }
}
