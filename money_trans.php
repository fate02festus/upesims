n<?php 
include 'db_connect.php'; 
if(isset($_GET['id'])){
$qry = $conn->query("SELECT * FROM bankers where id= ".$_GET['id']);
foreach($qry->fetch_array() as $k => $val){
	$$k=$val;
}
}
?>
<div class="container-fluid">
	<form action="" id="manage-category">
		
		<div class="form-group row">
			<div class="col-md-4">
				<label for="" class="control-label">A/C No. #</label>
				<input type="text" class="form-control" name="accno"  value="<?php echo isset($accno) ? $accno :'' ?>" required>
			</div>
			<div class="col-md-4">
				<label for="" class="control-label">A/C Type. #</label>
				<select name="acc_type" id="" class="custom-select select2">
					<option value=""></option>
					<?php 
					$house = $conn->query("SELECT * FROM account_type where id  in (select acc_type from banker_account where banker='$accno')");
					while($row= $house->fetch_assoc()):
					?>
					<option value="<?php echo $row['id'] ?>" <?php echo isset($acc_type) && $acc_type == $row['id'] ? 'selected' : '' ?>><?php echo $row['name'] ?></option>
					<?php endwhile; ?>
				</select>
			</div>
			<div class="col-md-4">
				<label for="" class="control-label">Bank A/C No. #</label>
				<select name="bacc" id="" class="custom-select select2">
					<option value=""></option>
					<?php 
					$house = $conn->query("select accno,account_type.name as name from banker_account left join account_type on account_type.id=banker_account.acc_type where banker_account.banker='$accno'");
					while($row= $house->fetch_assoc()):
					?>
					<option value="<?php echo $row['accno'] ?>"><?php echo $row['accno'].' - '.$row['name'] ?></option>
					<?php endwhile; ?>
				</select>
			</div>
		</div>
		<div class="form-group row">			
			<div class="col-md-4">
				<label for="" class="control-label">Transfer To(A/C No). #</label>
				<input type="text" class="form-control" name="tacc"  required>
			</div>
			<div class="col-md-4">
				<label for="" class="control-label">Description. #</label>
				<input type="text" class="form-control" name="description"  value="" required>
			</div>
			<div class="col-md-4">
				<label for="" class="control-label">Amount. #</label>
				<input type="number" class="form-control" name="amount"  required>
			</div>
		</div>
	</form>
</div>
<script>
	$('#manage-category').submit(function(e){
		e.preventDefault()
		start_load()
		$('#msg').html('')
		$.ajax({
			url:'ajax.php?action=money_trans',
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