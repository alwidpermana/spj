<div class="modal fade" id="modal-profil" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-md modal-dialog-scrollable" role="document">
    <div class="modal-content"  style="background-color: rgb(204, 88, 3); color: white;">
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <center>
              <div class="image">
                <!-- <img src="<?=base_url()?>assets/image/avatar/<?=$this->session->userdata("AVATAR")?>" class="img-circle elevation-2 photo_user" alt="User Image"> -->
                <?php 
                $username = $this->session->userdata("username");
                if ($this->session->userdata("photo") == ''): ?>
                    
                <?php else: ?>
                  <img src="http://192.168.0.213:8080/FOTO/<?=$this->session->userdata("photo")?>" class="img-circle elevation-2 photo_user" alt="User Image">    
                <?php endif ?>
              </div>
            </center>
          </div>
        </div>
        <br>
        <div class="row">
          <div class="col-md-12">
            <center>
              <h4><?=$this->session->userdata("NAMA")?></h4>
            </center>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <center>
              <h4><?=$this->session->userdata("JABATAN")?></h4>
            </center>
          </div>
        </div>
        <br>
        <div class="row">
          <div class="col-md-4">
            <div class="row">
              <div class="col-md-12 text-center">
                <span style="font-size: 14px"><b>Departement</b></span>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-md-12 text-center">
                <h6><?=$this->session->userdata("DEPARTEMEN")?></h6>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="row">
              <div class="col-md-12 text-center">
                <span style="font-size: 14px"><b>Seksi</b></span>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-md-12 text-center">
                <h6><?=$this->session->userdata("SEKSI")?></h6>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="row">
              <div class="col-md-12 text-center">
                <span style="font-size: 14px"><b>Divisi</b></span>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-md-12 text-center">
                <h6><?=$this->session->userdata("DIVISI")?></h6>
              </div>
            </div>
          </div>
        </div>
        <br>
        <br>
        <div class="row">
          <div class="col-md-2"></div>
          <div class="col-md-8">
            <a href="<?=base_url()?>Auth/Profile" class="btn bg-orange btn-kps-profile btn-blok form-control">
              View Profile
            </a>
          </div>
          <div class="col-md-2"></div>
          
        </div>
      </div>
    </div>
  </div>
</div>
<footer class="main-footer">
  <!-- <div class="float-right d-none d-sm-block">
    <b>Version</b> 3.1.0-rc
  </div> -->
  <strong>Copyright &copy; 2022 <span class="text-orange">PT. Karya Putra Sangkuriang</span></strong>
</footer>