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
        <a href="javascript:;" class="d-block btnUser">
          <?php 
          $username = $this->session->userdata("username");
          if ($this->session->userdata("photo") == ''): ?>
              
          <?php else: ?>
            <img src="http://192.168.0.213:8080/FOTO/<?=$this->session->userdata("photo")?>" class="img-circle elevation-2 photo_user" alt="User Image">    
          <?php endif ?>
        </a>
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
          <?php if ($this->session->userdata("LEVEL") == 0): ?>
            <li class="nav-item">
              <a href="<?=base_url()?>dashboard/pageTest" class="nav-link <?= $side == 'test'?'active':''?>">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  TEST
                </p>
              </a>
            </li>
          <?php endif ?>
          <li class="nav-item ">
            <a href="<?=base_url()?>dashboard" class="nav-link <?= $side == 'dashboard'?'active':''?>">
              <!-- <i class="nav-icon fas fa-tachometer-alt"></i> -->
              <i class="nav-icon fas fa-home"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <?php if ($this->session->userdata("LEVEL") <= 2 || $this->session->userdata("NDV") == 'Y'): ?>
          <li class="nav-item <?=$this->uri->segment("1")=='data_master'?'menu-open':''?>">
            <a href="javascript:void(0);" class="nav-link <?=substr($side, 0, 11) == 'data_master'?'active':''?>">
              <i class="nav-icon fas fa-folder-open"></i>
              <p>
                Data Master
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview menu-open-kps">
              <li class="nav-item list-menu-open">
                <a href="<?=base_url()?>data_master/user_login" class="nav-link">
                  <i class="fas fa-id-badge nav-icon  <?=substr($side, 12) == 'login'?'text-dark':''?>" style="font-size: 11px;"></i>
                  <p>User Login</p>
                </a>
              </li>
              <li class="nav-item list-menu-open <?=substr($side, 12, 8) == 'karyawan'?'menu-open':''?>">
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
                      <p>Logistik</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?=base_url()?>data_master/supir_rental" class="nav-link ">
                      <i class="fas fa-circle text-sm nav-icon <?=substr($side, 12) == 'karyawan_rental'?'text-dark':''?>" style="font-size: 11px;"></i>
                      <p>Rental</p>
                    </a>
                  </li>
                  <?php if ($this->session->userdata("LEVEL")==0 || $this->session->userdata("NIK")=='00004' || $this->session->userdata("NIK") == '00099' || $this->session->userdata("NIK")=='05426'): ?>
                    <li class="nav-item">
                      <a href="<?=base_url()?>data_master/verifikasi_karyawan" class="nav-link ">
                        <i class="fas fa-circle text-sm nav-icon <?=substr($side, 12) == 'karyawan_approve'?'text-dark':''?>" style="font-size: 11px;"></i>
                        <p>Verifikasi Karyawan</p>
                      </a>
                    </li> 
                    <li class="nav-item">
                      <a href="<?=base_url()?>data_master/karyawan_adjustment" class="nav-link ">
                        <i class="fas fa-circle text-sm nav-icon <?=substr($side, 12) == 'karyawan_adjustment'?'text-dark':''?>" style="font-size: 11px;"></i>
                        <p>Adjustment</p>
                      </a>
                    </li>
                  <?php endif ?>
                </ul>
              </li>
              <li class="nav-item list-menu-open">
                <a href="<?=base_url()?>data_master/rekanan" class="nav-link ">
                  <i class="fas fa-hands-helping nav-icon <?=substr($side, 12) == 'rekanan'?'text-dark':''?>" style="font-size: 11px;"></i>
                  <p>Rekanan</p>
                </a>
              </li>
              <li class="nav-item list-menu-open <?=substr($side, 12, 9) == 'kendaraan'?'menu-open':''?>">
                <a href="javascript:void(0);" class="nav-link">
                  <i class="fas fa-car nav-icon <?=substr($side, 12, 9) == 'kendaraan'?'text-dark':''?>" style="font-size: 11px;"></i>
                  <p>
                    Kendaraan
                    <i class="fas fa-angle-left right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview menu_sub">
                  <li class="nav-item">
                    <a href="<?=base_url()?>data_master/kendaraan" class="nav-link ">
                      <i class="fas fa-circle text-sm nav-icon <?=substr($side, 12) == 'kendaraan-internal'?'text-dark':''?>" style="font-size: 11px;"></i>
                      <p>Internal</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?=base_url()?>data_master/kendaraan_rental" class="nav-link ">
                      <i class="fas fa-circle text-sm nav-icon <?=substr($side, 12) == 'kendaraan-rental'?'text-dark':''?>" style="font-size: 11px;"></i>
                      <p>Rental</p>
                    </a>
                  </li>
                  <?php if ($this->session->userdata("LEVEL")==0 || $this->session->userdata("NIK")=='00004' || $this->session->userdata("NIK") == '00099'  || $this->session->userdata("NIK")=='05426'): ?>
                    <li class="nav-item">
                      <a href="<?=base_url()?>data_master/verifikasi_kendaraan" class="nav-link ">
                        <i class="fas fa-circle text-sm nav-icon <?=substr($side, 12) == 'kendaraan-verifikasi'?'text-dark':''?>" style="font-size: 11px;"></i>
                        <p>Verifikasi</p>
                      </a>
                    </li>  
                  <?php endif ?>
                  
                </ul>
              </li>
              
              <li class="nav-item list-menu-open">
                <a href="<?=base_url()?>data_master/group_jalur" class="nav-link ">
                  <i class="fas fa-signs-post nav-icon <?=substr($side, 12) == 'jalur'?'text-dark':''?>" style="font-size: 11px;"></i>
                  <p>Group Jalur</p>
                </a>
              </li>
              <li class="nav-item list-menu-open">
                <a href="<?=base_url()?>data_master/konfigurasi" class="nav-link ">
                  <i class="fas fa-gears nav-icon <?=substr($side, 12) == 'konfigurasi'?'text-dark':''?>" style="font-size: 11px;"></i>
                  <p>Konfigurasi</p>
                </a>
              </li>
              <?php if ($this->session->userdata("LEVEL")==0 || $this->session->userdata("NIK")=='00004'): ?>
                <li class="nav-item list-menu-open">
                  <a href="<?=base_url()?>data_master/verifikasi_konfigurasi" class="nav-link ">
                    <i class="fas fa-clipboard-check nav-icon <?=substr($side, 12) == 'verif_konfig'?'text-dark':''?>" style="font-size: 11px;"></i>
                    <p>Verifikasi Konfigurasi</p>
                  </a>
                </li>  
              <?php endif ?>
              <!-- <li class="nav-item list-menu-open">
                <a href="<?=base_url()?>data_master/voucher_bbm" class="nav-link ">
                  <i class="fas fa-note-sticky nav-icon <?=substr($side, 12) == 'voucher'?'text-dark':''?>" style="font-size: 11px;"></i>
                  <p>Voucher BBM</p>
                </a>
              </li> -->
              <?php if ($this->session->userdata("LEVEL")==0 || $this->session->userdata("NIK") == '00099'): ?>
                <li class="nav-item list-menu-open">
                  <a href="<?=base_url()?>data_master/biaya_abnormal" class="nav-link ">
                    <i class="fas fa-file-invoice-dollar nav-icon <?=substr($side, 12) == 'abnormal'?'text-dark':''?>" style="font-size: 11px;"></i>
                    <p>Biaya Abnormal</p>
                  </a>
                </li>  
              <?php endif ?>
              
              
              
            </ul>
          </li>
          <?php endif ?>
          <?php if ($this->session->userdata("LEVEL")<=3): ?>
           <li class="nav-item <?=$this->uri->segment("1")=='cash_flow'?'menu-open':''?>">
            <a href="javascript:void(0);" class="nav-link <?=$this->uri->segment("1")=='cash_flow'?'active':''?>">
              <i class="nav-icon fas fa-money-check-alt"></i>
              <p>
                Cash Flow
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview menu-open-kps">
              <?php if ($this->session->userdata("LEVEL")<=1): ?>
                <li class="nav-item list-menu-open">
                  <a href="<?=base_url()?>cash_flow/buku_kas" class="nav-link ">
                    <i class="fas fa-book nav-icon <?=substr($side, 10) == 'buku'?'text-dark':''?>" style="font-size: 11px;"></i>
                    <p>Buku Kas Internal</p>
                  </a>
                </li>
              <?php endif ?>
              <li class="nav-item list-menu-open">
                <a href="<?=base_url()?>cash_flow/mutasi" class="nav-link ">
                  <i class="fas fa-hand-holding-usd nav-icon <?=substr($side, 10) == 'mutasi'?'text-dark':''?>" style="font-size: 11px;"></i>
                  <p>Mutasi Sub Kas</p>
                </a>
              </li>
              <li class="nav-item list-menu-open">
                <a href="<?=base_url()?>cash_flow/pengajuan" class="nav-link ">
                  <i class="fas fa-hand-holding-usd nav-icon <?=substr($side, 10) == 'pengajuan'?'text-dark':''?>" style="font-size: 11px;"></i>
                  <p>Pengajuan Sub Kas</p>
                </a>
              </li>
              <li class="nav-item list-menu-open">
                <a href="<?=base_url()?>cash_flow/my_cash_flow" class="nav-link ">
                  <i class="fas fa-clipboard-check nav-icon <?=substr($side, 10) == 'mcf'?'text-dark':''?>" style="font-size: 11px;"></i>
                  <p>My Cash Flow</p>
                </a>
              </li>
              <li class="nav-item list-menu-open">
                <a href="<?=base_url()?>cash_flow/rekap_saldo" class="nav-link ">
                  <i class="fas fa-wallet nav-icon <?=substr($side, 10) == 'rekap'?'text-dark':''?>" style="font-size: 11px;"></i>
                  <p>Rekap Saldo</p>
                </a>
              </li>
            </ul>
          </li> 
          <?php endif ?>
          
          <?php if ($this->session->userdata("LEVEL")<=4): ?>
            <li class="nav-item <?=$this->uri->segment("1")=='pengajuan'?'menu-open':''?>">
              <a href="javascript:void(0);" class="nav-link <?=$this->uri->segment("1")=='pengajuan'?'active':''?>">
                <i class="nav-icon fas fa-envelope-open-text"></i>
                <p>
                  Pengajuan SPJ
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview menu-open-kps">
                <li class="nav-item list-menu-open">
                  <a href="<?=base_url()?>pengajuan/form" class="nav-link <?=$side == 'spj-pengajuan'?'text-dark':''?>">
                    <i class="fas fa-file-alt nav-icon <?=$side == 'spj-pengajuan'?'text-dark':''?>" style="font-size: 11px;"></i>
                    <p>Pengajuan Baru</p>
                  </a>
                </li>
                <?php if ($this->session->userdata("LEVEL") == 0): ?>
                  <li class="nav-item list-menu-open">
                    <a href="<?=base_url()?>pengajuan/temporary" class="nav-link <?=$side == 'spj-temporary'?'text-dark':''?>">
                      <i class="fas fa-file-excel nav-icon <?=$side == 'spj-temporary'?'text-dark':''?>" style="font-size: 11px;"></i>
                      <p>Temporary Pengajuan</p>
                    </a>
                  </li>
                <?php endif ?>
                <?php if ($this->session->userdata("NDV") == 'Y'): ?>
                  <li class="nav-item list-menu-open">
                    <a href="<?=base_url()?>pengajuan/draft" class="nav-link <?=$side == 'pengajuan-draft'?'text-dark':''?>">
                      <i class="fas fa-file-archive nav-icon <?=$side == 'pengajuan-draft'?'text-dark':''?>" style="font-size: 11px;"></i>
                      <p>Draft Pengajuan Non Delivery</p>
                    </a>
                  </li>
                <?php endif ?>
              </ul>
            </li>  
          <?php endif ?>
          <li class="nav-item <?=$this->uri->segment("1")=='monitoring'?'menu-open':''?>">
            <a href="javascript:void(0);" class="nav-link <?=substr($side, 0, 10) == 'monitoring'?'active':''?>">
              <i class="nav-icon fas fa-desktop"></i>
              <p>
                Monitoring
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview menu-open-kps">
              <li class="nav-item list-menu-open">
                <a href="<?=base_url()?>monitoring/konfigurasi" class="nav-link ">
                  <i class="fas fa-gears nav-icon <?=substr($side, 11) == 'konfigurasi'?'text-dark':''?>" style="font-size: 11px;"></i>
                  <p>Konfigurasi</p>
                </a>
              </li>
              <li class="nav-item list-menu-open">
                <a href="<?=base_url()?>monitoring/spj" class="nav-link ">
                  <i class="fas fa-file-lines nav-icon <?=substr($side, 11) == 'spj'?'text-dark':''?>" style="font-size: 11px;"></i>
                  <p>SPJ</p>
                </a>
              </li>
              <li class="nav-item <?=substr($side, 11, 6) == 'kasbon'?'menu-open':''?> list-menu-open">
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
              <li class="nav-item list-menu-open">
                <a href="<?=base_url()?>monitoring/voucher_bbm" class="nav-link ">
                  <i class="fas fa-note-sticky nav-icon <?=substr($side, 11) == 'voucher'?'text-dark':''?>" style="font-size: 11px;"></i>
                  <p>Voucher BBM</p>
                </a>
              </li>
              <li class="nav-item list-menu-open">
                <a href="<?=base_url()?>monitoring/generate_spj" class="nav-link ">
                  <i class="fas fa-book nav-icon <?=substr($side, 11) == 'generate'?'text-dark':''?>" style="font-size: 11px;"></i>
                  <p>Generate SPJ</p>
                </a>
              </li>
              <li class="nav-item list-menu-open">
                <a href="<?=base_url()?>monitoring/harian" class="nav-link ">
                  <i class="fas fa-calendar-day nav-icon <?=substr($side, 11) == 'harian'?'text-dark':''?>" style="font-size: 11px;"></i>
                  <p>Harian SPJ</p>
                </a>
              </li>
              <li class="nav-item list-menu-open">
                <a href="<?=base_url()?>monitoring/weekly" class="nav-link ">
                  <i class="fas fa-calendar-week nav-icon <?=substr($side, 11) == 'weekly'?'text-dark':''?>" style="font-size: 11px;"></i>
                  <p>Biaya Weekly SPJ</p>
                </a>
              </li>
              <li class="nav-item list-menu-open">
                <a href="<?=base_url()?>monitoring/in_out_kendaraan" class="nav-link ">
                  <i class="fas fa-truck nav-icon <?=substr($side, 11) == 'kendaraan'?'text-dark':''?>" style="font-size: 11px;"></i>
                  <p>In Out Kendaraan</p>
                </a>
              </li>
              <li class="nav-item list-menu-open">
                <a href="<?=base_url()?>monitoring/in_out_pic" class="nav-link ">
                  <i class="fas fa-user-alt nav-icon <?=substr($side, 11) == 'pic'?'text-dark':''?>" style="font-size: 11px;"></i>
                  <p>In Out PIC</p>
                </a>
              </li>
              <li class="nav-item list-menu-open">
                <a href="<?=base_url()?>monitoring/km_kendaraan" class="nav-link ">
                  <i class="fas fa-gauge nav-icon <?=substr($side, 11) == 'km'?'text-dark':''?>" style="font-size: 11px;"></i>
                  <p>KM Kendaraan</p>
                </a>
              </li>
              <li class="nav-item list-menu-open">
                <a href="<?=base_url()?>monitoring/kendaraan_jam_ke_2" class="nav-link ">
                  <i class="fas fa-truck-moving nav-icon <?=substr($side, 11) == 'kendaraan_2'?'text-dark':''?>" style="font-size: 11px;"></i>
                  <p>Kendaraan Jam Ke-2</p>
                </a>
              </li>
              <li class="nav-item list-menu-open">
                <a href="<?=base_url()?>monitoring/pic_jam_ke_2" class="nav-link ">
                  <i class="fas fa-user-plus nav-icon <?=substr($side, 11) == 'pic_2'?'text-dark':''?>" style="font-size: 11px;"></i>
                  <p>PIC Jam Ke-2</p>
                </a>
              </li>
              <li class="nav-item list-menu-open">
                <a href="<?=base_url()?>monitoring/ng_security" class="nav-link ">
                  <i class="fas fa-user-slash nav-icon <?=substr($side, 11) == 'ng'?'text-dark':''?>" style="font-size: 11px;"></i>
                  <p>NG Security</p>
                </a>
              </li>
              <li class="nav-item <?=substr($side, 11, 6) == 'rental'?'menu-open':''?> list-menu-open">
                <a href="javascript:void(0);" class="nav-link">
                  <i class="nav-icon  fas fa-file-invoice-dollar <?=substr($side, 11, 6) == 'rental'?'text-dark':''?>" style="font-size: 11px;"></i>
                  <p>
                    Kendaraan Rental
                    <i class="fas fa-angle-left right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview menu_sub">
                  <li class="nav-item">
                    <a href="<?=base_url()?>monitoring/pemakaian_rental" class="nav-link ">
                      <i class="fas fa-circle text-sm nav-icon <?=$side == 'monitoring-rental-pemakaian'?'text-dark':''?>" style="font-size: 11px;"></i>
                      <p>Pemakaian Kendaraan</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?=base_url()?>monitoring/jumlah_pemakaian" class="nav-link ">
                      <i class="fas fa-circle text-sm nav-icon <?=$side == 'monitoring-rental-jumlah'?'text-dark':''?>" style="font-size: 11px;"></i>
                      <p>Jumlah Pemakaian</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?=base_url()?>monitoring/breakdown_pemakaian" class="nav-link ">
                      <i class="fas fa-circle text-sm nav-icon <?=$side == 'monitoring-rental-breakdown'?'text-dark':''?>" style="font-size: 11px;"></i>
                      <p>Breakdown Pemakaian Kendaraan</p>
                    </a>
                  </li>
                </ul>
              </li>

              <?php 
              $nik = $this->session->userdata("NIK");
              $level = $this->session->userdata("LEVEL");
              if ($level == '0' || $nik =='04035' || $nik == '00099' || $nik == '04607'): ?>
                <li class="nav-item list-menu-open">
                  <a href="<?=base_url()?>monitoring/cost_reduction" class="nav-link ">
                    <i class="fas fa-donate nav-icon <?=substr($side, 11) == 'cr'?'text-dark':''?>" style="font-size: 11px;"></i>
                    <p>Cost Reduction Delivery</p>
                  </a>
                </li>  
              <?php endif ?>
              <li class="nav-item list-menu-open">
                <a href="<?=base_url()?>monitoring/keberangkatan" class="nav-link ">
                  <i class="fas fa-clock nav-icon <?=substr($side, 11) == 'keberangkatan'?'text-dark':''?>" style="font-size: 11px;"></i>
                  <p>Keberangkatan</p>
                </a>
              </li>
              <li class="nav-item list-menu-open">
                <a href="<?=base_url()?>monitoring/sortir" class="nav-link ">
                  <i class="fas fa-file nav-icon <?=substr($side, 11) == 'sortir'?'text-dark':''?>" style="font-size: 11px;"></i>
                  <p>Sortir</p>
                </a>
              </li>
              <li class="nav-item list-menu-open">
                <a href="<?=base_url()?>monitoring/monthly_marketing" class="nav-link ">
                  <i class="fas fa-file nav-icon <?=substr($side, 11) == 'monthly_marketing'?'text-dark':''?>" style="font-size: 11px;"></i>
                  <p>Monthly Marketing</p>
                </a>
              </li>
              <li class="nav-item list-menu-open">
                <a href="<?=base_url()?>monitoring/detail_tujuan_marketing" class="nav-link ">
                  <i class="fas fa-file nav-icon <?=substr($side, 11) == 'detail_tujuan_marketing'?'text-dark':''?>" style="font-size: 11px;"></i>
                  <p>Monthly Tujuan Marketing</p>
                </a>
              </li>
              <li class="nav-item list-menu-open">
                <a href="<?=base_url()?>monitoring/monitoring_waktu_perjalanan" class="nav-link ">
                  <i class="fas fa-clock nav-icon <?=substr($side, 11) == 'waktu_perjalanan'?'text-dark':''?>" style="font-size: 11px;"></i>
                  <p>Waktu Perjalanan</p>
                </a>
              </li>
            </ul>
          </li>
          <?php if ($this->session->userdata("LEVEL")<=2 || $this->session->userdata("LEVEL")==5 || $this->session->userdata("DWIPAPURI") == 'Y'): ?>
            <li class="nav-item">
              <a href="<?=base_url()?>security" class="nav-link <?=$side == 'implementasi-security'?'active':''?>">
                <i class="fas fa-user-shield nav-icon"></i>
                <p>Security Check</p>
              </a>
            </li>  
          <?php endif ?>
          
          <?php if ($this->session->userdata("NDV") == 'Y' && $this->session->userdata("LEVEL")<=2): ?>
            <li class="nav-item">
              <a href="<?=base_url()?>implementasi/step_1?notif=" class="nav-link <?=$side == 'implementasi-step'?'active':''?>">
                <i class="fas fa-clipboard-check nav-icon"></i>
                <p>Implementasi</p>
              </a>
            </li>
          <?php elseif($this->session->userdata("DLV") == 'Y' && $this->session->userdata("LEVEL")<=2): ?>
            <li class="nav-item">
              <a href="<?=base_url()?>implementasi/step_1?notif=" class="nav-link <?=$side == 'implementasi-step'?'active':''?>">
                <i class="fas fa-clipboard-check nav-icon"></i>
                <p>Implementasi</p>
              </a>
            </li>
          <?php endif ?>
          <?php if ($this->session->userdata("LEVEL")<=2): ?>
            <li class="nav-item">
              <a href="<?=base_url()?>adjustment" class="nav-link <?=$side == 'implementasi-adjustment'?'active':''?>">
                <i class="fas fa-clipboard-list nav-icon"></i>
                <p>Pengajuan Adjustment</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?=base_url()?>outstanding_otoritas" class="nav-link <?=$side == 'implementasi-os'?'active':''?>">
                <i class="fas fa-hourglass-half nav-icon"></i>
                <p>Outstanding Otoritas</p>
              </a>
            </li>
            <li class="nav-item <?=substr($side, 0, 21)=='implementasi-generate'?'menu-open':''?>">
              <a href="javascript:void(0);" class="nav-link <?=substr($side, 0, 21)=='implementasi-generate'?'active':''?>">
                <i class="nav-icon fas fa-upload"></i>
                <p>
                  Generate
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview menu-open-kps">
                <li class="nav-item list-menu-open">
                  <a href="<?=base_url()?>generate_spj" class="nav-link ">
                    <i class="fas fa-book nav-icon <?=substr($side, 22) == 'spj'?'text-dark':''?>" style="font-size: 11px;"></i>
                    <p>SPJ</p>
                  </a>
                </li>
                <li class="nav-item list-menu-open">
                  <a href="<?=base_url()?>implementasi/generate_kendaraan" class="nav-link ">
                    <i class="fas fa-car nav-icon <?=substr($side, 22) == 'kendaraan'?'text-dark':''?>" style="font-size: 11px;"></i>
                    <p>Kendaraan </p>
                  </a>
                </li>
              </ul>
            </li> 
            
          <?php endif ?>
          <?php if ($this->session->userdata("LEVEL")<=1): ?>
            <li class="nav-item">
              <a href="<?=base_url()?>implementasi/akses_otoritas" class="nav-link <?=$side == 'akses_otoritas'?'active':''?>">
                <i class="fas fa-user-lock nav-icon"></i>
                <p>Akses Otoritas</p>
              </a>
            </li>
          <?php endif ?>
        </ul>
      </nav>  
    <?php endif ?>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
  <div class="sidebar-custom">
    <a href="#" class="btn btn-link text-light"><i class="fas fa-cogs"></i></a>
  </div>
  <!-- /.sidebar-custom -->
</aside>