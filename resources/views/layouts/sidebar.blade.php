  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="{{ asset('adminlte/index3.html') }}" class="brand-link">
          <img src="{{ asset('adminlte/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
              class="brand-image img-circle elevation-3" style="opacity: .8">
          <span class="brand-text font-weight-light">Surya Baja</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
          <!-- Sidebar Menu -->
          <nav class="mt-2">
              <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                  data-accordion="false">
                  <li class="nav-item">
                      <a href="{{ route('dash') }}" class="nav-link"{{ request()->routeIs('dash') ? 'active' : '' }}">
                          <i class="nav-icon fas fa-home"></i>
                          <p>
                              Dashboard
                          </p>
                      </a>
                  </li>
                  <li class="nav-header">Menu</li>
                  @rolecan('view permissions')
                  <li class="nav-item">
                      <a href="{{ route('permissions.index') }}"
                          class="nav-link {{ request()->routeIs('permissions.index') ? 'active' : '' }}">
                          <i class="nav-icon fas fa-key"></i>
                          <p>Permissions</p>
                      </a>
                  </li>
                  @endrolecan
                  @rolecan('view roles')
                  <li class="nav-item">
                      <a href="{{ route('role.index') }}"
                          class="nav-link {{ request()->routeIs('role.index') ? 'active' : '' }}">
                          <i class="nav-icon fas fa-user-tag"></i>
                          <p>Role</p>
                      </a>
                  </li>
                  @endrolecan
                  @rolecan('view users')
                  <li class="nav-item">
                      <a href="{{ route('users.index') }}"
                          class="nav-link {{ request()->routeIs('users.index') ? 'active' : '' }}">
                          <i class="nav-icon fas fa-user"></i>
                          <p>Users</p>
                      </a>
                  </li>
                  @endrolecan
                  @rolecan('view articles')
                  <li class="nav-item">
                      <a href="{{ route('articles.index') }}"
                          class="nav-link {{ request()->routeIs('articles.index') ? 'active' : '' }}">
                          <i class="nav-icon fas fa-newspaper"></i>
                          <p>Articles</p>
                      </a>
                  </li>
                  @endrolecan
                  @rolecan('view categories')
                  <li class="nav-item">
                      <a href="{{ route('categories.index') }}"
                          class="nav-link {{ request()->routeIs('categories.index') ? 'active' : '' }}">
                          <i class="nav-icon fas fa-microchip"></i>
                          <p>Category</p>
                      </a>
                  </li>
                  @endrolecan
              </ul>
          </nav>
          <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
  </aside>
