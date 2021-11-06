<?php 
include 'db_connect.php'; 
if(isset($_GET['id'])){
$qry = $conn->query("SELECT * FROM sys_admin where id= ".$_GET['id']);
foreach($qry->fetch_array() as $k => $val){
	$$k=$val;
}
}
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
				<label for="" class="control-label">Username. #</label>
				<input type="email" class="form-control" name="username"  value="<?php echo isset($username) ? $username :'' ?>" required>
			</div>
			<div class="col-md-4">
				<label for="password">Password. #</label>
			    <input type="password" name="password" id="password" class="form-control" value="" autocomplete="off">
			    <?php if(isset($meta['id'])): ?>
			    <small><i>Leave this blank if you dont want to change the password.</i></small>
		        <?php endif; ?>
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
			url:'ajax.php?action=save_sadmin',
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