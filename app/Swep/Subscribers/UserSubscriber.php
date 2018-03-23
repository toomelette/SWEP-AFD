<?php 

namespace App\Swep\Subscribers;

use Auth;
use Session;
use App\User;
use App\Menu;
use App\SubMenu;
use App\UserMenu;
use App\UserSubMenu;
use Carbon\Carbon;



class UserSubscriber{


	protected $user;
	protected $menu;
	protected $submenu;
	protected $user_menu;
	protected $carbon;
	protected $auth;
	protected $session;



	public function __construct(User $user, Menu $menu, SubMenu $submenu, UserMenu $user_menu, UserSubMenu $user_submenu, Carbon $carbon){

		$this->user = $user;
		$this->menu = $menu;
		$this->submenu = $submenu;
		$this->user_menu = $user_menu;
		$this->user_submenu = $user_submenu;
		$this->carbon = $carbon;
		$this->auth = auth();
		$this->session = session();

	}



	public function subscribe($events){

		$events->listen('user.create', 'App\Swep\Subscribers\UserSubscriber@onCreate');

	}



	public function onCreate($user, $request){

		$this->createDefaults($user);

		for($i = 0; $i < count($request->menu); $i++){

            $menu = $this->menu->whereMenuId($request->menu[$i])->first();

            $user_menu = new UserMenu;
            $this->createUserMenu($user_menu, $user, $menu);

            if($request->submenu > 0){

                foreach($request->submenu as $data_submenu){

                	$submenu = $this->submenu->whereSubmenuId($data_submenu)->first();

	                if($menu->menu_id === $submenu->menu_id){

	                    $user_submenu = new UserSubMenu;
	                    $this->createUserSubmenu($user_submenu, $submenu, $user_menu);

	                }

                }

            }

        }

        $this->session->flash('USER_CREATE_SUCCESS', 'The User has been successfully created!');
        return redirect()->back();
        
	}




	/** DEFAULTS **/

	public function createDefaults($user){

		$user->user_id = $this->user->userIdIncrement;
        $user->is_logged = false;
        $user->is_active = false;
        $user->color = 'skin-green sidebar-mini';
        $user->created_at = $this->carbon->now();
        $user->updated_at = $this->carbon->now();
        $user->machine_created = gethostname();
        $user->machine_updated = gethostname();
        $user->ip_created = request()->ip();
        $user->ip_updated = request()->ip();
        $user->user_created = $this->auth->user()->user_id;
        $user->user_updated = $this->auth->user()->user_id;
        $user->last_login_time = null;
        $user->last_login_machine = null;
        $user->last_login_ip = null;
        $user->save();

	}



	/**  **/

	public function createUserMenu($user_menu, $user, $menu){

		$user_menu->user_menu_id = $this->user_menu->userMenuIdIncrement;
        $user_menu->user_id = $user->user_id;
        $user_menu->menu_id = $menu->menu_id;
        $user_menu->name = $menu->name;
        $user_menu->route = $menu->route;
        $user_menu->icon = $menu->icon;
        $user_menu->is_dropdown = $menu->is_dropdown;       
        $user_menu->save();

	}



	public function createUserSubmenu($user_submenu, $submenu, $user_menu){

        $user_submenu->submenu_id = $submenu->submenu_id;
        $user_submenu->user_menu_id = $user_menu->user_menu_id;
        $user_submenu->user_id = $user_menu->user_id;
        $user_submenu->is_nav = $submenu->is_nav;
        $user_submenu->name = $submenu->name;
        $user_submenu->route = $submenu->route;
        $user_submenu->save();

	}




}