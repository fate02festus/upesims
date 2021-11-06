<?php include('db_connect.php');?>

<div class="container-fluid">
	
	<div class="col-lg-12">
		<div class="row mb-4 mt-4">
			<div class="col-md-12">
				
			</div>
		</div>
		<div class="row">
			<!-- FORM Panel -->

			<!-- Table Panel -->
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<b>Customers</b>
						<span class="float:right"><a class="btn btn-primary btn-block btn-sm col-sm-2 float-right" href="javascript:void(0)" id="new_tenant">
					<i class="fa fa-plus"></i> New Customer
				</a></span>
					</div>
					<div class="card-body">
						<table class="table table-condensed table-bordered table-hover">
							<thead>
								<tr>
									<th class="text-center">#</th>
									<th class="">Name</th>
									<th class="">Email</th>
									<th class="">Phone No</th>
									<th class="">ID No</th>
									<th class="">A/C No.</th>
									<th class="text-center">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$i = 1;
								$tenant = $conn->query("select id,concat(firstname,' ',middlename,' ',lastname) as name,username,phone,idno, accno from bankers order by id ");
								while($row=$tenant->fetch_assoc()):
								?>
								<tr>
									<td class="text-center"><?php echo $i++ ?></td>
									<td>
										<?php echo ucwords($row['name']) ?>
									</td>
									<td class="">
										 <p> <b><?php echo $row['username'] ?></b></p>
									</td>
									<td class="">
										 <p> <b><?php echo $row['phone'] ?></b></p>
									</td>
									<td class="">
										 <p> <b><?php echo $row['idno'] ?></b></p>
									</td>
									<td class="">
										 <p> <b><?php echo $row['accno'] ?></b></p>
									</td>
									<td class="text-center">
										<center>
										<div class="btn-group">
										  <button type="button" class="btn btn-primary">Action</button>
										  <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										    <span class="sr-only">Toggle Dropdown</span>
										  </button>
										  <div class="dropdown-menu">
										  	<a class="dropdown-item add_account" href="javascript:void(0)" data-id = '<?php echo $row['id'] ?>'>Add account</a>
										  	<div class="dropdown-divider"></div>
										  	<a class="dropdown-item deposit" href="javascript:void(0)" data-id = '<?php echo $row['id'] ?>'>Deposit</a>
										  	<div class="dropdown-divider"></div>
										  	
										    <a class="dropdown-item edit_sadmin" href="javascript:void(0)" data-id = '<?php echo $row['id'] ?>'>Money Transfer</a>
										    
										  </div>
										</div>
										</center>
									</td>
								</tr>
								<?php endwhile; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<!-- Table Panel -->
		</div>
	</div>	

</div>
<style>
	
	td{
		vertical-align: middle !important;
	}
	td p{
		margin: unset
	}
	img{
		max-width:100px;
		max-height: :150px;
	}
</style>
<script>
	$(document).ready(function(){
		$('table').dataTable()
	})
	
	$('#new_tenant').click(function(){
		uni_modal("New Customer","manage_suser.php","mid-large")
		
	})
	$('.add_account').click(function(){
		uni_modal("Manage Accounts","manage_acc.php?id="+$(this).attr('data-id'),"mid-large")
		
	})
	$('.deposit').click(function(){
		uni_modal("Deposit To Accounts","deposit_amount.php?id="+$(this).attr('data-id'),"mid-large")
		
	})
	
	$('.edit_sadmin').click(function(){
		uni_modal("Money Transfer","money_trans.php?id="+$(this).attr('data-id'),"mid-large")
		
	})
	//$('.delete_sadmin').click(function(){
	//	_conf("Are you sure to delete this Admin?","delete_sadmin",[$(this).attr('data-id')])
	//})
	
	function delete_sadmin($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_user',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					alert_toast("Admin successfully deleted",'success')
					setTimeout(function(){
						location.reload()
					},400)

				}
			}
		})
	}
</script>