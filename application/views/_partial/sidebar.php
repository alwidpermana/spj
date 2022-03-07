<aside class="main-sidebar sidebar-dark-light text-danger elevation-4 sidebar-kps " style="font-size: 11px;">
  <!-- Brand Logo -->
  <a href="<?=base_url()?>Dashboard" class="brand-link navbar-kps ">
    <img src="<?=base_url()?>assets/dist/img/logo-KPS.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">SPJ | PT. KPS</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <a href="javascript:;" class="d-block btnUser"><img src="<?=base_url()?>assets/image/avatar/<?=$this->session->userdata("AVATAR")?>" class="img-circle elevation-2" alt="User Image"></a>
      </div>
      <div class="info">
        <a href="javascript:;" class="d-block btnUser"><?=$this->session->userdata("NAMA")?></a>
      </div>
    </div>
    
    <!-- SidebarSearch Form -->
    <!-- <div class="form-inline">
      <div class="input-group" data-widget="sidebar-search">
        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-sidebar">
            <i class="fas fa-search fa-fw"></i>
          </button>
        </div>
      </div>
    </div> -->

    <!-- Sidebar Menu -->
    <?php if ($this->session->userdata("NIK")!= ''): ?>

      <nav class="mt-2 nav-collapse-hide-child">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="<?=base_url()?>Dashboard" class="nav-link <?= $side == 'dashboard'?'active':''?>">
              <!-- <i class="nav-icon fas fa-tachometer-alt"></i> -->
              <i class="nav-icon fa-solid fa-gauge"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <?php if ($this->session->userdata("LEVEL") <= 2): ?>
            <li class="nav-item <?=$this->uri->segment("1")=='Data_Master'?'menu-open':''?>">
              <a href="javascript:void(0);" class="nav-link <?=substr($side, 0, 11) == 'data_master'?'active':''?>">
                <i class="nav-icon fas fa-folder-open"></i>
                <p>
                  Data Master
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview menu-open-kps">
                <li class="nav-item">
                  <a href="<?=base_url()?>Data_Master/User_Login" class="nav-link ">
                    <i class="fas fa-id-badge nav-icon <?=substr($side, 12) == 'login'?'text-dark':''?>"></i>
                    <p>User Login</p>
                  </a>
                </li>
                <li class="nav-item <?=substr($side, 12, 8) == 'karyawan'?'menu-open':''?>">
                  <a href="javascript:void(0);" class="nav-link">
                    <i class="nav-icon  fas fa-users <?=substr($side, 12, 8) == 'karyawan'?'text-dark':''?>"></i>
                    <p>
                      Karyawan
                      <i class="fas fa-angle-left right"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview menu_sub">
                    <li class="nav-item">
                      <a href="<?=base_url()?>Data_Master/Karyawan_Internal" class="nav-link ">
                        <i class="fas fa-circle text-sm nav-icon <?=substr($side, 12) == 'karyawan_internal'?'text-dark':''?>"></i>
                        <p>Internal</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="<?=base_url()?>Data_Master/Supir_Logistik" class="nav-link ">
                        <i class="fas fa-circle text-sm nav-icon <?=substr($side, 12) == 'karyawan_logistik'?'text-dark':''?>"></i>
                        <p>Supir Logistik</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="<?=base_url()?>Data_Master/Supir_Rental" class="nav-link ">
                        <i class="fas fa-circle text-sm nav-icon <?=substr($side, 12) == 'karyawan_rental'?'text-dark':''?>"></i>
                        <p>Supir Rental</p>
                      </a>
                    </li>
                  </ul>
                </li>
                <li class="nav-item">
                  <a href="<?=base_url()?>Data_Master/Kendaraan" class="nav-link ">
                    <i class="fas fa-car nav-icon <?=substr($side, 12) == 'kendaraan'?'text-dark':''?>"></i>
                    <p>Kendaraan</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?=base_url()?>Data_Master/group_jalur" class="nav-link ">
                    <i class="fas fa-signs-post nav-icon <?=substr($side, 12) == 'jalur'?'text-dark':''?>"></i>
                    <p>Group Jalur</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?=base_url()?>Data_Master/Konfigurasi" class="nav-link ">
                    <i class="fas fa-gears nav-icon <?=substr($side, 12) == 'konfigurasi'?'text-dark':''?>"></i>
                    <p>Konfigurasi</p>
                  </a>
                </li>
                
              </ul>
            </li>
          <?php endif ?>
            <li class="nav-item <?=$this->uri->segment("1")=='SPJ'?'menu-open':''?>">
              <a href="javascript:void(0);" class="nav-link <?=substr($side, 0, 3) == 'spj'?'active':''?>">
                <i class="nav-icon fas fa-envelope-open-text"></i>
                <p>
                  Surat Perjalanan Dinas
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview menu-open-kps">

              </ul>
            </li>
        </ul>
      </nav>  
    <?php endif ?>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
  <!-- <div class="sidebar-custom">
    <a href="#" class="btn btn-link text-light"><i class="fas fa-cogs"></i></a>
  </div> -->
  <!-- /.sidebar-custom -->
</aside>