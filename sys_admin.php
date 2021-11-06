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
						<b>List of Administrators</b>
						<span class="float:right"><a class="btn btn-primary btn-block btn-sm col-sm-2 float-right" href="javascript:void(0)" id="new_tenant">
					<i class="fa fa-plus"></i> New Admin
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
									<th class="text-center">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$i = 1;
								$tenant = $conn->query("select id,concat(firstname,' ',middlename,' ',lastname) as name,username,phone,idno from sys_admin order by id ");
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
									<td class="text-center">
										<center>
										<div class="btn-group">
										  <button type="button" class="btn btn-primary">Action</button>
										  <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										    <span class="sr-only">Toggle Dropdown</span>
										  </button>
										  <div class="dropdown-menu">
										    <a class="dropdown-item edit_sadmin" href="javascript:void(0)" data-id = '<?php echo $row['id'] ?>'>Edit</a>
										    <div class="dropdown-divider"></div>
										    <a class="dropdown-item delete_sadmin" href="javascript:void(0)" data-id = '<?php echo $row['id'] ?>'>Delete</a>
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
		uni_modal("New Udmin","manage_admin.php","mid-large")
		
	})
	$('.edit_sadmin').click(function(){
		uni_modal("Manage Admin Details","manage_admin.php?id="+$(this).attr('data-id'),"mid-large")
		
	})
	$('.delete_sadmin').click(function(){
		_conf("Are you sure to delete this Admin?","delete_sadmin",[$(this).attr('data-id')])
	})
	
	function delete_sadmin($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_sadmin',
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