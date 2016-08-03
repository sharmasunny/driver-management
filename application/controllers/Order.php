<?php
defined('BASEPATH') OR exit('No direct script access allowed');
define('SHOPIFY_APP_SECRET', 'd5a002bbec4f13614c670de01b9caa7e');
/**
 * User class.
 * 
 * @extends CI_Controller
 */
class Order extends CI_Controller {

	/**
	 * __construct function.
	 * 
	 * @access public
	 * @return void
	 */
	public function __construct() {
		header('Access-Control-Allow-Origin: *');
    	header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
		parent::__construct();
		//if (! $this->tank_auth->is_logged_in()) {
        	//redirect('/');
    	//}
		$this->load->library(array('session'));
		$this->load->helper(array('url','form'));
		 $this->load->model('user_model');
		$this->load->model('order_model');
		 $this->load->model('driver_model');
		
	}
	
	
	public function index() {
		$this->getallorder();
		$order_id = $this->input->get('id', TRUE);
		
		if($order_id){
			$order_number = $order_id;
		

			$this->db->where('order_number', $order_number);
			$order_details = $this->db->get_where('orders', array('order_number' => $order_number));
			$this->db->select('all_record');
			
			$query_for_product_id = $this->db->get_where('orders', array('order_number' => $order_number));


			$products_ids  = json_decode($query_for_product_id->row()->all_record);
			foreach($products_ids->line_items as $product_det)
			{
				$this->db->select('product_img');
				$product_img =  $this->db->get_where('products', array('product_id' => $product_det->product_id))->row()->product_img;
				if($product_img){
					$product_det->img = $product_img;
				}else{
					$product_det->img = base_url().'assets/images/no-image.png';
				}
			}
			
			$query = $this->db->get('orders');
			$where = "driver_status='0' AND driver_is_deleted='0'";
			$drivers_list = $this->driver_model->get_driver_list($where);
			$queryArr = $drivers_list->result();        
			$row['0'] = 'Please select driver';
	        foreach ($queryArr as $key=>$val)
	        {
	        	$row[$val->driver_id] = $val->driver_name.' '.$val->driver_lname;         
	        }

	        $timline_array = array(0=>array(0=>'No driver assign',1=>'Not Accepted',2=>'Accepted' ),1=>'Picked UP',2=>'On the way',3=>'Deliverd',4=>'FULFILLED');
	       

	        $order_value = $order_details->result();

	        if($order_value[0]->order_driver_id!=0){
	        	$where = "driver_id=".$order_value[0]->order_driver_id;
				$assign_driver = $this->driver_model->get_driver_list($where);
				$driver_details = $assign_driver->result();
				$this->data['driver_details'] = $driver_details;
	        }
	        $zones = $this->db->get('zones')->result_array();
	        $drivers = $this->db->get('drivers')->result_array();
	        $this->data['order_status'] = $order_value;
		$this->data['order_details'] = $products_ids;
		$this->data['order_number'] = $order_number;
		$this->data['options'] = $row;
		$this->data['timeline'] = $timline_array;
		$this->data['zones'] = $zones;
		$this->data['drivers'] = $drivers;
			
	     	$this->load->view('shopify_header');
			$this->load->view('order/order_id', $this->data);		
			$this->load->view('footer');

		}else{
			// echo 'h';die;
			$query = $this->db->get('orders');

			$where = "driver_status='0' AND driver_is_deleted='0'";
			//$where = "driver_status='1' AND driver_is_deleted='0'";
			$drivers_list = $this->driver_model->get_driver_list($where);

			 $queryArr = $drivers_list->result();        
			 $row['0'] = 'Please select driver';
	        foreach ($queryArr as $key=>$val)
	        {
	        	$row[$val->driver_id] = $val->driver_name;         
	        }
     
			$this->data['orders'] = $query->result();
			$this->data['drivers_list'] = $drivers_list->result();
			$this->data['options'] = $row;

	     	$this->load->view('header');
			$this->load->view('order/index', $this->data);		
			$this->load->view('footer');
		}
		
		
	}



public function assign_driver()
{
	$driver_id = $this->input->post('driver_list');
	$order_id = $this->input->post('order_id');
	$data['order_driver_id']=$driver_id;
	$data['confirmation']= 1;
	$this->order_model->entry_update1($order_id , $data);
	echo json_encode(array('status'=>true,'timeline'=>'Not Accepted'));
	exit;
/*	echo "<script>	
	window.location.href='http://driver-management.mycloudsportal.com';
	</script>";*/
}

public function assign_zone()
{
	$zone_id = $this->input->post('order_driver_zone');
	$order_id = $this->input->post('order_id');
	$data['order_zone_id']=$zone_id;
	// $data['confirmation']= 1;
	$this->order_model->entry_update1($order_id , $data);

	$array_drivers = array();

	$where = " driver_is_deleted='0'";
	$drivers_list = $this->driver_model->get_driver_list($where);

	foreach ($drivers_list->result() as $key => $value) {
	   $driverzone_id	= @unserialize($value->driver_zone_id);
	   if ($driverzone_id !== false) {
	   	//print_r($driverzone_id);
	   	foreach ($driverzone_id as  $value_zone) {
	   		if($zone_id==$value_zone){
	   			$arr_d = array('id'=>$value->driver_id,'name' =>$value->driver_name ,'email'=>$value->driver_email );
	   			array_push($array_drivers,$arr_d);
	   	 	}
	   	}
	   }else{
	   	 if($zone_id==$value->driver_zone_id){
	   	 		$arr_d = array('id'=>$value->driver_id,'name' =>$value->driver_name ,'email'=>$value->driver_email );
	   	 		array_push($array_drivers,$arr_d);
	   	 }
	   }
	   
	}

	print_r($array_drivers);
	$emailarray = array();
	foreach ($array_drivers as $key => $value) {
		$emailarray[] = $value['email'];
	}
	 // $emails = implode(',', $emailarray);
	//print_r($emailarray);
	$this->sendmail($emailarray);

	die();
	echo json_encode(array('status'=>true,'timeline'=>'Not Accepted'));
	exit;
/*	echo "<script>	
	window.location.href='http://driver-management.mycloudsportal.com';
	</script>";*/
}

