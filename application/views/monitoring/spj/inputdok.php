<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>





    
    
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
         <script type="text/javascript" src="<?php echo base_url(); ?>easyui/themesa/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>easyui/themesa/jquery.easyui.min.js"></script>
    
         <link href="<?php echo base_url(); ?>bs/css/bootstrap.min.css" rel="stylesheet" />
    <script src="<?php echo base_url(); ?>bs/js/bootstrap.min.js"></script>
    
    
  	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>easyui/themesa/bootstrap/easyui.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>easyui/themesa/icon.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>easyui/demo/demo.css">




    <script type="text/javascript" src="<?php echo base_url(); ?>assets/autoCurrency.js"></script>    
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/numberFormat.js"></script>    


	<script src="<?php echo base_url(); ?>assets/sweetalert/lib/sweet-alert.min.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/sweetalert/lib/sweet-alert.css">

<script type="text/javascript" src="<?php echo base_url(); ?>assets/jquery.maskMoney.min.js"></script>
    <script type="text/javascript">
          total_detail=0;  
  var idx      = 0;
  var tidx     = 0;
    var detIndex = 0;
    var id       = 0;
    var status   = '0';
  var no_advise= '';
  var no_sp2d  = '';
  var nilai_rinci=0;
  var total=0;
  var cek =1;
  cnilai=0;
     total_rinci=0;
    $(document).ready(function() {
		$( "#dialog-modal-ccc" ).dialog({
            height: 200,
            width: 300,
            modal: true,
            autoOpen:false,
		buttons: '#dlg-buttons'
			
        }); 
		
  $("#dialog-modal-ccc").dialog('close');
    
		 $('#tgl_bsthp').datebox().datebox('calendar').calendar({
				validator: function(date){
					var now = new Date();
					var d1 = new Date(now.getFullYear(), now.getMonth(), now.getDate()-10);
					var d2 = new Date(now.getFullYear(), now.getMonth(), now.getDate());
					return d1<=date && date<=d2;
					
				}
			});
			
			
		 $("#alfi").hide();
		 isibulan();
		 
		 $('#suplier').combogrid({  
			panelWidth:400,
			panelHeight:200,   
				idField:'kodes',                    
				textField:'nama',
				url: '<?php echo base_url(); ?>/index.php/transaksi/supplier', 
				mode:'remote',  
				fitColumns:true,  
				columns:[[   
					{field:'kodes',title:'id',align:'left',width:100} ,
					{field:'nama',title:'TUjuan',align:'left',width:200}  
				]],
				onSelect:function(rowIndex,rowData){
				   kodes=rowData.kodes;
				   suplier1=rowData.nama;
			
				}   
         });
		 
		  $("#c_ULANG").linkbutton("disable");
		
		
		 $('#dg3').datagrid({  
       //  url: '<?php echo base_url(); ?>/index.php/transaksi/load_bsthp',
      idField:'no_bsthp2',            
      rownumbers:"true", 
      fitColumns:"true",
      singleSelect:"true",  
	    autoRowHeight:"false",
      //pagination:"true",
      nowrap:"true",                                                  
            columns:[[                
                 {field:'no_bsthp2',title:'No.Bsthp',width:100,align:"center"},            
{field:'norekaman2',title:'Norekaman',width:100,align:"center"},
{field:'alasan',title:'alasan',width:100,align:"center"},
{field:'userlog',title:'userlog',width:100,align:"center"}
				

        
            ]]
        }); 
		
		
		
		$('#dg3').datagrid('reload'); 

		
		
		
																					
																					
		
		$('#seksi').combogrid({  
			panelWidth:500,  
			url: '<?php echo base_url(); ?>/index.php/transaksi/area',    
				idField:'namaarea',                    
				textField:'namaarea',
				mode:'remote',  
				fitColumns:true,  
				columns:[[  
					{field:'namaarea',title:'Area',width:60}, 
					 
				]],
				onSelect:function(rowIndex,rowData){
				  
				   namaarea=rowData.namaarea;
			if(namaarea=='supplier'){
				   document.getElementById("label").innerHTML=namaarea;
				   $("#alfi").show(); 
				   //ambil_nomor_supplier();
			}else{
			$("#alfi").hide();	
			document.getElementById("label").innerHTML='';
				$("#suplier").combogrid("setValue",'');
					$("#suplier").combogrid("clear");
					//ambil_nomor();
			}
				
				}   
         });     
		 
            $("#accordion").accordion();            
           $( "#dialog-modal" ).dialog({
                height: 500,
                width: 1300,
                modal: true,
                autoOpen:false                
            });
			  $("#dialog-modal").dialog('close');
			  
             $( "#dialog-cetak" ).dialog({
                height: 160,
                width: 400,
                modal: true,
                autoOpen:false                
            });
			
			$("#dialog-cetak").dialog('close');
			
			 $( "#dialog-modal-aaa" ).dialog({
            height: 500,
            width: 500,
            modal: true,
            autoOpen:false
        });

$("#dialog-modal-aaa").dialog('close');


            ambil_nomor();
        });    
     
     $(function(){ 
    $('#dg').datagrid({
      url: '<?php echo base_url(); ?>/index.php/transaksi/load_bsthp',
      idField:'id',   
	  	toolbar: '#ddd',         
      rownumbers:"true", 
      fitColumns:"true",
      singleSelect:"true",
	  rowStyler: function(index,row){
    if (row.st==1){
      return 'background-color:#DCDCDC;';
    }else if(row.st==3){
		 return 'background-color:yellow;';
	}
  },
      autoRowHeight:"false",
      pagination:"true",
      nowrap:"true",                       
      columns:[[
{field:'no_bsthp',title:'Nomor BSTHP',align:"justify"},
{field:'tgla',title:'Tanggal',align:"center"},
{field:'area',title:'Dari',align:"left"},
{field:'suplier',title:'suplier',align:"left"},
{field:'tujuan',title:'Tujuan',align:"left"},
{field:'total',title:'Total', align:"right"},
{field:'keterangan',title:'Keterangan', align:"left"},
{field:'urut',title:'urut', align:"left"},
{field:'userterima',title:'userterima', align:"left"},
{field:'inputby',title:'inputby', align:"left"},
{field:'tglterima',title:'Tanggal Terima', align:"left"},
{field:'revno',title:'revno', align:"left"},
      ]],
      onSelect:function(rowIndex,rowData){
        no_bsthp=rowData.no_bsthp;
        tgl_bsthp=rowData.tgl_bsthp;
        tgla=rowData.tgla;
        total1=rowData.total1;
        total=rowData.total;
		stat=rowData.st;
		tujuan=rowData.tujuan;
		cshift=rowData.shift;
		dikirim=rowData.dikirim;
		diterima=rowData.diterima;
		dibuat=rowData.dibuat;
				dari=rowData.area;
				suplier=rowData.suplier;
				keterangan=rowData.keterangan;
				urut=rowData.urut;
				revno=rowData.revno;
				
		
		cek=0;
		 $("#cetak").linkbutton("enable");
        get(no_bsthp,tgla,total,tujuan,cshift,dikirim,diterima,dibuat,dari,suplier,keterangan,urut,revno);
		  tombol(stat);  
      },
      onDblClickRow:function(rowIndex,rowData){ 
        cek=0;
		 $("#cetak").linkbutton("enable");
		no_bsthp=rowData.no_bsthp;
        tgl_bsthp=rowData.tgl_bsthp;
        tgla=rowData.tgla;
        total1=rowData.total1;
        total=rowData.total;
		stat=rowData.st;
		tombol(stat);
		tujuan=rowData.tujuan;
		cshift=rowData.shift;
		dikirim=rowData.dikirim;
		diterima=rowData.diterima;
		dibuat=rowData.dibuat;
		dari=rowData.area;
		suplier=rowData.suplier;
		keterangan=rowData.keterangan;
		urut=rowData.urut;
			revno=rowData.revno;
		
        get(no_bsthp,tgla,total,tujuan,cshift,dikirim,diterima,dibuat,dari,suplier,keterangan,urut,revno);
load_detail(no_bsthp);
        
        section2();
      }
    });
    
        
  
		
  $('#dibuat').combogrid({  
			panelWidth:500,   
				idField:'nik',                    
				textField:'nm',
				url: '<?php echo base_url(); ?>/index.php/transaksi/inspektor', 
				mode:'remote',  
				fitColumns:true,  
				columns:[[   
					{field:'nik',title:'NIK',width:60},  
					{field:'nm',title:'NAMA',align:'left',width:100}  
				]],
				onSelect:function(rowIndex,rowData){
				   nik=rowData.nik;
				   nama=rowData.nm;
				 // $("#nmnik").val(nama);
				//   ambil_harga();
				}   
         });
		 
		 
		 $('#tujuan').combogrid({  
			panelWidth:300,
			panelHeight:150,   
				idField:'nm',                    
				textField:'nm',
				url: '<?php echo base_url(); ?>/index.php/transaksi/tujuana', 
				mode:'remote',  
				fitColumns:true,  
				columns:[[    
					
					{field:'nm',title:'TUjuan',align:'left',width:100}  
				]],
				onSelect:function(rowIndex,rowData){
				  
				   tujuan=rowData.nm;
			if(cek=='1'){	
				
if(tujuan=='AVS'||tujuan=='IMR'||tujuan=='CVM'||tujuan=='Joint Slim' ||tujuan=='Extruder Manual'||tujuan=='Extrusion PVC'||tujuan=='Extrusion UHF'||tujuan=='Joint Press' ){
				ambil_nomorNolot(tujuan);
				}else{
					ambil_nomor();
					ambil_nomor2222(tujuan);
				}
			}
				}   
         });
		 $('#dikirim').combogrid({  
			panelWidth:500,   
				idField:'nik',                    
				textField:'nm',
				url: '<?php echo base_url(); ?>/index.php/transaksi/inspektor', 
				mode:'remote',  
				fitColumns:true,  
				columns:[[   
					{field:'nik',title:'NIK',width:60},  
					{field:'nm',title:'NAMA',align:'left',width:100}  
				]],
				onSelect:function(rowIndex,rowData){
				   nik=rowData.nik;
				   nama=rowData.nm;
				//  $("#nmnik").val(nama);
				//   ambil_harga();
				}   
         });
		 
		 $('#diterima').combogrid({  
			panelWidth:500,   
				idField:'nik',                    
				textField:'nm',
				url: '<?php echo base_url(); ?>/index.php/transaksi/inspektor', 
				mode:'remote',  
				fitColumns:true,  
				columns:[[   
					{field:'nik',title:'NIK',width:60},  
					{field:'nm',title:'NAMA',align:'left',width:100}  
				]],
				onSelect:function(rowIndex,rowData){
				   nik=rowData.nik;
				   nama=rowData.nm;
				//  $("#nmnik").val(nama);
				//   ambil_harga();
				}   
         });		   	 		
        
        $('#dg1').datagrid({  
            toolbar:'#toolbar',
            rownumbers:"true",            
            singleSelect:"true",
            autoRowHeight:"true",
            nowrap:"true",
            onSelect:function(rowIndex,rowData){                    
                    idx = rowIndex;
					
          no_barang  =rowData.norekaman;
		 // alert(no_barang);
          nilai_rinci=rowData.qty;
            },                                                     
            columns:[[                
{field:'norekaman',title:'No.rekaman',width:220,align:"center", sortable:"true"},            
{field:'codeitemM',title:'Kode Item',width:100,align:"center"},
{field:'nolot',title:'No.lot',width:70,align:"center"},
{field:'qty',title:'QTY',width:70,align:"center"},
{field:'unit',title:'Unit',width:70,align:"center"},
{field:'tgla',title:'Tgl Produksi',width:70,align:"center"},
{field:'tglb',title:'Tgl Inspek',width:70,align:"center"},
{field:'inspektor',title:'Inspektor',width:60,align:"center"},
{field:'operator',title:'Operator',width:70,align:"center"},
{field:'suboperator',title:'Sub Operator',width:70,align:"center"},
{field:'area',title:'area',width:70,align:"center"}
        
            ]]
        }); 
		
		
		
		
					
																			
																			
		// $('#dg3').datagrid('loadData', {"total":0,"rows":[]});

    $('#ttd').combogrid({  
      panelWidth:500,  
      url: '<?php echo base_url(); ?>/index.php/rka/pilih_ttd',  
        idField:'nip',                    
        textField:'nama',
        mode:'remote',  
        fitColumns:true,  
        columns:[[  
          {field:'nip',title:'NIP',width:60},  
          {field:'nama',title:'NAMA',align:'left',width:100}  
        ]],
        onSelect:function(rowIndex,rowData){
        nip = rowData.nip;
        
        }   
         });
            
    });        
    
   
   function ambil_nomorNolot(tujuan){
				
    $.ajax({
      type: "POST",
      url: '<?php echo base_url(); ?>/index.php/transaksi/no_bsthp_otomatis_nolot',
      data: ({tujuan:tujuan}),
      dataType:"json",
        success: function(data){
    
       $("#no_bsthp").val(data.no);
      }
    });
  }
  
    
    function load_detail(ww){
		$('#dg1').datagrid('loadData', {"total":0,"rows":[]});
		
    $('#dg1').datagrid({
      url: '<?php echo base_url(); ?>/index.php/transaksi/load_dbsthp',
            queryParams:({no:ww})
    });
	
	cek=0;
	
$('#cancelaja').linkbutton('disable');
$('#buatanmanusia').linkbutton('disable');
$('#min').linkbutton('disable');

     }
  


    function kembali(){ 
         $(document).ready(function(){    
               $('#sectiona').accordion('select', 0);
       $('#dg').datagrid('reload');
         });

    }
      
     function tombol(st){  
  if (st=='1'){
    $('#save').linkbutton('disable');
    $('#hapus').linkbutton('disable');
    $('#plus').linkbutton('disable');
    $('#min').linkbutton('disable'); 
	 $("#buatanmanusia").linkbutton('disable'); 
   $("#barcode").attr("disabled",true);
    document.getElementById("p1").innerHTML="Sudah di serahkan...!!!";
	
  } else {
    $('#save').linkbutton('enable');
    $('#hapus').linkbutton('enable');
    $('#plus').linkbutton('disable');
    $('#min').linkbutton('enable'); 
	  $("#buatanmanusia").linkbutton('enable');
$("#barcode").attr("disabled",true);
  
    document.getElementById("p1").innerHTML="";
  }
}

     function section2(){
         $(document).ready(function(){                
            $('#sectiona').accordion('select', 1);
               
         });    
     }
       
     
    function get(no_bsthp,tgla,total,tujuan,cshift,dikirim,diterima,dibuat,dari,suplier,keterangan,urut,revno){
		
      $("#shift").val(cshift);
	$("#tujuan").combogrid("setValue",tujuan);
	$("#dikirim").combogrid("setValue",dikirim);
	$("#dibuat").combogrid("setValue",dibuat);
	$("#diterima").combogrid("setValue",diterima);
		$("#suplier").combogrid("setValue",suplier);
	
   $("#seksi").combogrid("setValue",dari);
        $("#no_bsthp").val(no_bsthp);
    $("#tgl_bsthp").datebox("setValue",tgla);
    $("#total1").val(total);
    $("#total").val(total);
	 $("#revno").val(revno); 
	 $("#keterangan").val(keterangan);
	  $("#no_urut").val(urut);
	   document.getElementById("label3").innerHTML="";
    }
    
   
    
 
    
  
  var sell_sp2d = new Array();
  var max_sp2d  = 0;

    function getcek_sp2d(){
      var ids   = [];  
    var a     = null;
    var rows  = $('#dg2').datagrid('getSelections');  
     $('#dg2').datagrid('selectRow', rowIndex);
    for(var i=0; i<rows.length; i++){  
        a       = rows[i].ck;
      max_sp2d = i;
      if (a!=null){
        sell_sp2d[i]=a-1;
      }else{
        sell_sp2d[i]=1000;      
      }
    }  
    }
    
  function Unselectall_sp2d(){
    $('#dg2').datagrid('unselectAll');
    $('#dg1').datagrid('unselectAll');
   }
     
     function selectRecord_sp2d(rec){
    $('#dg2').datagrid('selectRecord',rec);
   }

   function setcek_sp2d(){
    for(var i=0; i<max+1; i++){ 
      if (sell_sp2d[i]!=1000){
        selectRecord_sp2d(sell_sp2d[i]);
      }
    }     
   }

  function selectall_sp2d(){
    
   }


    function keluar(){
        $("#dialog-modal").dialog('close');
        $("#dialog-cetak").dialog('close');
    }    

    

 function hapus(){
	 
	 
var cno_advise = $('#no_bsthp').val();//document.getElementById('no_bsthp').value;
        var urll = '<?php echo base_url(); ?>index.php/transaksi/hapus_bsthp';
    swal({
      title: "Apakah Anda Yakin?",
      text: "Akan Menghapus norekaman "+cno_advise+"!",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "Yes, delete it!",
      cancelButtonText: "No, cancel!",
      closeOnConfirm: false,
      closeOnCancel: false
    },
    function(isConfirm){
      if (isConfirm) {
      $(document).ready(function(){
      $.ajax({url:urll,
           dataType:'json',
           type: "POST",    
             data:({no_ad:cno_advise}),
           success:function(data){
              status = data.pesan;
              if (status=='1'){
                swal("Deleted!", "Your imaginary file has been deleted.", "success"); 
                kembali();
                 $('#dg').datagrid('reload');

              } else if(status=='9999999999') {
				  swal("Oops...", "anda bukan pemilik akun!", "error");
			  }else{
                swal("Oops...", "Something went wrong!", "error");
              }        
           }
           
          });           
      });
      } else {
        swal("Cancelled", "Your imaginary file is safe :)", "error");
      }
    });   
    }



   
   
   
   
   
  
  function save_detail(x){
      var kim=x;
      var cno = $('#no_bsthp').val();//document.getElementById('no_bsthp').value;
    var cnomor2 = $('#no_bsthp').val();//document.getElementById('no_bsthp').value;
        var ctgl = $('#tgl_bsthp').datebox('getValue');
var userlog ="<?php echo $this->session->userdata('pcNama');?>";
var ina ="insert into tr_bsthpD(no_bsthp,norekaman,codeitemM,nolot,qty,unit,tglproduksi,tglinspek,inspektor,operator,suboperator,userlog,inputon,area) values"

    if (kim =='1'){
            $('#dg1').datagrid('selectAll');
            var rows = $('#dg1').datagrid('getSelections');           
      for(var p=0;p<rows.length;p++){
  cnorekaman  = rows[p].norekaman;
 ccodeitemM  = rows[p].codeitemM;
 cnolot = rows[p].nolot;
 cqty = rows[p].qty;
 cunit = rows[p].unit;
 ctgla = rows[p].tgla;
 ctglb = rows[p].tglb;
 cinspektor = rows[p].inspektor;
 coperator = rows[p].operator;
 csuboperator = rows[p].suboperator;
  area = rows[p].area;

              if (p>0) {
                csql = csql+ina+"('"+cno+"','"+cnorekaman+"','"+ccodeitemM+"','"+cnolot+"','"+cqty+"','"+cunit+"','"+ctgla+"','"+ctglb+"','"+cinspektor+"','"+coperator+"','"+csuboperator+"','"+userlog+"',getDate(),'"+area+"')";
                } else {
                csql = ""+ina+"('"+cno+"','"+cnorekaman+"','"+ccodeitemM+"','"+cnolot+"','"+cqty+"','"+cunit+"','"+ctgla+"','"+ctglb+"','"+cinspektor+"','"+coperator+"','"+csuboperator+"','"+userlog+"',getDate(),'"+area+"')";                                            
                }    
      }
      
       $(document).ready(function(){
                $.ajax({
                    type: "POST",    
                    dataType:'json',                    
                    data: ({tabel:'tr_bsthpD',no:cno,sql:csql,nomorx:cnomor2,ccek:cek}),
                    url: '<?php echo base_url(); ?>/index.php/transaksi/simpan_bsthp',
                    success:function(data){
						 status = data.pesan; 
						 simpan_serlok(status);
						 
						 
                          $('#dg1').datagrid('unselectAll');
                    }                                        
                });
            });                       
        } 
  
  }



   function simpan_serlok(x){
var kim=x; 
var area=$("#seksi").combogrid("getValue");
var cno =$('#no_bsthp').val();// document.getElementById('no_bsthp').value;
var csup=$("#suplier").combogrid("getValue"); 
//var userlog ="<?php echo $this->session->userdata('pcNama');?>";
var tujuan=$("#tujuan").combogrid("getValue");
  
if(kim=='1'){	
		 $("#dialog-modal-aaa").dialog('open'); 		
    $.ajax({
      type: "POST",
      url: '<?php echo base_url(); ?>/index.php/transaksi/simpan_serlok',
      data: ({no:cno,area:area,tujuan:tujuan,suplier:csup}),
      dataType:"json",
        success: function(data){
			   status = data.pesan;
			 
          if(status =='1'){
			  print();
 $("#cetak").linkbutton("enable");
     $("#dialog-modal-aaa").dialog('close'); 
	  swal("Terkirim!", "Your imaginary file has been Save.", "success");
		  }else{
			//alert(status);  
			
			 swal("Oops...", status, "error");
			      $("#dialog-modal-aaa").dialog('close'); 
			 exit();
		  }
      }
    });
	
}
  }
  
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////baru

   function kosong(){
	   $("#dedetrisna").attr("checked",false);
	    $("#cetak").linkbutton("disable");
	   $("#barcode").attr("disabled",true);
	    $('#plus').linkbutton('disable');
		 document.getElementById("label3").innerHTML="";
document.getElementById("p1").innerHTML="";
  tombol(0);
total_detail=0;  
ambil_nomor();
        cdate = '<?php echo date("Y/m/d"); ?>';        
      //  $("#no_bsthp").val('');
    $("#tgl_bsthp").datebox("setValue",cdate);
    $("#total").val(0); 
	    $("#total1").val(0); 
		  $("#revno").val(0); 
    cek=1;
    $('#dg1').datagrid('loadData', {"total":0,"rows":[]});
	$("#shift").val('');
		$("#no_urut").val('');
	$("#tujuan").combogrid("setValue",'');
	$("#dikirim").combogrid("setValue",'');
	$("#dibuat").combogrid("setValue",'');
	$("#diterima").combogrid("setValue",'');
		$("#seksi").combogrid("setValue",'');
	$("#suplier").combogrid("setValue",'');
	
	      $("#keterangan").val('');
$("#no_bsthp").attr("disabled",false);		
$("#tgl_bsthp").datebox("enable",true);
$("#dibuat").combogrid("enable",true);
$("#seksi").combogrid("enable",true);
$("#dikirim").combogrid("enable",true);
$("#diterima").combogrid("enable",true);
$("#shift").attr("disabled",false);	
$("#tujuan").combogrid("enable",true);
$("#suplier").combogrid("enable",true);
$("#barcode").attr("disabled",true);
//$('#plus').linkbutton('enable');
$("#keterangan").attr("disabled",false);

    }


