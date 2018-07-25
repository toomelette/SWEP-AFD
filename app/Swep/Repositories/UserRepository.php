<?php

namespace App\Swep\Repositories;
 
use App\Swep\BaseClasses\BaseRepository;
use App\Swep\Interfaces\UserInterface;
use App\Swep\Interfaces\EmployeeInterface;

use Hash;
use App\Models\User;
use App\Models\UserMenu;
use App\Models\UserSubmenu;


class UserRepository extends BaseRepository implements UserInterface {
	

	protected $user;
    protected $user_menu;
    protected $user_submenu;

    protected $employee_repo;



	public function __construct(User $user, UserMenu $user_menu, UserSubmenu $user_submenu, EmployeeInterface $employee_repo){

        $this->user = $user;
        $this->user_menu = $user_menu;
        $this->user_submenu = $user_submenu;

        $this->employee_repo = $employee_repo;

        parent::__construct();

    }






	public function fetchAll($request){
	
		$key = str_slug($request->fullUrl(), '_');

        $users = $this->cache->remember('users:all:' . $key, 240, function() use ($request){

            $user = $this->user->newQuery();
            
            if(isset($request->q)){
                $this->search($user, $request->q);
            }

            if(isset($request->ol)){
                $this->isOnline($user, $this->dataTypeHelper->string_to_boolean($request->ol));
            }

            if(isset($request->a)){
                 $this->isActive($user, $this->dataTypeHelper->string_to_boolean($request->a));
            }

            return $this->populate($user);

        });

        return $users;
	
	}
	





	public function store($request){

        $user = new User;
        $user->slug = $this->str->random(16);
        $user->user_id = $this->getUserIdInc();
        $user->firstname = $request->firstname;
        $user->middlename = $request->middlename;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        $user->position = $request->position;
        $user->username = $request->username;
        $user->password = Hash::make($request->password);
        $user->created_at = $this->carbon->now();
        $user->updated_at = $this->carbon->now();
        $user->ip_created = request()->ip();
        $user->ip_updated = request()->ip();
        $user->user_created = $this->auth->user()->user_id;
        $user->user_updated = $this->auth->user()->user_id;
        $user->save();

        return $user;

    }






    public function update($request, $slug){

        $user = $this->findBySlug($slug);
        $user->firstname = $request->firstname;
        $user->middlename = $request->middlename;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        $user->position = $request->position;
        $user->username = $request->username;
        $user->updated_at = $this->carbon->now();
        $user->ip_updated = request()->ip();
        $user->user_updated = $this->auth->user()->user_id;
        $user->save();

        $user->userMenu()->delete();
        $user->userSubmenu()->delete();

        return $user;

    }






    public function destroy($slug){

        $user = $this->findBySlug($slug);  
        $user->delete();
        $user->userMenu()->delete();
        $user->userSubmenu()->delete();

        return $user;

    }






    public function activate($slug){

        $user = $this->findBySlug($slug);
        $user->is_active = 1;
        $user->save();

        return $user;

    }





    public function deactivate($slug){

        $user = $this->findBySlug($slug);
        $user->is_active = 0;
        $user->is_online = 0;
        $user->save();

        return $user;

    }






    public function logout($slug){

        $user = $this->findBySlug($slug);
        $user->is_online = 0;
        $user->save();

        return $user;

    }






    public function resetPassword($model, $request){

        $model->password = Hash::make($request->password);
        $model->is_online = 0;
        $model->save();

        return $model;

    }






    public function sync($employee, $slug){

        $user = $this->findBySlug($slug);
        $employee->user_id = $user->user_id;
        $employee->save();

        return $user;

    }






    public function unsync($slug){

        $user = $this->findBySlug($slug);

        $employee = $this->employee_repo->findByUserId($user->user_id);
        $employee->user_id = null;
        $employee->save();

        return [$user, $employee];

    }






	public function findBySlug($slug){

        $user = $this->cache->remember('users:bySlug:' . $slug, 240, function() use ($slug){
            return $this->user->where('slug', $slug)->with(['userMenu', 'userMenu.userSubMenu'])->firstOrFail();
        }); 
        
        return $user;

    }






    public function storeUserMenu($user, $menu){

    	$user_menu = new UserMenu;
        $user_menu->user_menu_id = $this->getUserMenuIdInc();
        $user_menu->user_id = $user->user_id;
        $user_menu->menu_id = $menu->menu_id;
        $user_menu->category = $menu->category;
        $user_menu->name = $menu->name;
        $user_menu->route = $menu->route;
        $user_menu->icon = $menu->icon;
        $user_menu->is_menu = $menu->is_menu;
        $user_menu->is_dropdown = $menu->is_dropdown; 
        $user_menu->save();

        return $user_menu;
        
    }






    public function storeUserSubmenu($submenu, $user_menu){

    	$user_submenu = new UserSubMenu;
        $user_submenu->submenu_id = $submenu->submenu_id;
        $user_submenu->user_menu_id = $user_menu->user_menu_id;
        $user_submenu->user_id = $user_menu->user_id;
        $user_submenu->is_nav = $submenu->is_nav;
        $user_submenu->name = $submenu->name;
        $user_submenu->route = $submenu->route;
        $user_submenu->save();

        return $user_submenu;

    }






	public function search($model, $key){

        return $model->where(function ($model) use ($key) {
                $model->where('firstname', 'LIKE', '%'. $key .'%')
                      ->orwhere('middlename', 'LIKE', '%'. $key .'%')
                      ->orwhere('lastname', 'LIKE', '%'. $key .'%')
                      ->orwhere('username', 'LIKE', '%'. $key .'%');
        });

    }





    public function isOnline($model, $value){

        return $model->where('is_online', $value);

    }





    public function isActive($model, $value){

        return $model->where('is_active', $value);

    }





    public function populate($model){

        return $model->select('user_id', 'username', 'firstname', 'middlename', 'lastname', 'is_online', 'is_active', 'slug')
                     ->sortable()
                     ->orderBy('updated_at', 'desc')
                     ->paginate(10);

    }





    public function getUserIdInc(){

        $id = 'U10001';

        $user = $this->user->select('user_id')->orderBy('user_id', 'desc')->first();

        if($user != null){

            if($user->user_id != null){
                $num = str_replace('U', '', $user->user_id) + 1;
                $id = 'U' . $num;
            }
        
        }
        
        return $id;
        
    }






    public function getUserMenuIdInc(){

        $id = 'UM10000001';

        $usermenu = $this->user_menu->select('user_menu_id')->orderBy('user_menu_id', 'desc')->first();

        if($usermenu != null){

            if($usermenu->user_menu_id != null){

                $num = str_replace('UM', '', $usermenu->user_menu_id) + 1;
                
                $id = 'UM' . $num;
            
            }
        
        }
        
        return $id;
        
    }






}