	public function check() {
		

	}


	public function save(){

	 	//  $hmac_header = @$_SERVER['HTTP_X_SHOPIFY_HMAC_SHA256'];
		// $data = file_get_contents('php://input');
		// // echo "h";die;
               
		// $verified = $this->verify_webhook($data, $hmac_header);
	 	//        // echo '<pre>';print_r($_REQUEST);die;
	        
		// $data1 = array(
		//         'order_number' => isset($data->line_items[0]->id)?$data->line_items[0]->id:0,
		// 		'product_name' => isset($data->line_items[0]->name)?$data->line_items[0]->name:'',
		// 		'quantity' => isset($data->line_items[0]->quantity)?$data->line_items[0]->quantity:0,
		// 		'total_price' => isset($data->total_price)?$data->total_price:0,
		// 		'email' => isset($data->email)?$data->email:'',
		//         'r_data' => @$data
		//   	        // echo '<pre>';print_r($_REQUEST);die;
	       
      
		// );
		//  echo '<pre>';print_r($data);die;
		// $this->db->insert('order', $data1);
		// error_log('Webhook verified: '.var_export($verified, true));
		die;
	}


	public function order_Webhook(){
		$hmac_header = $_SERVER['HTTP_X_SHOPIFY_HMAC_SHA256'];
		$data = file_get_contents('php://input');
               
		$verified = $this->verify_webhook($data, $hmac_header);
	}
	
        