function batalan(){
		
	     
$("#no_bsthp").attr("disabled",false);		
$("#tgl_bsthp").datebox("enable",true);
$("#dibuat").combogrid("enable",true);
$("#dikirim").combogrid("enable",true);
$("#diterima").combogrid("enable",true);
$("#seksi").combogrid("enable",true);
$("#shift").attr("disabled",false);	
$("#tujuan").combogrid("enable",true);
$("#barcode").attr("disabled",true);
$('#plus').linkbutton('disable');
$("#suplier").combogrid("enable",true);
$("#keterangan").attr("disabled",false);

	}
	
    function barang(){
		<?php $madeby     = $this->session->userdata('pcNama');
	 ?>
		 var pcnama ="<?php echo $madeby;?>";
	 
	  if( pcnama=='00599' ){
		  
		  alert("Maaf Tidak Ada Akses !!!  ");
		  exit();
		  
	  }
	 	//  $("#nmnik").val(nama);
				//   ambil_harga();
				
				
		var area=$("#seksi").combogrid("getValue");
    var no_bsthp=$('#no_bsthp').val();//document.getElementById('no_bsthp').value;
	var sp2=$("#suplier").combogrid("getValue");
    if(no_bsthp==''){
      alert('No B S T H P  Tidak Boleh Kosong !!!!');
      document.getElementById("no_bsthp").focus();  
      exit();
    }else{
      $("#dialog-modal").dialog("open");
      $("#txt_std").searchbox("setValue",''); 
      $("#dg1").datagrid("unselectAll");
      $("#dg1").datagrid("selectAll");
      var rows   = $("#dg1").datagrid("getSelections");
      var jrows  = rows.length ;
      zfnosp  = '';
      zknosp = '';
        
 
	  $('#dg2').datagrid('loadData', {"total":0,"rows":[]});
	  
      $('#dg2').datagrid({
      url: '<?php echo base_url(); ?>/index.php/transaksi/ambil_barang',
      queryParams: ({rekaman:zfnosp,area:area,sp:sp2}),
      idField       : 'id',
      pagination    : false,
      rownumbers    : true, 
      remoteSort    : false,
      multiSort     : true,
      fitColumns    : false,
      singleSelect  : false,
      columns       : [[
      {field:'norekaman',title:'No.rekaman',align:"center"},            
{field:'codeitemM',title:'Kode Item',align:"center"},
{field:'nolot',title:'No.lot',align:"center"},
{field:'qty',title:'QTY',align:"center"},
{field:'unit',title:'Unit',align:"center"},
{field:'tgla',title:'Tgl Produksi',align:"center"},
{field:'tglb',title:'Tgl Inspek',align:"center"},
{field:'inspektor',title:'Inspektor',align:"center"},
{field:'operator',title:'Operator',align:"center"},
{field:'suboperator',title:'Sub Operator',align:"center"},
{field:'area',title:'Area',align:"center"},
{field:'ck',        title:'ck',           checkbox:true}
               ]]
      });  
      selectall_sp2d();
      }
     }   
  

      function append_save(){
    var no_bsthp = $('#no_bsthp').val();//document.getElementById('no_bsthp').value;
	 var area=$("#seksi").combogrid("getValue");
	  var sp2=$("#suplier").combogrid("getValue");
 total_detail=0;
    var ids  = [];   
     $("#dialog-modal-aaa").dialog('open'); 
    var rows = $('#dg2').datagrid('getSelections'); 
    for(var i=0; i<rows.length; i++){  

var cnorekaman  = rows[i].norekaman;
var cqty = rows[i].qty;


            $("#dg1").datagrid("unselectAll");
            $('#dg1').datagrid('selectAll');
            var rows_2 = $('#dg1').datagrid('getSelections') ;
                jgrid  = rows_2.length ;
           var id     = jgrid  ;
       


 $.ajax({
      type: "POST",
      url: '<?php echo base_url(); ?>/index.php/transaksi/barcodebsthp',
      data: ({no:cnorekaman,bsthp:no_bsthp,area:area,sp:sp2}),
      dataType:"json",
        success: function(data){

$('#dg1').datagrid('appendRow',{norekaman:data.norekaman,
codeitemM:data.codeitemM,		
nolot:data.nolot,		
qty:data.qty,		
unit:data.unit,		
tgla:data.tgla,		
tglb:data.tglb,		
inspektor:data.inspektor,		
operator:data.operator,		
suboperator:data.suboperator,
area:data.area});  



      }
    });
	


$("#dg1").datagrid("unselectAll");
var f_total= eval(document.getElementById('total1').value);
      

      if(cek=='1'){
         total_rinci = eval(cqty);
            total_detail = f_total + total_rinci;
		  $("#total").val(number_format(total_detail,0,',','.'));
          $("#total1").val(total_detail);
          
      }else{
        var total_rinci = eval(cqty);
        total_rinci = total_rinci + f_total; 
        $("#total").val(number_format(total_rinci,0,',','.'));
        $("#total1").val(total_rinci);
      }
            $("#dialog-modal").dialog("close");
        } 
 $("#dialog-modal-aaa").dialog('close');    
 $("#dialog-modal").dialog("close"); 
  }


    function hapus_barang(){ 

		
		  $.messager.confirm('opsss!!', 'Yakin Ingin Menghapus Data??', function(r){
 if (r){
	 
	var no_bsthp = $('#no_bsthp').val();//document.getElementById('no_bsthp').value;
    var kim  = $('#total1').val();//document.getElementById('total1').value;
        var urll = '<?php echo base_url(); ?>index.php/transaksi/hapus_trdbast';
        $(document).ready(function(){
      $.ajax({url:urll,
       dataType:'json',
       type: "POST",    
       data:({no_ad:no_bsthp,no_sp:no_barang}),
       success:function(data){
        status = data.pesan;
		
		if(status=='9999999999'){
			  swal("Oops...", "anda bukan pemilik akun!", "error");
			  exit();
		}
		
        if (status=='1'){  
          $('#dg1').datagrid('deleteRow',idx); 
          $("#total1").val(kim-nilai_rinci);
          $("#total").val(number_format(kim-nilai_rinci,2,",","."));
          }       
        }
       
      });           
        });
		}
     });
       // }   
    }
    
     function cari_sp2d(x){
	var area=$("#seksi").combogrid("getValue");
	var sp2=$("#suplier").combogrid("getValue");
    $(function(){
		$('#dg2').datagrid('loadData', {"total":0,"rows":[]});
		
     $('#dg2').datagrid({
      loadMsg:"Tunggu Sebentar....!!",
      url: '<?php echo base_url(); ?>/index.php/transaksi/ambil_barang',
      queryParams:({cari:x,rekaman:zfnosp,area:area,sp:sp2})
      });        
     });
  
  }
  
  
    function cari(){
    var kriteria =$('#txtcari').val();// document.getElementById("txtcari").value;
	    var tahun = $('#tahun').val();// document.getElementById("tahun").value;
		  var bulan =$('#bulan').val();//  penerimaan_disinidocument.getElementById("bulan").value;
  var xxx = $('#xxx').val();//document.getElementById("xxx").value;
  var dedetrisna =document.getElementById('dedetrisna').checked;

if (dedetrisna==false){
dedetrisna1=0;
}else{
dedetrisna1=1;
}
    $(function(){ 
     $('#dg').datagrid({
     url: '<?php echo base_url(); ?>/index.php/transaksi/load_bsthp',
        queryParams:({cari:kriteria,xxx:xxx,tahun:tahun,bulan:bulan,dedetrisna:dedetrisna1})
        });        
     });
    }




 function cari1(element, e) {
    var charCode;
    if(e && e.which){
      charCode = e.which;
    }else if(window.event){
      e = window.event;
      charCode = e.keyCode;
    }

    if(charCode == 13) {
var tahun =$('#tahun').val();// document.getElementById("tahun").value;
var kriteria = $('#txtcari').val();//document.getElementById("txtcari").value;
var xxx = $('#xxx').val();//document.getElementById("xxx").value;
var bulan =$('#bulan').val();// document.getElementById("bulan").value;
var dedetrisna = document.getElementById('dedetrisna').checked;

if (dedetrisna==false){
dedetrisna1=0;
}else{
dedetrisna1=1;
}

  
    $(function(){ 
     $('#dg').datagrid({
     url: '<?php echo base_url(); ?>/index.php/transaksi/load_bsthp',
        queryParams:({cari:kriteria,xxx:xxx,tahun:tahun,bulan:bulan,dedetrisna:dedetrisna1})
        });        
     });
    }
  }  


  function print(){
var cno =$('#no_bsthp').val();// document.getElementById('no_bsthp').value;
var tujuan =$('#tujuan').val();// document.getElementById('tujuan').value;


lc = '?dari='+cno;

if(tujuan=='GUDANG WIP'){
url    = "<?php echo site_url(); ?>/laporan/rbsthpwip/0";   
}else{
url    = "<?php echo site_url(); ?>/laporan/rbsthp/0";   
}


lc1 = '?no_bsthp='+cno;
url1    = "<?php echo site_url(); ?>/transaksi/cetak_lampiran_bsthp/0";   
window.open(url+lc,'_blank');
window.focus();

window.open(url1+lc1,'_blank');
window.focus();
	
  }
  
  
