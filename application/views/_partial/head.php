 <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/png" href="<?php echo base_url(); ?>assets/dist/img/logo.png">
  <title>SPJ | PT. KPS</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="<?=base_url()?>assets/dist/css/font.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?=base_url()?>assets/plugins/fontawesome-free/css/all.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="<?=base_url()?>assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?=base_url()?>assets/dist/css/adminlte.min.css">
  <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/plugins/DataTables_4/datatables.min.css"/>
  <link rel="stylesheet" href="<?=base_url()?>assets/plugins/placeholder-loading-develop/dist/css/placeholder-loading.min.css">
  <style type="text/css">
      /*.navbar-kps{
  background-color: rgb(241, 250, 238);
}*/

.bg-kps{
  background-color: rgb(204, 88, 3);
  color: white;
}
.bg-kps2{
    background-color: rgb(237, 169, 22);
    color:  black;
}
.bg-kps-success{
    background-color: rgb(88, 129, 87);
    color: white;
}
.sidebar-kps{
  background-color: rgb(204, 88, 3);
  border-color: rgb(230, 57, 70);
  /*background-color: rgb(188, 108, 37);*/
}
.bg-orange:hover{
    color:  white !important;
    box-shadow: 0 0 0 0.2rem rgba(252, 191, 73, 0.7) !important;
}
.bg-orange:active{
    color:  white !important;
    box-shadow: 0 0 0 0.2rem rgba(252, 191, 73, 0.7) !important;
}
.bg-orange:focus{
    color:  white !important;
    box-shadow: 0 0 0 0.2rem rgba(252, 191, 73, 0.7) !important;
}
.btn-kps{
  background-color: rgb(204, 88, 3);
  border-color: rgb(252, 191, 73) !important;
  color:  white !important;
  font-size: 12px;
}
.btn-kps-success{
  background-color: rgb(88, 129, 87);
  border-color: rgb(163, 177, 138);
  font-size: 12px;
}
.btn-secondary{
  font-size: 12px !important;  
}
.btn-kps_gray{
    background-color: #6c757d;
    border-color: #6c757d;
    font-size: 15px;
}
.btn-kps-profile{
  border-radius: 30px; 
  background-color: rgb(241, 250, 238); 
  color: white !important;
  border-color: rgb(252, 191, 73);
  font-size: 15px;
}
.text-kps{
  color: rgb(204, 88, 3) !important;
  font-size: 12px;
}
.text-kps2{
    color: rgb(237, 169, 22) !important;
    font-size: 12px;
}
.menu-open-kps{
  /*background-color: rgb(239, 246, 238);*/
  /*border-radius: 5px;*/
  /*text-decoration-color: black;*/
  border-left-style: solid;
  border-left-color: rgb(239, 246, 238);
 

}
.list-menu-open{
     margin-left: 10px !important; 
     
}
.menu_sub{
  border-left-style: solid;
  border-left-color: rgb(239, 246, 238);
  margin-left: 10px !important; 

}
.menu_sub2{
  border-left-style: solid;
  border-left-color: rgb(239, 246, 238);
  margin-left: 10px !important; 

}
.link-kps:focus{
    background-color: rgb(204, 88, 3);
    color: white;
}

body{
    font-size: 11px;
}
.table{
    font-size: 11px;
    width: 100%;
}
/*i{
    font-size: 11px;
}*/
.page-item.active .page-link {
  background-color: rgb(204, 88, 3) !important;
  border: 1px solid white;
  color: white;
}
.page-item .page-link {
  color: rgb(204, 88, 3);
  
}
.tableKPS{
    background-color: rgb(204, 88, 3);
    color: white;
}
.form-control:focus {
    border-color: rgba(204, 88, 3, 0.5);
    /*box-shadow: 0 0 0 0.2rem rgba(132, 44, 54, 0.2);*/
    box-shadow: 0 0 0 0.1rem rgba(204, 88, 3, 0.5) !important;
}
.form-group .form-control-search {
    padding-left: 2.375rem;

}

.form-group .form-control-icon {
  position: absolute;
  z-index: 2;
  display: block;
  width: 2.375rem;
  height: 2.375rem;
  line-height: 2.375rem;
  text-align: center;
  pointer-events: none;
  color: #aaa;
}
.select2-container--default .select2-danger .select2-results__option--highlighted[aria-selected] {
    background-color: rgb(204, 88, 3);
    color: #fff;
}
.select2-results .select2-danger .select2-highlighted {
  background-color: rgb(204, 88, 3);
  color: #fff;
}
.dropButton:active{
    background-color: rgb(204, 88, 3);
    color: #fff;
}
.dropButton:focus{
    background-color: rgb(204, 88, 3);
    color: #fff;
}

  /*.text-drop{
    color: rgb(204, 88, 3);
  }*/
.text-drop:active{
    background-color: rgb(204, 88, 3);
    color: #fff;
}
.text-drop:focus{
    background-color: rgb(204, 88, 3);
    color: #fff;
}
.icheck-kps > input:first-child:checked + input[type="hidden"] + label::before {
  background-color: #dc3545;
  border-color: #dc3545;
}
.preloader{
    background-color: #fff;
    position: fixed;
    height: 100%;
    width: 100%;
    left: 0;
    top: 0;
    z-index: 9999;
    transition: 0.8s ease opacity;
}
.preloader2{
    background-color: #fff;
    position: fixed;
    height: 100%;
    width: 100%;
    left: 0;
    top: 0;
    z-index: 9999;
    transition: 0.8s ease opacity;
}
.preloader-no-bg{
    /*background-color: #fff;*/
    position: fixed;
    height: 100%;
    width: 100%;
    left: 0;
    top: 0;
    z-index: 9999;
    transition: 0.8s ease opacity;
}

.loader{
    position: fixed;
    height: 75px;
    width: 75px;
    margin:auto;
    left:0;
    right:0;
    top:0;
    bottom:0;

}
.spinner{
    width: 75px;
    height: 75px;
    margin: 0;
    border-top: 10px solid rgb(204, 88, 3);
    box-shadow: 4px 4px 5px #d2d2d2 inset;
    border-right: 10px solid transparent;
    border-radius: 50%;
    animation: 0.8s spin linear infinite;
}
.spinner-2{
    width: 75px;
    height: 75px;
    margin: 0;
    border-top: 10px solid rgb(237, 169, 22);
    border-left: 10px solid transparent;
    border-radius: 50%;
    position: absolute;
    top: 0;
    animation: 0.8s spin-2 linear infinite;
}
.bg-success{
    background-color: #8cb369 !important;
}
.bg-danger{
    background-color: #B36969 !important;
}
.bg-warning{
    background-color: #f9dc5c !important;
}
@keyframes spin{
    from{ transform: rotate(0deg); }
    to{ transform: rotate(360deg); }
}
@keyframes spin-2{
    from{ transform: rotate(360deg); }
    to{ transform: rotate(0deg); }
}
</style>
