<?php

namespace App\Repositories\Backend\Meter;

use App\Models\Meter\Meter;
use App\Models\Region\Region;
use App\Models\Township\Township;
use App\Models\District\District;
use App\Models\VillageTract\VillageTract;
use App\Models\Community\Community;
use App\Models\Street\Street;
use Illuminate\Support\Facades\DB;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserRepository.
 */
class MeterRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = Meter::class;

    /**
     * @param int  $status
     * @param bool $trashed
     *
     * @return mixed
     */
    public function getForDataTable($order_by = 'created_at', $sort = 'desc',$trashed = false)
    {
        $dataTableQuery = $this->query()
            ->orderBy($order_by, $sort)
            ->select('*');

        if ($trashed == 'true') {
            return $dataTableQuery->onlyTrashed();
        }
        return $dataTableQuery;
    }

    /**
     * @param array $input
     */
    public function create($input)
    {
        $data = $input['data'];

        $meter = $this->createMeterStub($data);
        DB::transaction(function () use ($meter, $data) {
            if ($meter->save()) {
                 \Log::info('Meter'.$meter->id.' was created by ' . access()->user()->name );
                return true;
            }

            throw new GeneralException(trans('exceptions.backend.meter.create_error'));
        });
    }

    /**
     * @param Model $meter
     * @param array $input
     *
     * @return bool
     * @throws GeneralException
     */
    public function update(Model $meter, array $input)
    {
        $data = $input['data'];

        $meter->owner_id = $data['owner_id'];
        $meter->meter_no = $data['meter_no'];
        $meter->qrcode =$data['qrcode'];
        $meter->meter_type = $data['meter_type'];
        $meter->register_date = date('Y-m-d',strtotime($data['register_date']));
        $meter->status = $data['status'];
        $meter->region_id = $data['region_id'];
        $meter->township_id = $data['township_id'];
        $meter->district_id = $data['district_id'];
        $meter->village_tract_id = $data['village_tract_id'];
        $meter->community_id = $data['community_id'];
        $meter->street_id = $data['street_id'];
        $meter->address = $data['address'];
        $meter->latitude = $data['latitude'];
        $meter->longitude = $data['longitude'];
        $meter->created_by = access()->user()->id;
        $meter->updated_by = access()->user()->id;  

        DB::transaction(function () use ($meter, $data) {
            if ($meter->save()) {
                 \Log::info('Meter'.$meter->id.' was updated by ' . access()->user()->name );
                return true;
            }

            throw new GeneralException(trans('exceptions.backend.meter.update_error'));
        });
    }

    /**
     * @param Model $meter
     *
     * @throws GeneralException
     *
     * @return bool
     */
    public function delete(Model $meter)
    {
        if ($meter->delete()) {
             \Log::info('Meter'.$meter->id.' was deleted by ' . access()->user()->name );
            return true;
        }
        throw new GeneralException(trans('exceptions.backend.meter.delete_error'));
    }

    /**
     * @param int $id
     *
     * @throws GeneralException
     */

    public function forceDelete($id = null)
    {
        Meter::onlyTrashed()->where('id', $id)->forceDelete();
         \Log::info('Meter'.$id.' was permanently deleted by ' . access()->user()->name );
    }

    /**
     * @param  $input
     *
     * @return mixed
     */
    protected function createMeterStub($input)
    {
        $meter = self::MODEL;
        $meter = new $meter;
        $meter->owner_id = $input['owner_id'];
        $meter->meter_no = $input['meter_no'];
        $meter->qrcode =   $input['qrcode'];
        $meter->meter_type = $input['meter_type'];
        $meter->register_date = date('Y-m-d',strtotime($input['register_date']));
        $meter->status = $input['status'];
        $meter->region_id = $input['region_id'];
        $meter->township_id = $input['township_id'];
        $meter->district_id = $input['district_id'];
        $meter->village_tract_id = $input['village_tract_id'];
        $meter->community_id = $input['community_id'];
        $meter->street_id = $input['street_id'];
        $meter->address = $input['address'];
        $meter->latitude = $input['latitude'];
        $meter->longitude = $input['longitude'];
        $meter->created_by = access()->user()->id;
        $meter->updated_by = access()->user()->id;  

        return $meter;
    }

     /**
     * @param int $id
     *
     *
     * @return bool
     */

    public function restore($id = null)
    {
        if ($id) {
            Meter::onlyTrashed()->where('id', $id)->restore();
            \Log::info('meter'.$id.' was restored by ' . access()->user()->name );
        } else {
            Meter::onlyTrashed()->restore();
            \Log::info('All deleted meters were restored by ' . access()->user()->name );
        }
    }


    public function getDistrictData($id)
    {
        $district = District::with('region')->where('region_id',$id)->get();
        return $district;
    }

    public function getTownshipData($id)
    {
        $township = Township::with('district')->get();
        return $township;
    }

    public function getVillageData($id)
    {
        $township = VillageTract::with('township')->get();
        return $township;
    }

    public function getCommunityData($id)
    {
        $villages = Community::with('village')->get();
        return $villages;
    }

    public function getStreetData($id)
    {
        $street = Street::with('community')->where('community_id',$id)->get();
        return $street;
    }

    public function saveMeterApi($data, $member)
    {
        $meter = new Meter();
        $meter->owner_id = $data['owner_id'];
        $meter->meter_no = $data['meter_no'];
        $meter->qrcode =$data['qrcode'];
        $meter->meter_type = $data['meter_type'];
        $meter->register_date = date('Y-m-d',strtotime($data['register_date']));
        $meter->status = $data['status'];
        $meter->region_id = $data['region_id'];
        $meter->township_id = $data['township_id'];
        $meter->district_id = $data['district_id'];
        $meter->village_tract_id = $data['village_tract_id'];
        $meter->community_id = $data['community_id'];
        $meter->street_id = $data['street_id'];
        $meter->address = $data['address'];
        $meter->latitude = $data['latitude'];
        $meter->longitude = $data['longitude'];
        $meter->created_by = $member->id;
        $meter->updated_by = $member->id; 

        return $meter;
    }

    public function updateMeterApi($id,$data, $member)
    {
        $meter = Meter::find($id);

        $meter->owner_id = $data['owner_id'];
        $meter->meter_no = $data['meter_no'];
        $meter->qrcode =$data['qrcode'];
        $meter->meter_type = $data['meter_type'];
        $meter->register_date = date('Y-m-d',strtotime($data['register_date']));
        $meter->status = $data['status'];
        $meter->region_id = $data['region_id'];
        $meter->township_id = $data['township_id'];
        $meter->district_id = $data['district_id'];
        $meter->village_tract_id = $data['village_tract_id'];
        $meter->community_id = $data['community_id'];
        $meter->street_id = $data['street_id'];
        $meter->address = $data['address'];
        $meter->latitude = $data['latitude'];
        $meter->longitude = $data['longitude'];
        $meter->created_by =  $member->id;
        $meter->updated_by =  $member->id; 

        return $meter;
    }

    public function getMeter($id)
    {
        $meter = Meter::find($id);
        return $meter;
    } 

    public function getCivilServantMeter($department_id)
    {
        $meter = Meter::join('departments','departments.region_id','meters.region_id')
                ->where('departments.id',$department_id)
                ->get();
        return $meter;
    } 

    public function getOwnersMeterList($id)
    {
        $meter = Meter::where('owner_id',$id)->where('deleted_at',null)->select('meter_no','owner_id','qrcode','meter_type','register_date','status','region_id','district_id','township_id','village_tract_id','community_id','street_id','address','latitude','longitude')->get();
        return $meter;
    }
}