function cetak_print(){
  
var rows = $('#dg').datagrid('getSelections');
var ntot=rows.length;

if(ntot<1){
swal("Oops...", "Pilih Terlebih Dahulu!", "error");
exit();
	}
	
	var cno =$('#no_bsthp').val();// document.getElementById('no_bsthp').value;
var tujuan =$('#tujuan').val();// document.getElementById('tujuan').value;


lc = '?dari='+cno;

if(tujuan=='GUDANG WIP'){
url    = "<?php echo site_url(); ?>/laporan/rbsthpwip/0";   
}else{
url    = "<?php echo site_url(); ?>/laporan/rbsthp/0";   
}


lc1 = '?no_bsthp='+cno;
url1    = "<?php echo site_url(); ?>/transaksi/cetak_lampiran_bsthp/0";   
window.open(url+lc,'_blank');
window.focus();

window.open(url1+lc1,'_blank');
window.focus();

	
	 
}
	
	
	
	
		
		
		  function edit_(){
		
	
		
var rows = $('#dg').datagrid('getSelections');
var ntot=rows.length;

if(ntot<1){
swal("Oops...", "Pilih Terlebih Dahulu!", "error");
exit();
	} 
	
		if(stat==1){
		swal("Oops...", "Tidak bisa edit sudah di approved!", "error");
exit();	
		}
	
var	revno= $("#revno").val();
	 
	var  penambah=parseInt(revno)+1;
	 
		var cno =$('#no_bsthp').val();// 
		
	$.messager.confirm('Edit', 'Apakah Akan Edit Ini?'+cno, function(r){
                if (r){
					load_detail(cno);
$('#cancelaja').linkbutton('enable');
$('#buatanmanusia').linkbutton('enable');
$('#min').linkbutton('enable');
batalan();
 $("#revno").val(penambah);
     section2();
                }
            });
			
	 
	
	  
			  




   
    }
	
	
	
		
    function scanme(){

     var url    = "<?php echo site_url(); ?>/transaksi/scanme";  
     window.open(url,'_self');
      window.focus();
    }
  
  
  function alfi(){
$('#dg3').datagrid('reload'); 


               var no_bsthp = $('#no_bsthp').val();//document.getElementById('no_bsthp').value;
				  
			 $('#dg3').datagrid({
     url: '<?php echo base_url(); ?>/index.php/transaksi/load_dbsthp_error',
        queryParams:({cari:no_bsthp})
        });        
    
	
}

		
		
		 function validasitgl(){
			 var cno = $('#no_bsthp').val();
 if (cno==''){
            alert('Nomor BSTHP Tidak Boleh Kosong');
            exit();
        } 
		
		
var ctgl = $('#tgl_bsthp').datebox('getValue');
			 
		    $.ajax({
      type: "POST",
      url: '<?php echo base_url(); ?>/index.php/transaksi/validasitanggal',
      data: ({tgl:ctgl}),
      dataType:"json",
        success: function(data){
    
	if(data.no>0){
$.messager.alert('Opps!!','Tidak Boleh Lewat Tanggal hari Ini!!','error');
	exit();

	}else{
		BUAT();
	}
	
      }
    });
	
		 
		 }
  
  
   function ambil_nomor(){
				 	
    $.ajax({
      type: "POST",
      url: '<?php echo base_url(); ?>/index.php/transaksi/no_bsthp_otomatis',
      data: ({code:'',tujuan:''}),
      dataType:"json",
        success: function(data){
    
       $("#no_bsthp").val(data.no);
      }
    });
  }
  
     function ambil_nomor_supplier(){
				 	
    $.ajax({
      type: "POST",
      url: '<?php echo base_url(); ?>/index.php/transaksi/no_bsthp_urutsuplier',
      data: ({code:'',tujuan:''}),
      dataType:"json",
        success: function(data){
    
       $("#no_bsthp").val(data.no);
      }
    });
  }
  
     function ambil_nomor2222(aa){
				 	
    $.ajax({
      type: "POST",
      url: '<?php echo base_url(); ?>/index.php/transaksi/nourututututut',
      data: ({code:'',tujuan:aa}),
      dataType:"json",
        success: function(data){
    	  $("#no_urut").val(data.no);
   
      }
    });
  }
  
  
   function save_error(no_bsthp,norekaman,alasan){
				userlog="<?php echo $this->session->userdata('Display_name'); ?>";
				
			lcinsert = "(no_bsthp,norekaman,alasan,userlog,jam)";
            lcvalues = "('"+no_bsthp+"','"+norekaman+"','"+alasan+"','"+userlog+"',getdate())";
    $.ajax({
      type: "POST",
      url: '<?php echo base_url(); ?>/index.php/transaksi/simpan_err',
      data: ({tabel:'tb_erorBsthp',kolom:lcinsert,nilai:lcvalues}),
      dataType:"json",
        success: function(data){
    
      // $("#no_bsthp").val(data.no);
      }
    });
  }

