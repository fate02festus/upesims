<?php 
include 'db_connect.php'; 
if(isset($_GET['id'])){
$qry = $conn->query("SELECT * FROM banker_account where accno= ".$_GET['id']);
foreach($qry->fetch_array() as $k => $val){
	$$k=$val;
}
}


			
?>
<div class="container-fluid">
	<form action="" id="manage-tenant">
		<input type="hidden" name="accno" value="<?php echo isset($accno) ? $accno : '' ?>">
		<input type="hidden" name="banker" value="<?php echo isset($banker) ? $banker : '' ?>">
		<input type="hidden" name="acc_type" value="<?php echo isset($acc_type) ? $acc_type : '' ?>">
		<div class="row form-group">

			<div class="col-md-4">
				<label for="" class="control-label">A/C Balance. #</label>
				<input type="text" class="form-control" name="balance"  value="<?php echo isset($balance) ? $balance :'' ?>" required>
			</div>
			<div class="col-md-4">
				<label for="" class="control-label">Withdraw Amount. #</label>
				<input type="text" class="form-control" name="amount"  required>
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
			url:'ajax.php?action=save_withdraw',
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
					alert_toast("Amount greater than  current balance.",'success')
						setTimeout(function(){
							location.reload()
						},500)
				}
			}
		})
	})
</script>