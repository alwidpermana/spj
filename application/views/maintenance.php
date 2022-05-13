<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/jquery-ui-1.12.1.custom/jquery-ui.min.css">
  <?php $this->load->view("_partial/head")?>
  <style type="text/css">
    body{
      background: rgb(237, 169, 22);  /* fallback for old browsers */
      background: -webkit-linear-gradient(to right, rgb(178, 58, 72), rgb(237, 169, 22));  /* Chrome 10-25, Safari 5.1-6 */
      background: linear-gradient(to right, rgb(178, 58, 72), rgb(237, 169, 22)); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */

    }
    .tengah{
      position: fixed;
      height: 350px;
      width: 500px;
      margin:auto;
      left:0;
      right:0;
      top:0;
      bottom:0;

    }
    .gambarMaintenance{
       box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
       border-radius: 25px;
    }

  </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed sidebar-collapse layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">
 <div class="tengah">
   <img src="<?=base_url()?>assets/image/maintenance.png" class="img-thumbnail gambarMaintenance" width="100%" style="">
 </div>
</div>
<!-- jQuery -->
<script src="<?=base_url()?>assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?=base_url()?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="<?=base_url()?>assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="<?=base_url()?>assets/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script type="text/javascript" src="<?= base_url() ?>assets/plugins/DataTables_4/datatables.min.js"></script>
<!-- <script src="<?=base_url()?>assets/dist/js/demo.js"></script> -->
<script src="<?= base_url() ?>assets/dist/js/code/main.js"></script>
<script src="<?= base_url()?>assets/plugins/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
    $('.select2').select2({
        'width': '100%',
    });
    
    // $('.ph-item').fadeOut('slow');
    // $('.test').fadeIn('slow').removeClass('d-none');
    
    // make_skeleton().fadeOut();
   

  })
  
  

</script>
<!-- FootJS -->
</body>
</html>