function ambilbarcode(){


	total_detail=0;isi=0;
var f_total= eval($('#total1').val());
var bsthp =$('#no_bsthp').val();// 
var cno =$('#barcode').val();// 
var area=$("#seksi").combogrid("getValue");
 var sp2=$("#suplier").combogrid("getValue");	
 
 if(bsthp==''){
	alert('stop check koneksi atau reload terlebih dahulu!!!');
	exit();
 }
 
    $.ajax({
      type: "POST",
      url: '<?php echo base_url(); ?>/index.php/transaksi/barcodebsthp',
      data: ({no:cno,bsthp:bsthp,area:area,sp:sp2}),
      dataType:"json",
        success: function(data){
 	ntot=data.ntot-1;
    isi=data.qty;
var c=data.norekaman

//alert(ntot);
				if(c==''){
			
					
			document.getElementById('label3').style.color = "RED";		
	 document.getElementById("label3").innerHTML="data tidak ditemukan : "+cno;				
					
save_error(bsthp,cno,"data tidak ditemukan");
				
				
																			

					isi=0;
					$("#barcode").val('');
					exit();
				 document.getElementById("barcode").focus(); 
				}else if(c=='1'){
		
			
document.getElementById('label3').style.color = "RED";			
document.getElementById("label3").innerHTML="SUDAH BSTHP : "+cno;		
			save_error(bsthp,cno,"SUDAH BSTHP");
			
						
						
					isi=0;
					
				$("#barcode").val('');
				exit();
				 document.getElementById("barcode").focus(); 
			}

$('#dg1').datagrid('selectAll');
var rows = $('#dg1').datagrid('getSelections'); 
panjang=rows.length; 
$('#dg1').datagrid('unselectAll');  
document.getElementById('label3').style.color = "#00FF00";											
document.getElementById("label3").innerHTML="OKE "+cno;		       
     		
			
																						if (rows==''){
																							
																									$('#dg1').datagrid('appendRow',{norekaman:data.norekaman,
																					codeitemM:data.codeitemM,
																					nolot:data.nolot,
																					qty:data.qty,
																					unit:data.unit,
																					tgla:data.tgla,
																					tglb:data.tglb,
																					inspektor:data.inspektor,
																					operator:data.operator,
																					suboperator:data.suboperator,
																					area:data.area});
																			
																			
																					 total_rinci = eval(isi);
																						total_detail = f_total + total_rinci;
																					  $("#total").val(number_format(total_detail,0,',','.'));
																					  $("#total1").val(total_detail);
																			
																			
																							
																			 $("#barcode").val('');
																			 document.getElementById("barcode").focus();  
																						}else{
																							
						 																
																								 total_rinci = eval(isi);
																						total_detail = f_total + total_rinci;
																					  $("#total").val(number_format(total_detail,0,',','.'));
																					  $("#total1").val(total_detail);
																							
																			
																											
																								$('#dg1').datagrid('appendRow',{norekaman:data.norekaman,
																					codeitemM:data.codeitemM,
																					nolot:data.nolot,
																					qty:data.qty,
																					unit:data.unit,
																					tgla:data.tgla,
																					tglb:data.tglb,
																					inspektor:data.inspektor,
																					operator:data.operator,
																					suboperator:data.suboperator,
																					area:data.area});
																							$("#barcode").val('');
																			
																							  document.getElementById("barcode").focus();  
																												
																							
																				  }



      



	   
	   $('#dg1').datagrid('selectRow',ntot);
	   	$("#barcode").val('');
		  document.getElementById("barcode").focus(); 
      }
    });
	 


	

  }

    
 function doSomething(element, e) {
    var charCode;
    if(e && e.which){
      charCode = e.which;
    }else if(window.event){
      e = window.event;
      charCode = e.keyCode;
    }

    if(charCode == 13) {
      ambilbarcode();
    }
  }  
  
  
     function myformatter(date){
			var y = date.getFullYear();
			var m = date.getMonth()+1;
			var d = date.getDate();
			return y+'/'+(m<10?('0'+m):m)+'/'+(d<10?('0'+d):d);
		}
		
		function myparser(s){
			if (!s) return new Date();
			var ss = (s.split('/'));
			var y = parseInt(ss[0],10);
			var m = parseInt(ss[1],10);
			var d = parseInt(ss[2],10);
			if (!isNaN(y) && !isNaN(m) && !isNaN(d)){
				return new Date(y,m-1,d);
			} else {
				return new Date();
			}
		}
	  
  
  function BUAT(){


var cno = $('#no_bsthp').val();

  if (cno==''){
            alert('Nomor BSTHP Tidak Boleh Kosong');
            exit();
        } 
		
var ctgl = $('#tgl_bsthp').datebox('getValue');
var cnilai= $('#total1').val();
var cdibuat = $("#dibuat").combogrid("getValue");
var cdikirim = $("#dikirim").combogrid("getValue");
var cditerima = $("#diterima").combogrid("getValue");
var cshift= $('#shift').val();
var ctujuan= $("#tujuan").combogrid("getValue"); 
var area=$("#seksi").combogrid("getValue"); 
var sp2=$("#suplier").combogrid("getValue");
var keterangan=$('#keterangan').val();
var nourut=$('#no_urut').val();
var revno=$('#revno').val();

if(area=='Joint Slim'){
$('#plus').linkbutton('enable');
}else if(area==ctujuan){
$('#plus').linkbutton('enable');
}else if(area=='CVM' && ctujuan=='IMR'){
$('#plus').linkbutton('enable');
}else if(area=='CVM' && ctujuan=='AVS'){
$('#plus').linkbutton('enable');
}else if(area=='AVS' && ctujuan=='CVM'){
$('#plus').linkbutton('enable');
}else{
$('#plus').linkbutton('disable');
}


if(ctujuan=='GUDANG BARANG JADI'||ctujuan=='GUDANG WIP'){
 $("#c_ULANG").linkbutton("disable"); 
}else{
 $("#c_ULANG").linkbutton("enable");
	
}

if(area=='supplier'){
	
	if(sp2==''){
		alert('Supplier Tidak Boleh Kosong');
            exit();
	}
	
}
		
      
		
		
        if (ctgl==''){
            alert('Tanggal BSTHP Tidak Boleh Kosong');
            exit();
        }
    
           
    
	if (cnilai==''||cdikirim==''||cditerima==''|| cshift==''||ctujuan==''||area==''){
            alert('isi dulu data Tidak Boleh Kosong');
            exit();
        }
 
    
        $(document).ready(function(){
            $.ajax({
                type: "POST",    
                dataType:'json',                            
                data: ({tabel:'tr_bsthpM',no:cno,tgl:ctgl,nilaiz:cnilai,ccek:cek,shift:cshift,dibuat:cdibuat,dikirim:cdikirim,diterima:cditerima,tujuan:ctujuan,area:area,sp:sp2,ket:keterangan,nourut:nourut,revno:revno}),
                url: '<?php echo base_url(); ?>/index.php/transaksi/simpan_bsthp',
                success:function(data){
                    status = data.pesan; 
					urut = data.urut; 
					nomor = data.nomor; 
					  $("#no_bsthp").val(nomor);
				$("#no_urut").val(urut);
          if(status =='1'){
       		// swal("Tersimpan!", "Your imaginary file has been Save.", "success");
         
		   cek=0;
		   
$("#no_bsthp").attr("disabled",true);		
$("#tgl_bsthp").datebox("disable",true);
$("#dibuat").combogrid("disable",true);
$("#dikirim").combogrid("disable",true);
$("#diterima").combogrid("disable",true);
$("#shift").attr("disabled",true);	
$("#tujuan").combogrid("disable",true);
$("#seksi").combogrid("disable",true);
$("#suplier").combogrid("disable",true);
$("#barcode").attr("disabled",false);
$("#keterangan").attr("disabled",true);

//
		   
           	  document.getElementById("barcode").focus();  
			  $("#cetak").linkbutton("enable");
			  $('#plus').linkbutton('disable');
          }else if(status =='0'){
            alert('Data Gagal Disimpan  ..!!');
          }else{
            alert('No bsthp '+cno+' telah Terpakai  ..!!');
          }
                }
            });
        });
        
	  

 				  document.getElementById("barcode").focus();  
	  
	  }
  
     function buka(){

$("#dialog-modal-ccc").dialog('open');

    }

     function s_proses(){   
   var cno = $('#no_bsthp').val();
 var ctujuan= $("#tujuan").combogrid("getValue"); 
 
 


if (ctujuan=='AVS'||ctujuan=='CVM'||ctujuan=='Joint Slim'||ctujuan=='Joint Press' ||ctujuan=='Extruder Manual'||ctujuan=='Extrusion PVC'||ctujuan=='Extrusion UHF'||ctujuan=='IMR'){

 swal({
      title: "Apakah Anda Yakin?",
      text: "Akan memproses wip  "+cno+" !",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "Yes, saya yakin!",
      cancelButtonText: "No, Tidak!",
      closeOnConfirm: true,
      closeOnCancel: false
    },
    function(isConfirm){
      if (isConfirm) {
         $("#dialog-modal-aaa").dialog('open'); 
		  var urll = '<?php echo base_url(); ?>index.php/transaksi/bsthp_to_compound';
      $(document).ready(function(){
		  
      $.ajax({url:urll,
           dataType:'json',
           type: "POST",    
           data:({noid:cno}),
           success:function(data){
              status = data.pesan;
              if (status!=''){
				  //cetakperulangan(status);
                swal("Berhasil!", "Your imaginary file has been success.", "success"); 
                  $("#dialog-modal-aaa").dialog('close');  
               //   $("#dialog-modal-bbb").dialog('close');  
              } else {
                swal("Oops...", "Something went wrong!", "error");
              }        
           }
           
          });           
      });
      } else {
        swal("Cancelled", "Your imaginary file is safe :)", "error");
      }
    });   


  
  exit();
  }

        
            
    }

