<?php
class M_Serlok extends CI_Model {
	function __construct(){
		parent::__construct();
		
		
	}

	public function getCustomerByGroup($query, $id)
	{
		$sql = "SELECT
					*
				FROM
				(
					SELECT
						id,
						ALAMAT_LENGKAP_PLANT,
						COMPANY_NAME,
						nama_kabkota,
						CASE 
							WHEN SUBSTR(nama_kabkota,1,4) = 'KOTA' THEN REPLACE(nama_kabkota,'KOTA ','')
							ELSE nama_kabkota
						END AS nama2
					FROM
					(
						SELECT
							kps_customer_delivery_setup AS id,
							PLANT1_CITY AS ALAMAT_LENGKAP_PLANT,
							ID_CITY_SETUP AS ID_KAB_KOTA,
							kps_customer_delivery_setup.ID_MASTER_CLUSTER AS CLUSTER_ID,
							kps_customer.KPS_CUSTOMER_ID,
							kps_customer.COMPANY_NAME 
						FROM
							`kps_customer_delivery_setup`
							JOIN kps_customer ON kps_customer.KPS_CUSTOMER_ID = kps_customer_delivery_setup.KPS_CUSTOMER_ID 
						ORDER BY
							kps_customer.KPS_CUSTOMER_ID 
					)Q1
					LEFT JOIN
					(
						SELECT
							ID_KK,
							nama_kabkota
						FROM
							tref_kabkota
					)Q2 ON Q1.ID_KAB_KOTA = Q2.ID_KK ";
		$sql .=" )Q1 ";
		if ($query != '' && $id == '') {
			$sql.=$query;
		}elseif($query=='' && $id != ''){
			$sql .=" WHERE id = $id";
		}else{
			$sql.="";
		}
		$sql .=" ORDER BY COMPANY_NAME ASC";
		$dbserlok = $this->load->database("dbserlok", TRUE);
		return $dbserlok->query($sql);
	}
	public function getSPJByOutGoing($noTNKB, $tglSPJ)
	{
		$sql = "SELECT DISTINCT
					Q1.*,
					COMPANY_NAME,
					nama_kabkota
				FROM
				(
					SELECT
						VEHICLE_NO,
						DELIVERY_DATE,
						PLANT1_CITY,
						kps_customer_delivery_setup AS ID,
						d.KPS_CUSTOMER_ID,
						ID_CITY_SETUP AS ID_KAB_KOTA
					FROM
						kps_vehicle a
					JOIN
						kps_outgoing_finished_good b
					ON b.KPS_VEHICLE_ID = a.KPS_VEHICLE_ID
					JOIN kps_delivery_order c 
					ON c.KPS_OUTGOING_FINISHED_GOOD_ID_DO = b.KPS_OUTGOING_FINISHED_GOOD_ID
					JOIN kps_customer_delivery_setup d 
					ON d.KPS_CUSTOMER_DELIVERY_SETUP = c.KPS_CUSTOMER_DELIVERY_SETUP_ID 
					WHERE
						VEHICLE_NO = '$noTNKB' AND
						DELIVERY_DATE = '$tglSPJ'
					LIMIT 100
				)Q1
				INNER JOIN
				(
					SELECT
						COMPANY_NAME,
						KPS_CUSTOMER_ID 
					FROM
						kps_customer 
				)Q2 ON Q2.KPS_CUSTOMER_ID = Q1.KPS_CUSTOMER_ID
				LEFT JOIN
				(
					SELECT
						ID_KK,
						nama_kabkota
					FROM
						tref_kabkota
				)Q3 ON Q1.ID_KAB_KOTA = Q3.ID_KK";
		$dbserlok = $this->load->database("dbserlok", TRUE);
		return $dbserlok->query($sql);
	}
	public function getSPJByOutGoing2($noTNKB, $tglSPJ)
	{
		$sql = "SELECT DISTINCT
					Q1.*,
					COMPANY_NAME,
					nama_kabkota
				FROM
				(
					SELECT
						VEHICLE_NO,
						DELIVERY_DATE,
						PLANT1_CITY,
						kps_customer_delivery_setup AS ID,
						d.KPS_CUSTOMER_ID,
						ID_CITY_SETUP AS ID_KAB_KOTA
					FROM
						kps_vehicle a
					JOIN
						kps_outgoing_finished_good b
					ON b.KPS_VEHICLE_ID = a.KPS_VEHICLE_ID
					JOIN kps_customer_delivery_setup d 
					ON d.KPS_CUSTOMER_DELIVERY_SETUP = b.KPS_CUSTOMER_DELIVERY_SETUP_ID 
					WHERE
						VEHICLE_NO = '$noTNKB' AND
						DELIVERY_DATE = '$tglSPJ'
				)Q1
				INNER JOIN
				(
					SELECT
						COMPANY_NAME,
						KPS_CUSTOMER_ID 
					FROM
						kps_customer 
				)Q2 ON Q2.KPS_CUSTOMER_ID = Q1.KPS_CUSTOMER_ID
				LEFT JOIN
				(
					SELECT
						ID_KK,
						nama_kabkota
					FROM
						tref_kabkota
				)Q3 ON Q1.ID_KAB_KOTA = Q3.ID_KK";
		$dbserlok = $this->load->database("dbserlok", TRUE);
		return $dbserlok->query($sql);
	}
}