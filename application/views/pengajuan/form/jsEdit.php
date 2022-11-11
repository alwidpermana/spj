<script type="text/javascript">
	$(document).ready(function(){
		$('#btnNextStart').on('click', function(){
			aturBTNNextEdit('kendaraan')
		})
		$('#btnPrevKendaraan').on('click', function(){
			aturBTNNextEdit('start')
		})
		$('#btnNextKendaraan').on('click', function(){
			aturBTNNextEdit('tujuan')
		})
		$('#btnNextTujuan').on('click', function(){
			aturBTNNextEdit('pic')
		})
		$('#btnPrevTujuan').on('click', function(){
			aturBTNNextEdit('kendaraan')
		})
		$('#btnPrevPIC').on('click', function(){
			aturBTNNextEdit('tujuan')
		})
		$('#btnNextPIC').on('click', function(){
			aturBTNNextEdit('biaya')
		})
		$('#btnPrevBiaya').on('click', function(){
			aturBTNNextEdit('pic')
		})
		$('#btnNextBiaya').on('click', function(){
			aturBTNNextEdit('rencana')
		})
		$('#btnPrevRencana').on('click', function(){
			aturBTNNextEdit('biaya')
		})
		$('#btnNextRencana').on('click', function(){
			aturBTNNextEdit('finish')
		})
		$('#btnPrevFinish').on('click', function(){
			aturBTNNextEdit('rencana')
		})
		aturBTNNextEdit('start')
		

	});
	function aturBTNNextEdit(jenis) {
		switch(jenis){
		case 'start':
			$('.nextKendaraan').addClass("d-none");
			$('.nextTujuan').addClass("d-none");
			$('.nextPIC').addClass("d-none");
			$('.nextBiaya').addClass("d-none");
			$('.nextRencana').addClass("d-none");
			$('.nextStart').removeClass("d-none");
			$('.nextFinish').removeClass("d-none");
		break;
		case 'kendaraan':
			$('.nextKendaraan').removeClass("d-none");
			$('.nextTujuan').addClass("d-none");
			$('.nextPIC').addClass("d-none");
			$('.nextBiaya').addClass("d-none");
			$('.nextRencana').addClass("d-none");
			$('.nextStart').addClass("d-none");
			$('.nextFinish').removeClass("d-none");
		break;
		case 'tujuan':
			$('.nextKendaraan').addClass("d-none");
			$('.nextTujuan').removeClass("d-none");
			$('.nextPIC').addClass("d-none");
			$('.nextBiaya').addClass("d-none");
			$('.nextRencana').addClass("d-none");
			$('.nextStart').addClass("d-none");
			$('.nextFinish').removeClass("d-none");
		break;
		case 'pic':
			$('.nextKendaraan').addClass("d-none");
			$('.nextTujuan').addClass("d-none");
			$('.nextPIC').removeClass("d-none");
			$('.nextBiaya').addClass("d-none");
			$('.nextRencana').addClass("d-none");
			$('.nextStart').addClass("d-none");
			$('.nextFinish').removeClass("d-none");
		break;
		case 'biaya':
			$('.nextKendaraan').addClass("d-none");
			$('.nextTujuan').addClass("d-none");
			$('.nextPIC').addClass("d-none");
			$('.nextBiaya').removeClass("d-none");
			$('.nextRencana').addClass("d-none");
			$('.nextStart').addClass("d-none");
			$('.nextFinish').removeClass("d-none");
		break;
		case 'rencana':
			$('.nextKendaraan').addClass("d-none");
			$('.nextTujuan').addClass("d-none");
			$('.nextPIC').addClass("d-none");
			$('.nextBiaya').addClass("d-none");
			$('.nextRencana').removeClass("d-none");
			$('.nextStart').addClass("d-none");
			$('.nextFinish').removeClass("d-none");
		break;
		case 'finish':
			$('.nextKendaraan').addClass("d-none");
			$('.nextTujuan').addClass("d-none");
			$('.nextPIC').addClass("d-none");
			$('.nextBiaya').addClass("d-none");
			$('.nextRencana').addClass("d-none");
			$('.nextStart').addClass("d-none");
			$('.nextFinish').removeClass("d-none");
		break;
		default:
			$('.nextKendaraan').addClass("d-none");
			$('.nextTujuan').addClass("d-none");
			$('.nextPIC').addClass("d-none");
			$('.nextBiaya').addClass("d-none");
			$('.nextRencana').addClass("d-none");
			$('.nextStart').addClass("d-none");
			$('.nextFinish').removeClass("d-none");
		break;
		
		}
	}
</script>