function isibulan(){
	
var bulan ="<?php echo date('m');	?>";


$("#bulan").val(bulan); 

}


 function printAdj1(){

//var area3=  $("#seksi3").combogrid("getValue");

var url    = "<?php echo site_url(); ?>/lainlain/listyangtelahdistribusi/0";  
	buy =$('#bubuy').val();//document.getElementById('bubuy').value;
	tang =$('#tatang').val();//document.getElementById('tatang').value;
		


lc= '?area=&bulan='+buy+'&tahun='+tang;
		
     window.open(url+lc,'_blank');
      window.focus();
    }
  
    </script>

</head>
<body>


<div id="content">    
<div id="sectiona" class="easyui-accordion">
<div title="List bsthp" id="section1">

     <table width="1250" >
       
        <tr>
          <td width="37" ><input  class="form-control" style="background-color:#DCDCDC;width:35px;border:solid 1px #000000;" value='' disabled="disabled"/></td>
          <td width="164" ><b>#Sudah di Terima</b></td>
          <td width="37" ><input  class="form-control" style="background-color:#FFF;width:35px;border:solid 1px #000000;" value='' disabled="disabled"/></td>
          <td width="127" ><b>#Belum di Kirim</b></td>
          <td width="37" >
          <input  class="form-control" style="background-color:yellow;width:35px;border:solid 1px #000000;" value='' disabled="disabled"/></td>
          <td width="128" ><b>#Sudah Distribusi</b>  

          
         </td>
          <td width="224" align="right"><span style="border-bottom-style:hidden;padding:3px;border-spacing:5px 5px 5px 5px;border-right-style:hidden;">
            <input type="checkbox" id="dedetrisna"  />
          </span></td>
          <td width="100" align="left"><select  class="form-control" name="bulan" id="bulan"  style="width:100px;">
            <option value="">...Bulan... </option>
            <option value="1" >1&nbsp;&nbsp;&nbsp;| Januari</option>
            <option value="2">2&nbsp;&nbsp;&nbsp;| Februari</option>
            <option value="3">3&nbsp;&nbsp;&nbsp;| Maret</option>
            <option value="4">4&nbsp;&nbsp;&nbsp;| April</option>
            <option value="5">5&nbsp;&nbsp;&nbsp;| Mei</option>
            <option value="6">6&nbsp;&nbsp;&nbsp;| Juni</option>
            <option value="7">7&nbsp;&nbsp;&nbsp;| Juli</option>
            <option value="8">8&nbsp;&nbsp;&nbsp;| Agustus</option>
            <option value="9">9&nbsp;&nbsp;&nbsp;| September</option>
            <option value="10">10&nbsp;| Oktober</option>
            <option value="11">11&nbsp;| November</option>
            <option value="12">12&nbsp;| Desember</option>
          </select></td>
          <td width="102" align="left"><?php $thang =  date("Y"); 
	$thang_maks = $thang + 1 ;
	$thang_min = $thang - 1 ;
	echo '<select class="form-control" name="tahun" id="tahun"  style="width:80px;">              ';
	
	for ($th=$thang_min ; $th<=$thang_maks ; $th++)
	{
		if ($th==$thang) {
			echo "<option selected value=$th>$thang</option>";
			}
		else {	
		echo "<option value=$th>$th</option>";
		}
	}
	echo '</select>';?></td>
         <td width="249" align="left">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="6" align="left"><a id="cetak2" class="easyui-linkbutton" iconcls="icon-print"  onclick="javascript:scanme();">scanme</a> <a class="easyui-linkbutton" iconcls="icon-print" id="setuju"  onclick="javascript:buka();">List Distribusi</a>&nbsp;<span style="padding:3px;border-spacing:5px 5px 5px 5px;border-bottom-style:hidden;"><a id="cetak3" class="easyui-linkbutton" iconcls="icon-print"  onclick="javascript:cetak_print();">cetak</a></span></td>
          <td align="right"><a class="easyui-linkbutton" iconcls="icon-add"  onclick="javascript:kosong();section2();">Tambah</a> <a class="easyui-linkbutton" iconcls="icon-edit"  onclick="javascript:edit_();">Edit</a></td>
        <td colspan="2"><input class="form-control" style="width: 200px;"  type="text" value="" id="txtcari" onkeyup="javascript:cari1(this, event);"/></td>
        <td><a class="easyui-linkbutton" iconcls="icon-search"  onclick="javascript:cari();">Cari</a></td>
        </tr>
        </table>
   
        <table id="dg" title="List BSTHP" style="width:960px;height:470px;" >  
        </table>                          
    </p> 
    </div>   


