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
						
					</div>
					<div class="card-body">
						<table class="table table-condensed table-bordered table-hover">
							<thead>
								<tr>
									<th class="text-center">#</th>
									<th class="text-center">A/C</th>
									<th class="text-center">Name</th>
									<th class="text-center">A/C No</th>
									<th class="text-center">A/C Type</th>
									<th class="text-center">A/C Balance</th>
									<th class="text-center">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$i = 1;
								$tenant = $conn->query("SELECT banker as acc,concat(firstname,' ',middlename,' ',lastname) as name,banker_account.accno,account_type.name as acctype,balance  FROM `banker_account` left join bankers  on bankers.accno=banker_account.banker left join account_type on account_type.id=banker_account.acc_type");
								while($row=$tenant->fetch_assoc()):
								?>
								<tr>
									<td class="text-center"><?php echo $i++ ?></td>
									<td class="">
										<p><b><?php echo $row['acc'] ?></b></p>
									</td>
									<td class="">
										<p><b><?php echo $row['name'] ?></b></p>
									</td>
									<td class="">
										<p><b><?php echo $row['accno'] ?></b></p>
									</td>
									<td class="">
										<p><b><?php echo $row['acctype'] ?></b></p>
									</td>
									<td class="">
										<p><b><?php echo $row['balance'] ?></b></p>
									</td>
									<td class="text-center">
										<center>
										<div class="btn-group">
										  <button type="button" class="btn btn-primary">Action</button>
										  <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										    <span class="sr-only">Toggle Dropdown</span>
										  </button>
										  <div class="dropdown-menu">
										  	<a class="dropdown-item withdraw" href="javascript:void(0)" data-id = '<?php echo $row['accno'] ?>'>Withdraw Amount</a>	  	
										    
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
	
	$('.withdraw').click(function(){
		uni_modal("Withdraw Amount","withdraw_amount.php?id="+$(this).attr('data-id'),"mid-large")
		
	})
	
</script>