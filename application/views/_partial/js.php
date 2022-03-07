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
<script type="text/javascript">
	$(document).ready(function(){
		$('.btnUser').on('click', function(){
			$('#modal-profil').modal('show');
		})
		redirectLogin();
	});
	function redirectLogin() {
		var nik = '<?=$this->session->userdata("NIK")?>';
		if (nik == '') {
			window.location.href= '<?=base_url("Auth/Login")?>';
		}
	}
</script>