<div title="B S T H P" id="section2">
   <p id="p1" style="font-size: x-large;color: red;"></p>
   <p>       
    <fieldset>
        <table align="center" border='0' style="width:850px;">
        
            <tr style="border-bottom-style:hidden;padding:3px;border-spacing:5px 5px 5px 5px;">
                <td colspan="5" style="border-bottom-style:hidden;padding:3px;border-spacing:5px 5px 5px 5px;border-right-style:hidden;">&nbsp;</td>
            </tr>                        

            <tr style="border-bottom-style:hidden;padding:3px;border-spacing:5px 5px 5px 5px;">
                <td width="136" style="border-bottom-style:hidden;padding:3px;border-spacing:5px 5px 5px 5px;border-right-style:hidden;">No. B S T H P</td>
                <td width="266" style="border-bottom-style:hidden;padding:3px;border-spacing:5px 5px 5px 5px;border-right-style:hidden;">
<input class="form-control" type="text"  id="no_bsthp"  style="width: 250px;" readonly="readonly"/></td>
                <td width="75" style="border-bottom-style:hidden;padding:3px;border-spacing:5px 5px 5px 5px;border-right-style:hidden;">&nbsp;<input disabled="disabled" id="no_urut" style="width: 50px;" readonly="readonly"/></td>
                <td width="140" style="border-bottom-style:hidden;padding:3px;border-spacing:5px 5px 5px 5px;border-right-style:hidden;">Tanggal B S T H P</td>
                <td width="211" style="border-bottom-style:hidden;padding:3px;border-spacing:5px 5px 5px 5px;">
                <input id="tgl_bsthp" data-options="formatter:myformatter,parser:myparser" ></td>    
            </tr>   
      
      
      
      <tr style="border-bottom-style:hidden;padding:3px;border-spacing:5px 5px 5px 5px;">
                <td width="136" style="border-bottom-style:hidden;padding:3px;border-spacing:5px 5px 5px 5px;border-right-style:hidden;">SHIFT</td>
                <td width="266" style="border-bottom-style:hidden;padding:3px;border-spacing:5px 5px 5px 5px;border-right-style:hidden;">
                  <select class="form-control" name="shift" id="shift"  align="center"  style="width:150px" >
                    <option value="">...Shift... </option>
                    <option value="1" >1</option>
                    <option value="2" >2</option>
                    <option value="3">3</option>
                </select></td>
                <td width="75" style="border-bottom-style:hidden;padding:3px;border-spacing:5px 5px 5px 5px;border-right-style:hidden;">&nbsp;<input disabled="disabled"  id="revno" style="width: 50px;" readonly="readonly"/></td>
                <td width="140" style="border-bottom-style:hidden;padding:3px;border-spacing:5px 5px 5px 5px;border-right-style:hidden;">Made By</td>
                <td width="211" style="border-bottom-style:hidden;padding:3px;border-spacing:5px 5px 5px 5px;"><input type="text" id="dibuat" style="width: 160px;" /></td>   
          </tr> 
          
          
           <tr style="border-bottom-style:hidden;padding:3px;border-spacing:5px 5px 5px 5px;">
                <td width="136" style="border-bottom-style:hidden;padding:3px;border-spacing:5px 5px 5px 5px;border-right-style:hidden;">Destination Warehouse</td>
                <td width="266" style="border-bottom-style:hidden;padding:3px;border-spacing:5px 5px 5px 5px;border-right-style:hidden;">