	function verify_webhook($data, $hmac_header)
	{
	  $calculated_hmac = base64_encode(hash_hmac('sha256', $data, SHOPIFY_APP_SECRET, true));
	  return ($hmac_header == $calculated_hmac);
	}

		public function sendmail($users)
		{
			$config['protocol'] = 'sendmail';
			$config['mailpath'] = '/usr/sbin/sendmail';
			$config['charset'] = 'iso-8859-1';
			$config['wordwrap'] = TRUE;

			$this->load->library('email', $config);
			$this->email->set_newline("\r\n");

			// Set to, from, message, etc.
			 $this->email->from('shopify', 'Anil Labs');
	         $data = array(
	                'userName'=> 'srikant , sunny'
	          );
	       // $userEmail = "srikant@mobilyte.com";

	        $this->email->to($user);  // replace it with receiver mail id
	        $this->email->subject("test mail from codeigniter"); // replace it with relevant subject
	   
	        //$body = $this->load->view('emails/anillabs.php',$data,TRUE);
	        $this->email->message("hello");       
		    $result = $this->email->send();
		    if($result){ echo "send"; } else{ echo "error";}
		}


	public function getallorder(){
		$orders_table = "orders";	
		$api_url = 'https://6143cddd141541615eb006119cd232be:4f79e7163888d6bf77af717e923f37e9@24sevens.myshopify.com';
		$counts_url = $api_url . '/admin/orders/count.json';

		$ch2 = curl_init();
		curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch2, CURLOPT_URL, $counts_url);
		$result2 = curl_exec($ch2);
		curl_close($ch2);

		$count_json = json_decode( $result2, true);

		$counts = $count_json['count'];
		$pagesize = round($counts/50);
		$page = $pagesize + 1;
		$orders = array(); 
		$orgorder = array();
		for($i=1;$i<=$page;$i++){	
			$orders_url = $api_url . '/admin/orders.json?status=any&limit=50&page='.$i;	
			$ch1 = curl_init();
			curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch1, CURLOPT_URL, $orders_url);
			$result1 = curl_exec($ch1);
			curl_close($ch1);
			$order_json = json_decode($result1, true);
			$orders = $order_json['orders'];

			if(!empty($orders)) {
				$orgorder = array_merge_recursive($orgorder,$orders);	
			} else {
				$orders = array();
				$orgorder = array_merge_recursive($orgorder,$orders);	
			}
			foreach($orgorder as $res) {
				
				$order_id = $res['order_number'];
				$f_order_ids[]  = $res['order_number'];
				$all_record  = json_encode($res);
				$order_number = $res['id'];
				$customer_email = $res['email'];
				$order_price = $res['total_price'];
				$order_address1 = $res['shipping_address']['address1'];
				$order_city = $res['shipping_address']['city'];
				$order_zip = $res['shipping_address']['zip'];
				$order_state = $res['shipping_address']['province'];
				$order_country = $res['shipping_address']['country'];
				$order_shipping_address = $order_address1.','.$order_city.','.$order_state.','.$order_country.'-'.$order_zip;
				$order_tag = $res['tags'];

				$add_order = "INSERT INTO ".$orders_table."(order_id,order_price,customer_email,order_shipping_address,order_driver_id,all_record,order_number,order_tag) VALUES ('".$order_id."',".$order_price.", '".$customer_email."','".$order_shipping_address."','','".$all_record."','".$order_number."','".$order_tag."') ON DUPLICATE KEY UPDATE order_price = VALUES(order_price),customer_email = VALUES(customer_email),order_shipping_address = VALUES(order_shipping_address),order_tag = VALUES(order_tag)";

				$this->db->query($add_order);

			}
			$result = array_diff($order_ids,$f_order_ids);
			if(!empty($result)) {
				foreach($result as $delel) {

					$del_order = "DELETE FROM ".$orders_table." WHERE order_id=".$delel." ";
					$this->db->query($del_order);
				}
			}
		}


	}


}
