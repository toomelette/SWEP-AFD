<?php

namespace App\Swep\Repositories;
 
use App\Swep\BaseClasses\BaseRepository;
use App\Swep\Interfaces\PermissionSlipInterface;


use App\Models\PermissionSlip;


class PermissionSlipRepository extends BaseRepository implements PermissionSlipInterface {
	



    protected $permission_slip;




	public function __construct(PermissionSlip $permission_slip){

        $this->permission_slip = $permission_slip;
        parent::__construct();

    }





    public function fetchAll($request){

        $key = str_slug($request->fullUrl(), '_');

        $permission_slips = $this->cache->remember('permission_slips:all:' . $key, 240, function() use ($request){

            $permission_slip = $this->permission_slip->newQuery();

            $date = $this->carbon->parse($request->d)->format('Y-m-d');

            if(isset($request->q)){
                $this->search($permission_slip, $request->q);
            }

            if(isset($request->emp)){
                $permission_slip->whereEmployeeNo($request->emp);
            }

            if(isset($request->d)){
                $permission_slip->where('date', $date);
            }

            return $this->populate($permission_slip);

        });

        return $permission_slips;

    }






    public function store($request){

        $permission_slip = new PermissionSlip;
        $permission_slip->slug = $this->str->random(32);
        $permission_slip->ps_id = $this->getPSIdInc();
        $permission_slip->employee_no = $request->employee_no;
        $permission_slip->date =  $this->dataTypeHelper->date_parse($request->date, 'Y-m-d');
        $permission_slip->time_out = $this->dataTypeHelper->time_parse($request->time_out);
        $permission_slip->time_in = $this->dataTypeHelper->time_parse($request->time_in);
        $permission_slip->with_ps = $this->dataTypeHelper->string_to_boolean($request->with_ps);
        $permission_slip->created_at = $this->carbon->now();
        $permission_slip->updated_at = $this->carbon->now();
        $permission_slip->ip_created = request()->ip();
        $permission_slip->ip_updated = request()->ip();
        $permission_slip->user_created = $this->auth->user()->user_id;
        $permission_slip->user_updated = $this->auth->user()->user_id;
        $permission_slip->save();

        return $permission_slip;

    }






    public function update($request, $slug){

        $permission_slip = $this->findBySlug($slug);
        $permission_slip->employee_no = $request->employee_no;
        $permission_slip->date =  $this->dataTypeHelper->date_parse($request->date, 'Y-m-d');
        $permission_slip->time_out = $this->dataTypeHelper->time_parse($request->time_out);
        $permission_slip->time_in = $this->dataTypeHelper->time_parse($request->time_in);
        $permission_slip->with_ps = $this->dataTypeHelper->string_to_boolean($request->with_ps);
        $permission_slip->updated_at = $this->carbon->now();
        $permission_slip->ip_updated = request()->ip();
        $permission_slip->user_updated = $this->auth->user()->user_id;
        $permission_slip->save();

        return $permission_slip;

    }






    public function destroy($slug){

        $permission_slip = $this->findBySlug($slug);
        $permission_slip->delete();

        return $permission_slip;

    }






    public function findBySlug($slug){

        $permission_slip = $this->cache->remember('permission_slips:bySlug:' . $slug, 240, function() use ($slug){
            return $this->permission_slip->where('slug', $slug)->first();
        });

        if(empty($permission_slip)){
            abort(404);
        }
        
        return $permission_slip;

    }






    public function search($model, $key){

        return $model->where(function ($model) use ($key) {
                $model->where('ps_id', 'LIKE', '%'. $key .'%')
                      ->orwhere('employee_no', 'LIKE', '%'. $key .'%')
                      ->orwhereHas('employee', function ($model) use ($key) {
                          $model->where('fullname', 'LIKE', '%'. $key .'%')
                                ->orwhere('lastname', 'LIKE', '%'. $key .'%')
                                ->orwhere('firstname', 'LIKE', '%'. $key .'%');
                    });
        });

    }






    public function populate($model){

        return $model->select('ps_id', 'employee_no', 'date', 'time_out', 'time_in', 'slug')
                     ->sortable()
                     ->orderBy('updated_at', 'desc')
                     ->paginate(10);

    }






    public function getPSIdInc(){

        $id = 'PS1000001';

        $permission_slip = $this->permission_slip->select('ps_id')->orderBy('ps_id', 'desc')->first();

        if($permission_slip != null){
            
            if($permission_slip->ps_id != null){
                $num = str_replace('PS', '', $permission_slip->ps_id) + 1;
                $id = 'PS' . $num;
            }
        
        }
        
        return $id;
        
    }







}