<input type="text" id="tujuan"  style="width: 200px;" /></td>
                <td width="75" style="border-bottom-style:hidden;padding:3px;border-spacing:5px 5px 5px 5px;border-right-style:hidden;">&nbsp;</td>
                <td width="140" style="border-bottom-style:hidden;padding:3px;border-spacing:5px 5px 5px 5px;border-right-style:hidden;">Cheked By</td>
                <td width="211" style="border-bottom-style:hidden;padding:3px;border-spacing:5px 5px 5px 5px;"><input type="text" id="dikirim" style="width: 160px;" /></td>   
          </tr>
           <tr style="border-bottom-style:hidden;padding:3px;border-spacing:5px 5px 5px 5px;">
             <td style="border-bottom-style:hidden;padding:3px;border-spacing:5px 5px 5px 5px;border-right-style:hidden;">From</td>
             <td style="border-bottom-style:hidden;padding:3px;border-spacing:5px 5px 5px 5px;border-right-style:hidden;">
             <input type="text"  id="seksi" name="seksi" style="width: 200px;" /></td>
             <td style="border-bottom-style:hidden;padding:3px;border-spacing:5px 5px 5px 5px;border-right-style:hidden;">&nbsp;</td>
             <td style="border-bottom-style:hidden;padding:3px;border-spacing:5px 5px 5px 5px;border-right-style:hidden;">Accepted By</td>
             <td style="border-bottom-style:hidden;padding:3px;border-spacing:5px 5px 5px 5px;">
               <input type="text" id="diterima" style="width: 160px;" /></td>
           </tr> 
           <tr style="border-bottom-style:hidden;padding:3px;border-spacing:5px 5px 5px 5px;">
             <td style="border-bottom-style:hidden;padding:3px;border-spacing:5px 5px 5px 5px;border-right-style:hidden;"><label id="label"></label></td>
             <td style="border-bottom-style:hidden;padding:3px;border-spacing:5px 5px 5px 5px;border-right-style:hidden;"><p id="alfi"><input type="text"  id="suplier" name="suplier" style="width: 200px;" /></p></td>
             <td style="border-bottom-style:hidden;padding:3px;border-spacing:5px 5px 5px 5px;border-right-style:hidden;">&nbsp;</td>
             <td style="border-bottom-style:hidden;padding:3px;border-spacing:5px 5px 5px 5px;border-right-style:hidden;">&nbsp;</td>
             <td style="border-bottom-style:hidden;padding:3px;border-spacing:5px 5px 5px 5px;">&nbsp;</td>
           </tr> 
          
          <tr style="padding:3px;border-spacing:5px 5px 5px 5px;">
          <td style="padding:3px;border-spacing:5px 5px 5px 5px;border-bottom-style:hidden;"  align="left">Keterangan</td>
             <td style="padding:3px;border-spacing:5px 5px 5px 5px;border-bottom-style:hidden;" colspan="4" >
               <textarea class="form-control" name="keterangan" id="keterangan" style="width: 650px; height: 40px;"></textarea>
             </td>
          </tr>
          <tr style="padding:3px;border-spacing:5px 5px 5px 5px;">
             <td style="padding:3px;border-spacing:5px 5px 5px 5px;border-bottom-style:hidden;" colspan="5" align="center"><a id="buatanmanusia" class="easyui-linkbutton" iconcls="icon-code"  onclick="javascript:BUAT();">BUAT BARCODE</a> <a id="cancelaja" class="easyui-linkbutton" iconcls="icon-cancel"  onclick="javascript:batalan();">cancel</a></td>
          </tr>
          <tr style="padding:3px;border-spacing:5px 5px 5px 5px;">
                <td style="padding:3px;border-spacing:5px 5px 5px 5px;border-bottom-style:hidden;" colspan="5" align="LEFT"><label style="font-size: x-large;" id="label3"></label> </td>
          </tr>      
                        
        </table>      
    </fieldset>
        
        <table id="dg1" title="Barang" style="width:960px;height:350px;" >  
        </table>  
        
        <div id="toolbar" align="right">
        
           <table width="100%">
        <tr>
        <td width="63%" align="right">
        
     <input class="form-control" type="text" id="barcode"   onkeyup="doSomething(this, event)"   style="width: 300px;" />
     </td><td>
        <a class="easyui-linkbutton" id="plus" iconCls="icon-add"  onclick="javascript:barang();">Tambah Barang</a>
            <a class="easyui-linkbutton" id="min"iconCls="icon-remove"  onclick="javascript:hapus_barang();">Hapus barang</a>     
            </td></tr></table>
        </div>

        <table align="center" style="width:100%;">
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td > <input type="text" id="total1" name="total1" style="font-size: large;border:0;width: 200px;text-align: right;" /></td>
            <td align="right">Total : <input type="text" id="total" name="total" style="font-size: large;border:0;width: 200px;text-align: right;" readonly="true"/></td>
        </tr>
        </table>
             <table  width="100%"> 
 <tr style="padding:3px;border-spacing:5px 5px 5px 5px;">
                <td style="padding:3px;border-spacing:5px 5px 5px 5px;border-bottom-style:hidden;" colspan="5" align="center"><a class="easyui-linkbutton" iconCls="icon-add"  onclick="javascript:kosong();">Tambah</a>
                    <a class="easyui-linkbutton" id="save" iconCls="icon-save"  onclick="javascript:simpan_serlok(1);">KIRIM</a>
                    
                       <a id="cetak" class="easyui-linkbutton" iconCls="icon-print"  onclick="javascript:print();">cetak</a>  
                       
                <a class="easyui-linkbutton" id="hapus" iconCls="icon-remove"  onclick="javascript:hapus();">Hapus</a>
                    
                  <a class="easyui-linkbutton" iconCls="icon-undo"  onclick="javascript:kembali();">Kembali</a>                                   
                </td>
            </tr> 
            <tr>  
                <td colspan="5" align="center"><a class="easyui-linkbutton" id="c_ULANG" iconCls="icon-edit"  onclick="javascript:s_proses();">Proses Ke Compound/material</a></td>
            </tr>   
      </table>      
   </p>
   </div>
   
   
   <div title="YANG TIDAK MASUK BARCODE" id="section3">
   

      <td style="padding:3px;border-spacing:5px 5px 5px 5px;border-bottom-style:hidden;" colspan="5" align="center"><a class="easyui-linkbutton" iconCls="icon-add"  onclick="javascript:alfi();">tampilkan</a>
                     <table id="dg3" title="DATA YANG TIDAK TER BSTHP" style="width:960px;height:350px;" >  
        </table>  
   </div>
