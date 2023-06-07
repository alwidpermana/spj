<?php
class M_Serlok extends CI_Model {
	function __construct(){
		parent::__construct();
		
		
	}

	public function getCustomerByGroup($query, $id, $search)
	{
		$sql = "SELECT
					*
				FROM
				(
					SELECT
						id,
						KPS_CUSTOMER_ID,
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
					)Q2 ON Q1.ID_KAB_KOTA = Q2.ID_KK 
				WHERE COMPANY_NAME LIKE '%$search%' OR nama_kabkota LIKE '%$search%' OR ALAMAT_LENGKAP_PLANT LIKE '%$search%'";
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
	public function getSPJByOutGoing2($noTNKB, $tglSPJ, $where)
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
						d.kps_customer_delivery_setup AS ID,
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
						DELIVERY_DATE = '$tglSPJ' AND
						kps_customer_delivery_setup IS NOT NULL
						$where
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
	public function getDeparture($noTNKB, $tglSPJ)
	{
		$sql = "SELECT DISTINCT
					b.departure_time
				FROM
					kps_vehicle a
				JOIN
					kps_outgoing_finished_good b
				ON b.KPS_VEHICLE_ID = a.KPS_VEHICLE_ID
				JOIN kps_customer_delivery_setup d 
				ON d.KPS_CUSTOMER_DELIVERY_SETUP = b.KPS_CUSTOMER_DELIVERY_SETUP_ID 
				WHERE
					VEHICLE_NO = '$noTNKB' AND
					DELIVERY_DATE = '$tglSPJ'";
		$dbserlok = $this->load->database("dbserlok", TRUE);
		return $dbserlok->query($sql);
	}
	public function saveDeliverySetup()
	{
		
		$data = $this->db->query("SELECT MAX(DELIVERY_SETUP_ID) AS ID FROM SPJ_DELIVERY_SETUP_SERLOK")->row();
		$jml= $data->ID == null ? 0 : $data->ID;
		$getSerlok = "SELECT
						KPS_CUSTOMER_DELIVERY_SETUP,
						KPS_CUSTOMER_ID,
						PLANT1_CITY
					FROM
						kps_customer_delivery_setup
					WHERE
						KPS_CUSTOMER_DELIVERY_SETUP > $jml
					ORDER BY
						KPS_CUSTOMER_DELIVERY_SETUP ASC";
		$dbserlok = $this->load->database("dbserlok", TRUE);
		$serlok = $dbserlok->query($getSerlok);
		$id = 0 ;
		$serlokId = 0;
		$plant = '';
		if ($serlok->num_rows()>0) {
			foreach ($serlok->result() as $key) {
				$id = $key->KPS_CUSTOMER_DELIVERY_SETUP;
				$serlokId = $key->KPS_CUSTOMER_ID;
				$plant = $key->PLANT1_CITY;
				$getData = $this->db->query("SELECT DELIVERY_SETUP_ID FROM SPJ_DELIVERY_SETUP_SERLOK WHERE DELIVERY_SETUP_ID = $id  AND SerlokId = $serlokId");
				if ($getData->num_rows()==0) {
					$sql = "INSERT INTO SPJ_DELIVERY_SETUP_SERLOK(DELIVERY_SETUP_ID, SerlokId, PlantCity)VALUES($id, $serlokId, '$plant')";
				}else{
					$sql = "UPDATE SPJ_DELIVERY_SETUP_SERLOK SET PlantCity = '$plant' WHERE DELIVERY_SETUP_ID = $id AND SerlokId = $serlokId";
				}
				$save = $this->db->query($sql);

			}
		}else{
			$save = true;
		}

		return $save;
	}
}