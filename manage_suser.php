<?php 
include 'db_connect.php'; 
if(isset($_GET['id'])){
$qry = $conn->query("SELECT * FROM bankers where id= ".$_GET['id']);
foreach($qry->fetch_array() as $k => $val){
	$$k=$val;
}
}

			$qq = mysqli_query($conn, "SELECT accno FROM `system_settings`") or die(mysqli_error());
			$ff = mysqli_fetch_array($qq);
			$lno=intval($ff['accno'])+1;
			$ln=str_pad($lno, intval(6), "0", STR_PAD_LEFT);
			
			
?>
<div class="container-fluid">
	<form action="" id="manage-tenant">
		<input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
		<div class="row form-group">
			<div class="col-md-4">
				<label for="" class="control-label">First Name. #</label>
				<input type="text" class="form-control" name="firstname"  value="<?php echo isset($firstname) ? $firstname :'' ?>" required>
			</div>
			<div class="col-md-4">
				<label for="" class="control-label">Middle Name. #</label>
				<input type="text" class="form-control" name="middlename"  value="<?php echo isset($middlename) ? $middlename :'' ?>" required>
			</div>
			<div class="col-md-4">
				<label for="" class="control-label">Last Name. #</label>
				<input type="text" class="form-control" name="lastname"  value="<?php echo isset($lastname) ? $lastname :'' ?>" required>
			</div>
			
		</div>
		<div class="form-group row">
			<div class="col-md-4">
				<label for="" class="control-label">Phone No. #</label>
				<input type="text" class="form-control" name="phone"  value="<?php echo isset($phone) ? $phone :'' ?>" required>
			</div>
			<div class="col-md-4">
				<label for="" class="control-label">ID No. #</label>
				<input type="text" class="form-control" name="idno"  value="<?php echo isset($idno) ? $idno :'' ?>" required>
			</div>
			<div class="col-md-4">
				<label for="" class="control-label">Address. #</label>
				<input type="text" class="form-control" name="address"  value="<?php echo isset($address) ? $address :'' ?>" required>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-md-4">
				<label for="" class="control-label">D.O.B #</label>
				<input type="date" class="form-control" name="dob"  value="<?php echo isset($dob) ? $dob :'' ?>" required>
			</div>
			<div class="col-md-4">
				<label for="" class="control-label">Gender. #</label>
				<select name="gender" id="" class="custom-select select2">
					<option value=""></option>					
					<option value="Male">Male</option>
					<option value="Female">Female</option>
				</select>
			</div>
			<div class="col-md-4">
				<label for="" class="control-label">Occupation. #</label>
				<input type="text" class="form-control" name="occupation"  value="<?php echo isset($occupation) ? $occupation :'' ?>" required>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-md-4">
				<label for="" class="control-label">Email. #</label>
				<input type="email" class="form-control" name="username"  value="<?php echo isset($username) ? $username :'' ?>" required>
			</div>
			<div class="col-md-4">
				<label for="" class="control-label">A/C Type. #</label>
				<select name="acc_type" id="" class="custom-select select2">
					<option value=""></option>
					<?php 
					$house = $conn->query("SELECT * FROM account_type order by id");
					while($row= $house->fetch_assoc()):
					?>
					<option value="<?php echo $row['id'] ?>" <?php echo isset($acc_type) && $acc_type == $row['id'] ? 'selected' : '' ?>><?php echo $row['name'] ?></option>
					<?php endwhile; ?>
				</select>
			</div>
			<div class="col-md-4">
				<label for="" class="control-label">A/C No. #</label>
				<input type="text" class="form-control" name="accno"  value="<?php echo isset($accno) ? $accno :$ln ?>" required>
			</div>

		</div>
	</form>
</div>
<script>
	$('#manage-tenant').submit(function(e){
		e.preventDefault()
		start_load()
		$('#msg').html('')
		$.ajax({
			url:'ajax.php?action=save_suser',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully saved.",'success')
						setTimeout(function(){
							location.reload()
						},500)
				}else{
					alert_toast("Error adding data.",'success')
						setTimeout(function(){
							location.reload()
						},500)
				}
			}
		})
	})
</script>