</div>
</div>

<div id="dialog-modal" title="Pilih">

    <p class="validateTips"></p> 
    <fieldset>  
    <tr>
      <td align="left" width="100px">Cari&nbsp;&nbsp
        <input id="txt_std" class="easyui-searchbox" data-options="prompt:'Please Input Value', searcher:function(value,name){cari_sp2d(value)}" style="width:180px"/>
      </td>
      
    </tr>
    <table id="dg2" title="Pilih" style="width:1200px;height:350px;">  
    </table>
    <table style="width:1200px;height:20px;" border="0">
    <tr></tr>
    <tr>
      <td align="center" colspan='2'>&nbsp;</td>
    </tr>
    <tr>
      <td align="center" ><button class="easyui-linkbutton" iconcls="icon-save"  onclick="javascript:append_save();">Pilih</button>
        <button class="easyui-linkbutton" iconcls="icon-back"  onclick="javascript:keluar();">Kembali</button></td>
    </tr>
    </table>
    </fieldset>  
</div>




<div id="dialog-modal-aaa" title="MOHON TUNGGU SEBENTAR">
    <p class="validateTips"></p>  
    <fieldset>
    <table>
    <tr height="100%" >
      <td colspan="3" align="center"  > 
      <DIV id="load" > <b>Sedang Proses harap tunggu</b><IMG src="<?php echo base_url(); ?>assets/images/load.gif"  BORDER="0" ALT=""></DIV></td>
    </tr>
    </table>
    
    </fieldset>
  
</div>



    <p class="validateTips"></p> 
    <div id="ddd" align="center">
      <select class="form-control"  name="xxx" id="xxx"  align="center"  style="width:150px" onchange="cari();" >
        <option value="" selected="selected">...area... </option>
                <option value="Area Transit Gudang" >Area Transit Gudang</option>
                <option value="AVS" >AVS</option>
                   <option value="REWORK METAL" >REWORK METAL</option>
                <option value="CVM" >CVM</option>
                <option value="Extruder Manual" >Extruder Manual</option>
                <option value="Extrusion PVC" >Extrusion PVC</option>
                <option value="Extrusion UHF" >Extrusion UHF</option>
                <option value="FINISHING EXTRUSION" >FINISHING EXTRUSION</option>
                <option value="GUDANG WIP" >GUDANG WIP</option>
                <option value="IMP" >IMP</option>
                <option value="IMR" >IMR</option>
                <option value="Joint Slim" >Joint Slim</option>
                <option value="Joint Press" >Joint Press</option>
                <option value="Mixing Material PVC" >Mixing Material PVC</option>
                <option value="Plant 2" >Plant 2</option>
                <option value="supplier" >supplier</option>
                
              </select>

   </div>
   
   
<div id="dialog-modal-ccc" title="LIST DISTRIBUSI" >
    <p class="validateTips"></p>  
    <fieldset>
    <table>
      <tr height="100%" hidden="true" >
        <td>Area</td>
        <td>:</td>
        <td><span style="border-bottom-style:hidden;padding:3px;border-spacing:5px 5px 5px 5px;border-right-style:hidden;">
          <input type="text"  id="aarea" name="seksi3" style="width: 200px;" />
        </span></td>
      </tr>
      <tr>
        <td style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;">Bulan</td>
        <td style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;">:</td>
        <td style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;"><select  class="form-control"  id="bubuy" >
          <option value="">...Bulan... </option>
          <option value="1" >1 | Januari</option>
          <option value="2">2 | Februari</option>
          <option value="3">3 | Maret</option>
          <option value="4">4 | April</option>
          <option value="5">5 | Mei</option>
          <option value="6">6 | Juni</option>
          <option value="7">7 | Juli</option>
          <option value="8">8 | Agustus</option>
          <option value="9">9 | September</option>
          <option value="10">10 | Oktober</option>
          <option value="11">11 | November</option>
          <option value="12">12 | Desember</option>
        </select></td>
      </tr>
      <tr>
        <td style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;">Tahun</td>
        <td style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;">:</td>
        <td style="border-bottom:hidden;border-spacing: 3px;padding:3px 3px 3px 3px;"><?php $thang =  date("Y"); 
	$thang_maks = $thang + 1 ;
	$thang_min = $thang - 1 ;
	echo '<select class="form-control" name="tahun" id="tatang">              ';
	
	for ($th=$thang_min ; $th<=$thang_maks ; $th++)
	{
		if ($th==$thang) {
			echo "<option selected value=$th>$thang</option>";
			}
		else {	
		echo "<option value=$th>$th</option>";
		}
	}
	echo '</select>';?></td>
      </tr>
    
    

    </table>
    
    </fieldset>
  
</div>

<div id="dlg-buttons">
   <a class="easyui-linkbutton" id="c_proses" iconCls="icon-print"  onclick="javascript:printAdj1(0);">Show</a
    ></div>
    
</body>

</html>