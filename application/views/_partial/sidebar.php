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
            <a href="<?=base_url()?>dashboard" class="nav-link <?= $side == 'dashboard'?'active':''?>">
              <!-- <i class="nav-icon fas fa-tachometer-alt"></i> -->
              <i class="nav-icon fas fa-home"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <?php if ($this->session->userdata("LEVEL") <= 2): ?>
          <li class="nav-item <?=$this->uri->segment("1")=='data_master'?'menu-open':''?>">
            <a href="javascript:void(0);" class="nav-link <?=substr($side, 0, 11) == 'data_master'?'active':''?>">
              <i class="nav-icon fas fa-folder-open"></i>
              <p>
                Data Master
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview menu-open-kps">
              <li class="nav-item">
                <a href="<?=base_url()?>data_master/user_login" class="nav-link ">
                  <i class="fas fa-id-badge nav-icon <?=substr($side, 12) == 'login'?'text-dark':''?>" style="font-size: 11px;"></i>
                  <p>User Login</p>
                </a>
              </li>
              <li class="nav-item <?=substr($side, 12, 8) == 'karyawan'?'menu-open':''?>">
                <a href="javascript:void(0);" class="nav-link">
                  <i class="nav-icon  fas fa-users <?=substr($side, 12, 8) == 'karyawan'?'text-dark':''?>" style="font-size: 11px;"></i>
                  <p>
                    Karyawan
                    <i class="fas fa-angle-left right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview menu_sub">
                  <li class="nav-item">
                    <a href="<?=base_url()?>data_master/karyawan_internal" class="nav-link ">
                      <i class="fas fa-circle text-sm nav-icon <?=substr($side, 12) == 'karyawan_internal'?'text-dark':''?>" style="font-size: 11px;"></i>
                      <p>Internal</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?=base_url()?>data_master/supir_logistik" class="nav-link ">
                      <i class="fas fa-circle text-sm nav-icon <?=substr($side, 12) == 'karyawan_logistik'?'text-dark':''?>" style="font-size: 11px;"></i>
                      <p>Supir Logistik</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?=base_url()?>data_master/supir_rental" class="nav-link ">
                      <i class="fas fa-circle text-sm nav-icon <?=substr($side, 12) == 'karyawan_rental'?'text-dark':''?>" style="font-size: 11px;"></i>
                      <p>Supir Rental</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?=base_url()?>data_master/verifikasi_karyawan" class="nav-link ">
                      <i class="fas fa-circle text-sm nav-icon <?=substr($side, 12) == 'karyawan_approve'?'text-dark':''?>" style="font-size: 11px;"></i>
                      <p>Verifikasi Karyawan</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-item">
                <a href="<?=base_url()?>data_master/kendaraan" class="nav-link ">
                  <i class="fas fa-car nav-icon <?=substr($side, 12) == 'kendaraan'?'text-dark':''?>" style="font-size: 11px;"></i>
                  <p>Kendaraan</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=base_url()?>data_master/group_jalur" class="nav-link ">
                  <i class="fas fa-signs-post nav-icon <?=substr($side, 12) == 'jalur'?'text-dark':''?>" style="font-size: 11px;"></i>
                  <p>Group Jalur</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=base_url()?>data_master/konfigurasi" class="nav-link ">
                  <i class="fas fa-gears nav-icon <?=substr($side, 12) == 'konfigurasi'?'text-dark':''?>" style="font-size: 11px;"></i>
                  <p>Konfigurasi</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=base_url()?>data_master/voucher_bbm" class="nav-link ">
                  <i class="fas fa-note-sticky nav-icon <?=substr($side, 12) == 'voucher'?'text-dark':''?>" style="font-size: 11px;"></i>
                  <p>Voucher BBM</p>
                </a>
              </li>
              
            </ul>
          </li>
          <?php endif ?>
          <li class="nav-item">
            <a href="<?=base_url()?>Pengajuan/form" class="nav-link <?=$side == 'spj-pengajuan'?'active':''?>">
              <i class="fas fa-envelope-open-text nav-icon "></i>
              <p>Pengajuan SPJ</p>
            </a>
          </li>
          <li class="nav-item <?=$this->uri->segment("1")=='monitoring'?'menu-open':''?>">
            <a href="javascript:void(0);" class="nav-link <?=substr($side, 0, 10) == 'monitoring'?'active':''?>">
              <i class="nav-icon fas fa-desktop"></i>
              <p>
                Monitoring
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview menu-open-kps">
              <li class="nav-item">
                <a href="<?=base_url()?>monitoring/spj" class="nav-link ">
                  <i class="fas fa-file-lines nav-icon <?=substr($side, 11) == 'spj'?'text-dark':''?>" style="font-size: 11px;"></i>
                  <p>SPJ</p>
                </a>
              </li>
              <li class="nav-item <?=substr($side, 11, 6) == 'kasbon'?'menu-open':''?>">
                <a href="javascript:void(0);" class="nav-link">
                  <i class="nav-icon  fas fa-file-invoice-dollar <?=substr($side, 11, 6) == 'kasbon'?'text-dark':''?>" style="font-size: 11px;"></i>
                  <p>
                    Kasbon
                    <i class="fas fa-angle-left right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview menu_sub">
                  <li class="nav-item">
                    <a href="<?=base_url()?>monitoring/kasbon_spj" class="nav-link ">
                      <i class="fas fa-circle text-sm nav-icon <?=substr($side, 18) == 'SPJ'?'text-dark':''?>" style="font-size: 11px;"></i>
                      <p>SPJ</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?=base_url()?>monitoring/kasbon_bbm" class="nav-link ">
                      <i class="fas fa-circle text-sm nav-icon <?=substr($side, 18) == 'BBM'?'text-dark':''?>" style="font-size: 11px;"></i>
                      <p>BBM</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?=base_url()?>monitoring/kasbon_tol" class="nav-link ">
                      <i class="fas fa-circle text-sm nav-icon <?=substr($side, 18) == 'TOL'?'text-dark':''?>" style="font-size: 11px;"></i>
                      <p>TOL</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-item">
                <a href="<?=base_url()?>monitoring/voucher_bbm" class="nav-link ">
                  <i class="fas fa-note-sticky nav-icon <?=substr($side, 11) == 'voucher'?'text-dark':''?>" style="font-size: 11px;"></i>
                  <p>Voucher BBM</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=base_url()?>monitoring/generate_spj" class="nav-link ">
                  <i class="fas fa-book nav-icon <?=substr($side, 11) == 'generate'?'text-dark':''?>" style="font-size: 11px;"></i>
                  <p>Generate SPJ</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=base_url()?>monitoring/harian" class="nav-link ">
                  <i class="fas fa-calendar-day nav-icon <?=substr($side, 11) == 'harian'?'text-dark':''?>" style="font-size: 11px;"></i>
                  <p>Harian SPJ</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=base_url()?>monitoring/in_out_kendaraan" class="nav-link ">
                  <i class="fas fa-truck nav-icon <?=substr($side, 11) == 'kendaraan'?'text-dark':''?>" style="font-size: 11px;"></i>
                  <p>In Out Kendaraan</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=base_url()?>monitoring/in_out_pic" class="nav-link ">
                  <i class="fas fa-user-alt nav-icon <?=substr($side, 11) == 'pic'?'text-dark':''?>" style="font-size: 11px;"></i>
                  <p>In Out PIC</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=base_url()?>monitoring/km_kendaraan" class="nav-link ">
                  <i class="fas fa-gauge nav-icon <?=substr($side, 11) == 'km'?'text-dark':''?>" style="font-size: 11px;"></i>
                  <p>KM Kendaraan</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=base_url()?>monitoring/kendaraan_jam_ke_2" class="nav-link ">
                  <i class="fas fa-truck-moving nav-icon <?=substr($side, 11) == 'kendaraan_2'?'text-dark':''?>" style="font-size: 11px;"></i>
                  <p>Kendaraan Jam Ke-2</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=base_url()?>monitoring/pic_jam_ke_2" class="nav-link ">
                  <i class="fas fa-user-plus nav-icon <?=substr($side, 11) == 'pic_2'?'text-dark':''?>" style="font-size: 11px;"></i>
                  <p>PIC Jam Ke-2</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="<?=base_url()?>implementasi/security" class="nav-link <?=$side == 'implementasi-security'?'active':''?>">
              <i class="fas fa-user-shield nav-icon"></i>
              <p>Security Check</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?=base_url()?>implementasi/step_1?notif=" class="nav-link <?=$side == 'implementasi-step'?'active':''?>">
              <i class="fas fa-clipboard-check nav-icon"></i>
              <p>Implementasi</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?=base_url()?>implementasi/adjustment" class="nav-link <?=$side == 'implementasi-adjustment'?'active':''?>">
              <i class="fas fa-clipboard-list nav-icon"></i>
              <p>Pengajuan Adjustment</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?=base_url()?>implementasi/outstanding" class="nav-link <?=$side == 'implementasi-os'?'active':''?>">
              <i class="fas fa-hourglass-half nav-icon"></i>
              <p>Outstanding Otoritas</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?=base_url()?>implementasi/generate" class="nav-link <?=$side == 'implementasi-generate'?'active':''?>">
              <i class="fas fa-hand-holding-usd nav-icon"></i>
              <p>Generate SPJ</p>
            </a>
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