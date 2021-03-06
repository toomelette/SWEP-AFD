<aside class="main-sidebar">
  <section class="sidebar">
    <div class="user-panel">
      <div class="pull-left image">
        <img src="{{ asset('images/avatar.jpeg') }}" class="img-circle" alt="User Image">
      </div>
      <div class="pull-left info">
        
        @if(Auth::check())
          <p>{{ Auth::user()->firstname }}</p>
        @endif

        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
      </div>
    </div>
    <ul class="sidebar-menu" data-widget="tree">
      

      @if(Auth::check())


      {{-- User --}}
      @if(!$global_user_menus_u->isEmpty())

          <li class="header">Navigation</li>
          @foreach($global_user_menus_u as $user_menu)

            @if($user_menu->is_menu == true)

              @if($user_menu->is_dropdown == false)

              <li class="{!! Route::currentRouteNamed($user_menu->route) ? 'active' : '' !!}">
                <a href="{{ route($user_menu->route) }}">
                  <i class="fa {{ $user_menu->icon }}"></i> <span>{{ $user_menu->name }}</span>
                </a>
              </li>

              @else

                <li class="treeview {!! Route::currentRouteNamed($user_menu->route) ? 'active' : '' !!}">
                  <a href="#">
                    <i class="fa {{ $user_menu->icon }}"></i> <span>{{ $user_menu->name }}</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>

                    <ul class="treeview-menu">

                      @foreach($user_menu->userSubMenu as $user_nav)

                        @if($user_nav->is_nav == true)

                          <li class="{!! Route::currentRouteNamed($user_nav->route) ? 'active' : '' !!}">
                            <a href="{{ route($user_nav->route) }}"><i class="fa fa-caret-right"></i> {{ $user_nav->nav_name }}</a>
                          </li>

                        @endif

                      @endforeach

                    </ul>

                </li>

              @endif

            @endif

          @endforeach

        @endif




        {{-- SU --}}
        @if(!$global_user_menus_su->isEmpty())

          <li class="header">SU</li>
          @foreach($global_user_menus_su as $user_menu)

            @if($user_menu->is_menu == true)

              @if($user_menu->is_dropdown == false)

              <li class="{!! Route::currentRouteNamed($user_menu->route) ? 'active' : '' !!}">
                <a href="{{ route($user_menu->route) }}">
                  <i class="fa {{ $user_menu->icon }}"></i> <span>{{ $user_menu->name }}</span>
                </a>
              </li>

              @else

                <li class="treeview {!! Route::currentRouteNamed($user_menu->route) ? 'active' : '' !!}">
                  <a href="#">
                    <i class="fa {{ $user_menu->icon }}"></i> <span>{{ $user_menu->name }}</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>

                    <ul class="treeview-menu">

                      @foreach($user_menu->userSubMenu as $user_nav)

                        @if($user_nav->is_nav == true)

                          <li class="{!! Route::currentRouteNamed($user_nav->route) ? 'active' : '' !!}">
                            <a href="{{ route($user_nav->route) }}"><i class="fa fa-caret-right"></i> {{ $user_nav->nav_name }}</a>
                          </li>

                        @endif

                      @endforeach

                    </ul>

                </li>

              @endif

            @endif

          @endforeach

        @endif




        {{-- ACCOUNTING --}}
        @if(!$global_user_menus_acctg->isEmpty())

          <li class="header">ACCOUNTING</li>
          @foreach($global_user_menus_acctg as $user_menu)

            @if($user_menu->is_menu == true)

              @if($user_menu->is_dropdown == false)

              <li class="{!! Route::currentRouteNamed($user_menu->route) ? 'active' : '' !!}">
                <a href="{{ route($user_menu->route) }}">
                  <i class="fa {{ $user_menu->icon }}"></i> <span>{{ $user_menu->name }}</span>
                </a>
              </li>

              @else

                <li class="treeview {!! Route::currentRouteNamed($user_menu->route) ? 'active' : '' !!}">
                  <a href="#">
                    <i class="fa {{ $user_menu->icon }}"></i> <span>{{ $user_menu->name }}</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>

                    <ul class="treeview-menu">

                      @foreach($user_menu->userSubMenu as $user_nav)

                        @if($user_nav->is_nav == true)

                          <li class="{!! Route::currentRouteNamed($user_nav->route) ? 'active' : '' !!}">
                            <a href="{{ route($user_nav->route) }}"><i class="fa fa-caret-right"></i> {{ $user_nav->nav_name }}</a>
                          </li>

                        @endif

                      @endforeach

                    </ul>

                </li>

              @endif

            @endif

          @endforeach

        @endif





        {{-- HR --}}
        @if(!$global_user_menus_hr->isEmpty())

          <li class="header">HUMAN RESOURCE</li>
          @foreach($global_user_menus_hr as $user_menu)

            @if($user_menu->is_menu == true)

              @if($user_menu->is_dropdown == false)

              <li class="{!! Route::currentRouteNamed($user_menu->route) ? 'active' : '' !!}">
                <a href="{{ route($user_menu->route) }}">
                  <i class="fa {{ $user_menu->icon }}"></i> <span>{{ $user_menu->name }}</span>
                </a>
              </li>

              @else

                <li class="treeview {!! Route::currentRouteNamed($user_menu->route) ? 'active' : '' !!}">
                  <a href="#">
                    <i class="fa {{ $user_menu->icon }}"></i> <span>{{ $user_menu->name }}</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>

                    <ul class="treeview-menu">

                      @foreach($user_menu->userSubMenu as $user_nav)

                        @if($user_nav->is_nav == true)

                          <li class="{!! Route::currentRouteNamed($user_nav->route) ? 'active' : '' !!}">
                            <a href="{{ route($user_nav->route) }}"><i class="fa fa-caret-right"></i> {{ $user_nav->nav_name }}</a>
                          </li>

                        @endif

                      @endforeach

                    </ul>

                </li>

              @endif

            @endif

          @endforeach

        @endif





        {{-- RECORDS --}}
        @if(!$global_user_menus_records->isEmpty())

          <li class="header">RECORDS</li>
          @foreach($global_user_menus_records as $user_menu)

            @if($user_menu->is_menu == true)

              @if($user_menu->is_dropdown == false)

              <li class="{!! Route::currentRouteNamed($user_menu->route) ? 'active' : '' !!}">
                <a href="{{ route($user_menu->route) }}">
                  <i class="fa {{ $user_menu->icon }}"></i> <span>{{ $user_menu->name }}</span>
                </a>
              </li>

              @else

                <li class="treeview {!! Route::currentRouteNamed($user_menu->route) ? 'active' : '' !!}">
                  <a href="#">
                    <i class="fa {{ $user_menu->icon }}"></i> <span>{{ $user_menu->name }}</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>

                    <ul class="treeview-menu">

                      @foreach($user_menu->userSubMenu as $user_nav)

                        @if($user_nav->is_nav == true)

                          <li class="{!! Route::currentRouteNamed($user_nav->route) ? 'active' : '' !!}">
                            <a href="{{ route($user_nav->route) }}"><i class="fa fa-caret-right"></i> {{ $user_nav->nav_name }}</a>
                          </li>

                        @endif

                      @endforeach

                    </ul>

                </li>

              @endif

            @endif

          @endforeach

        @endif





      @endif

    </ul>
  </section>
</aside>