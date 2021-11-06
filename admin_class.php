<?php
session_start();
ini_set('display_errors', 1);
Class Action {
	private $db;

	public function __construct() {
		ob_start();
   	include 'db_connect.php';
    
    $this->db = $conn;
	}
	function __destruct() {
	    $this->db->close();
	    ob_end_flush();
	}

	function login(){
		
			extract($_POST);		
			$qry = $this->db->query("SELECT * FROM sys_users where username = '".$username."' and password = '".md5($password)."'");//where username = '".$username."' and password = '".md5($password)."' 
			if($qry->num_rows > 0){
				foreach ($qry->fetch_array() as $key => $value) {
					if($key != 'passwors' && !is_numeric($key))
						$_SESSION['login_'.$key] = $value;
				}
				/*if($_SESSION['login_type'] != 1){
					foreach ($_SESSION as $key => $value) {
						unset($_SESSION[$key]);
					}
					return 2 ;
					exit;
				}*/
					return 1;
			}else{
				return 3;
			}
	}
	
	function logout(){
		session_destroy();
		foreach ($_SESSION as $key => $value) {
			unset($_SESSION[$key]);
		}
		header("location:login.php");
	}
	
	function save_user(){
		extract($_POST);
		$data = " name = '$name' ";
		$data .= ", username = '$username' ";
		if(!empty($password))
		$data .= ", password = '".md5($password)."' ";
		$data .= ", type = '$type' ";
		if($type == 1)
			$establishment_id = 0;
		$data .= ", establishment_id = '$establishment_id' ";
		$chk = $this->db->query("Select * from users where username = '$username' and id !='$id' where username = '".$username."' and password = '".md5($password)."' ")->num_rows;
		if($chk > 0){
			return 2;
			exit;
		}
		if(empty($id)){
			$save = $this->db->query("INSERT INTO users set ".$data);
		}else{
			$save = $this->db->query("UPDATE users set ".$data." where id = ".$id);
		}
		if($save){
			return 1;
		}
	}
	function delete_suser(){
		extract($_POST);
		$delete = $this->db->query("UPDATE bankers set status = 0 where id = ".$id);
		if($delete){
			return 1;
		}
	}
	function delete_user(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM bankers where id = ".$id);
		if($delete)
			return 1;
	}
	function delete_sadmin(){
		extract($_POST);
		if($id!="1")
		{
			$delete = $this->db->query("UPDATE sys_admin set status = 0 where id = ".$id);
			if($delete)
				return 1;
		}
	}
	function signup(){
		extract($_POST);
		$data = " name = '".$firstname.' '.$lastname."' ";
		$data .= ", username = '$email' ";
		$data .= ", password = '".md5($password)."' ";
		$chk = $this->db->query("SELECT * FROM users where username = '$email' ")->num_rows;
		if($chk > 0){
			return 2;
			exit;
		}
			$save = $this->db->query("INSERT INTO users set ".$data);
		if($save){
			$uid = $this->db->insert_id;
			$data = '';
			foreach($_POST as $k => $v){
				if($k =='password')
					continue;
				if(empty($data) && !is_numeric($k) )
					$data = " $k = '$v' ";
				else
					$data .= ", $k = '$v' ";
			}
			if($_FILES['img']['tmp_name'] != ''){
							$fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['img']['name'];
							$move = move_uploaded_file($_FILES['img']['tmp_name'],'assets/uploads/'. $fname);
							$data .= ", avatar = '$fname' ";

			}
			$save_alumni = $this->db->query("INSERT INTO alumnus_bio set $data ");
			if($data){
				$aid = $this->db->insert_id;
				$this->db->query("UPDATE users set alumnus_id = $aid where id = $uid ");
				$login = $this->login2();
				if($login)
				return 1;
			}
		}
	}
	function update_account(){
		extract($_POST);
		$data = " name = '".$firstname.' '.$lastname."' ";
		$data .= ", username = '$email' ";
		if(!empty($password))
		$data .= ", password = '".md5($password)."' ";
		$chk = $this->db->query("SELECT * FROM users where username = '$email' and id != '{$_SESSION['login_id']}' ")->num_rows;
		if($chk > 0){
			return 2;
			exit;
		}
			$save = $this->db->query("UPDATE users set $data where id = '{$_SESSION['login_id']}' ");
		if($save){
			$data = '';
			foreach($_POST as $k => $v){
				if($k =='password')
					continue;
				if(empty($data) && !is_numeric($k) )
					$data = " $k = '$v' ";
				else
					$data .= ", $k = '$v' ";
			}
			if($_FILES['img']['tmp_name'] != ''){
							$fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['img']['name'];
							$move = move_uploaded_file($_FILES['img']['tmp_name'],'assets/uploads/'. $fname);
							$data .= ", avatar = '$fname' ";

			}
			$save_alumni = $this->db->query("UPDATE alumnus_bio set $data where id = '{$_SESSION['bio']['id']}' ");
			if($data){
				foreach ($_SESSION as $key => $value) {
					unset($_SESSION[$key]);
				}
				$login = $this->login2();
				if($login)
				return 1;
			}
		}
	}

	function save_settings(){
		extract($_POST);
		$data = " name = '".str_replace("'","&#x2019;",$name)."' ";
		$data .= ", email = '$email' ";
		$data .= ", contact = '$contact' ";
		$data .= ", about_content = '".htmlentities(str_replace("'","&#x2019;",$about))."' ";
		if($_FILES['img']['tmp_name'] != ''){
						$fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['img']['name'];
						$move = move_uploaded_file($_FILES['img']['tmp_name'],'assets/uploads/'. $fname);
					$data .= ", cover_img = '$fname' ";

		}
		
		// echo "INSERT INTO system_settings set ".$data;
		$chk = $this->db->query("SELECT * FROM system_settings");
		if($chk->num_rows > 0){
			$save = $this->db->query("UPDATE system_settings set ".$data);
		}else{
			$save = $this->db->query("INSERT INTO system_settings set ".$data);
		}
		if($save){
		$query = $this->db->query("SELECT * FROM system_settings limit 1")->fetch_array();
		foreach ($query as $key => $value) {
			if(!is_numeric($key))
				$_SESSION['system'][$key] = $value;
		}

			return 1;
				}
	}

	function save_withdraw(){
		extract($_POST);
		$date=date();
		$data = " customer = '$banker' ";
		$data .= ", accno = '$accno' ";
		$data .= ", acc_type = '$acc_type' ";
		$data .= ", amount = '$amount' ";
		$data .= ", date = '$date' ";
		$data .= ", trans_type = 'WIT' ";


		$qq = mysqli_query($conn, "select balance from banker_account  where accno='$accno'") or die(mysqli_error());
		$ff = mysqli_fetch_array($qq);
		if(intval($qq)<intval($amount))
			return 2;
		$save = $this->db->query("INSERT INTO account_trans set $data");
				$save1 = $this->db->query("update banker_account set balance= balance-'$amount' where accno = '$accno'");
			
		if($save)
			return 1;
	}
	function money_trans(){
		extract($_POST);
		$date=date();
		$data = " taccno = '$tacc' ";
		$data .= ", accno = '$accno' ";
		$data .= ", acc_type = '$acc_type' ";
		$data .= ", amount = '$amount' ";
		$data .= ", date = '$date' ";
        $data .= ", description = '$description' ";
        $qq = mysqli_query($conn, "select balance from banker_account  where accno='$accno'") or die(mysqli_error());
		$ff = mysqli_fetch_array($qq);
		if(intval($qq)<intval($amount))
					return 2;

		$save = $this->db->query("INSERT INTO money_transfer set $data");
		$save1 = $this->db->query("update banker_account set balance= balance-'$amount' where accno = '$accno'");
		$save2 = $this->db->query("update banker_account set balance= balance+'$amount' where accno = '$tacc'");
		if($save)
			return 1;
	}
	
	function save_account_type(){
		extract($_POST);
		
		$data = " name = '$name' ";
		$data .= ", notes = '$notes' ";
		if(empty($id)){
			$save = $this->db->query("INSERT INTO account_type set $data");
		}else{
			$save = $this->db->query("UPDATE account_type set $data where id = $id");
		}
	if($save)
			return 1;
	}
	function save_dep(){
		extract($_POST);
		$date=date();
		$data = " customer = '$accno' ";
		$data .= ", accno = '$bacc' ";
		$data .= ", acc_type = '$acc_type' ";
		$data .= ", amount = '$amount' ";
		$data .= ", date = '$date' ";
		$data .= ", trans_type = 'DEP' ";
		
		$save1 = $this->db->query("update banker_account set balance= balance+'$amount' where  accno = '$bacc'");//banker='$accno' and
		$save = $this->db->query("INSERT INTO account_trans set $data");	
		if($save)
			return 1;
	}
	
	function save_cacc(){
		extract($_POST);
		$ac=$acc_type.$bacc;
		
		$save = $this->db->query("INSERT INTO banker_account set banker = '$accno', accno = '$ac', acc_type = '$acc_type'");
		
		if($save)
			return 1;
	}
	function save_suser(){
		extract($_POST);
		$ac=$acc_type.$accno;
		$pw=md5($password);
		$data = " firstname = '$firstname' ";
		$data .= ", lastname = '$lastname' ";
		$data .= ", middlename = '$middlename' ";
		$data .= ", phone = '$phone' ";
		$data .= ", idno = '$idno' ";
		$data .= ", bank_balance = '0' ";
		$data .= ", dob = '$dob' ";
		$data .= ", occupation = '$occupation' ";
		$data .= ", gender = '$gender' ";
		$data .= ", address = '$address' ";
		$data .= ", accno = '$accno' ";
		$data .= ", username = '$username' ";
		if(empty($id))
		{
			$pass=md5($accno);
			$save = $this->db->query("INSERT INTO bankers set $data");
			$save1 = $this->db->query("INSERT INTO banker_account set banker = '$accno', accno = '$ac', acc_type = '$acc_type'");
			$save3 = $this->db->query("UPDATE system_settings set accno=accno+1");
			$save4 = $this->db->query("INSERT INTO sys_users set name = '".$firstname.' '.$middlename.' '.$lastname."', username = '$username', password = '$pass',type = '2'");
		}
		else
		{
			$save = $this->db->query("UPDATE employee set $data where empno = $id");
			$save1 = $this->db->query("INSERT INTO banker_account set banker = '$accno', accno = '$ac', acc_type = '$acc_type' where banker = '$accno' ");
		}
		if($save)
		{			
			return 1;
		}
	}
	function save_sadmin(){
		extract($_POST);
		$pw=md5($password);
		$data = " firstname = '$firstname' ";
		$data .= ", middlename = '$middlename' ";
		$data .= ", lastname = '$lastname' ";
		$data .= ", username = '$username' ";
		$data .= ", phone = '$phone' ";
		$data .= ", idno = '$idno' ";
		$data .= ", address = '$address' ";
		$data .= ", password = '$pw' ";
		$chk = $this->db->query("Select * from sys_users where username = '$username' ")->num_rows;
		if($chk > 0){
			return 2;
		  exit;
		}
		if(empty($id)){
				
			$save = $this->db->query("INSERT INTO sys_admin set $data");
		$save1 = $this->db->query("INSERT INTO sys_users set name = '".$firstname.' '.$middlename.' '.$lastname."', username = '$username', password = '$pw',type = '1'");
		}else{
				$save = $this->db->query("UPDATE sys_admin set $data where id = $id");
				$save1 = $this->db->query("UPDATE sys_users set name = '".$firstname.' '.$middlename.' '.$lastname."', username = '$username', password = '$pw',type = '2' where username = '$username' ");
		}
		if($save)
			return 1;
		else
			return 2;
	}
	function delete_tenant(){
		extract($_POST);
		$delete = $this->db->query("UPDATE tenants set status = 0 where id = ".$id);
		if($delete){
			return 1;
		}
	}
	function get_tdetails(){
		extract($_POST);
		$data =array();
		$tenants =$this->db->query("SELECT t.*,concat(t.lastname,', ',t.firstname,' ',t.middlename) as name,h.house_no,h.price FROM tenants t inner join houses h on h.id = t.house_id where t.id = {$id} ");
		foreach($tenants->fetch_array() as $k => $v){
			if(!is_numeric($k)){
				$$k = $v;
			}
		}
		$months = abs(strtotime(date('Y-m-d')." 23:59:59") - strtotime($date_in." 23:59:59"));
		$months = floor(($months) / (30*60*60*24));
		$data['months'] = $months;
		$payable= abs($price * $months);
		$data['payable'] = number_format($payable,2);
		$paid = $this->db->query("SELECT SUM(amount) as paid FROM payments where id != '$pid' and tenant_id =".$id);
		$last_payment = $this->db->query("SELECT * FROM payments where id != '$pid' and tenant_id =".$id." order by unix_timestamp(date_created) desc limit 1");
		$paid = $paid->num_rows > 0 ? $paid->fetch_array()['paid'] : 0;
		$data['paid'] = number_format($paid,2);
		$data['last_payment'] = $last_payment->num_rows > 0 ? date("M d, Y",strtotime($last_payment->fetch_array()['date_created'])) : 'N/A';
		$data['outstanding'] = number_format($payable - $paid,2);
		$data['price'] = number_format($price,2);
		$data['name'] = ucwords($name);
		$data['rent_started'] = date('M d, Y',strtotime($date_in));

		return json_encode($data);
	}
	
	function save_payment(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k => $v){
			if(!in_array($k, array('id','ref_code')) && !is_numeric($k)){
				if(empty($data)){
					$data .= " $k='$v' ";
				}else{
					$data .= ", $k='$v' ";
				}
			}
		}
		if(empty($id)){
			$save = $this->db->query("INSERT INTO payments set $data");
			$id=$this->db->insert_id;
		}else{
			$save = $this->db->query("UPDATE payments set $data where id = $id");
		}

		if($save){
			return 1;
		}
	}
	function delete_payment(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM payments where id = ".$id);
		if($delete){
			return 1;
		}
	}
}