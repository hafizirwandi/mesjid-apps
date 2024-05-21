  <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
      <div class="app-brand demo">
          <a href="index.html" class="app-brand-link">
              <span class="app-brand-logo">
                  <img style="width:150px" src="{{ asset('logo-mutiarastory.png') }}" alt="">
              </span>
              {{-- <span class="app-brand-text demo menu-text fw-bold">CAT</span> --}}
          </a>

          <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
              <i class="ti menu-toggle-icon d-none d-xl-block ti-sm align-middle"></i>
              <i class="ti ti-x d-block d-xl-none ti-sm align-middle"></i>
          </a>
      </div>

      <div class="menu-inner-shadow"></div>

      <ul class="menu-inner py-1">
          @auth('web')
              <li class="menu-item {{ request()->routeIs('home*') ? 'active' : '' }}">
                  <a href="{{ route('home') }}" class="menu-link">
                      <i class="menu-icon tf-icons ti ti-smart-home"></i>
                      <div data-i18n="Home">Home</div>
                  </a>
              </li>
              @can('user-list')
                  <li class="menu-item {{ request()->routeIs('user*') ? 'active' : '' }}">
                      <a href="{{ route('user') }}" class="menu-link">
                          <i class="menu-icon tf-icons ti ti-users"></i>
                          <div data-i18n="User">User</div>
                      </a>
                  </li>
              @endcan
              @canany(['role-list', 'permission-list'])
                  <li class="menu-item {{ isDropdown(['role*', 'permission*']) }}">
                      <a href="javascript:void(0);" class="menu-link menu-toggle">
                          <i class="menu-icon tf-icons ti ti-settings"></i>
                          <div data-i18n="Role & Permission">Role & Permission</div>
                      </a>
                      <ul class="menu-sub">
                          @can('role-list')
                              <li class="menu-item {{ request()->routeIs('role*') ? 'active' : '' }}">
                                  <a href="{{ route('role') }}" class="menu-link">
                                      <div data-i18n="Role">Role</div>
                                  </a>
                              </li>
                          @endcan
                          @can('permission-list')
                              <li class="menu-item {{ request()->routeIs('permission*') ? 'active' : '' }}">
                                  <a href="{{ route('permission') }}" class="menu-link">
                                      <div data-i18n="Permission">Permission</div>
                                  </a>
                              </li>
                          @endcan
                      </ul>
                  </li>
              @endcanany

          @endauth
      </ul>
  </aside>


  @php

      function isDropdown($trees)
      {
          $temp = false;
          foreach ($trees as $r) {
              $temp = request()->routeIs($r);
              if ($temp) {
                  return 'active open';
                  break;
              }
          }
      }
  @endphp
