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
		notifNGSecurity();
	});
	function redirectLogin() {
		var nik = '<?=$this->session->userdata("NIK")?>';
		if (nik == '') {
			window.location.href= '<?=base_url("Auth")?>';
		}
	}
	function notifNGSecurity() {
		var level = '<?=$this->session->userdata("LEVEL")?>';
		var side = '<?=$side?>';
		if (level >= 0) {
			if (side !='monitoring-ng' && side != 'implementasi-security') {
				$.ajax({
					type:'get',
					dataType:'json',
					url:url+'/Monitoring/getNotifNGSecurity',
					cache: false,
					async:true,
					success:function(data){
						if (parseInt(data)>0) {
							Swal.fire({
							  title: '<strong>Terdapat SPJ yang NG</strong>',
							  icon: 'warning',
							  html:
							    'Cek SPJ nya di ' +
							    '<a href="<?=base_url()?>monitoring/ng_security">sini</a>',
							  showCloseButton: false,
							  showCancelButton: false,
							  focusConfirm: false,
							  
							})
						}
					},
					error:function(data){
						console.log(data)
					}
				})	
			}
			
		}
	}
</script>