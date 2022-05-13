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
						nama_kabkota
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
		$sql.=$query;
		$sql .=" )Q1";
		if ($id != '') {
			$sql .=" WHERE id = $id";
		}
		$sql .=" ORDER BY COMPANY_NAME ASC";
		$dbserlok = $this->load->database("dbserlok", TRUE);
		return $dbserlok->query($sql);
	}
}