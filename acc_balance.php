<?php include('db_connect.php');?>

<div class="container-fluid">
	
	<div class="col-lg-12">
		
			<!-- FORM Panel -->

			<!-- Table Panel -->
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<b>Accounts List</b>
					</div>
					<div class="card-body">
						<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<th class="text-center">#</th>
									<th class="text-center">A/C</th>
									<th class="text-center">Name</th>
									<th class="text-center">A/C No</th>
									<th class="text-center">A/C Type</th>
									<th class="text-center">A/C Balance</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$i = 1;
								$category = $conn->query("SELECT banker as acc,concat(firstname,' ',middlename,' ',lastname) as name,banker_account.accno,account_type.name as acctype,balance  FROM `banker_account` left join bankers  on bankers.accno=banker_account.banker left join account_type on account_type.id=banker_account.acc_type");
								while($row=$category->fetch_assoc()):
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
</style>
<script>
	
	$('#manage-category').submit(function(e){
		e.preventDefault()
		start_load()
		$.ajax({
			url:'ajax.php?action=save_account_type',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully added",'success')
					setTimeout(function(){
						location.reload()
					},500)

				}
				else if(resp==2){
					alert_toast("Data successfully updated",'success')
					setTimeout(function(){
						location.reload()
					},500)

				}
			}
		})
	})
	$('.edit_category').click(function(){
		start_load()
		var cat = $('#manage-category')
		cat.get(0).reset()
		cat.find("[name='id']").val($(this).attr('data-id'))
		cat.find("[name='name']").val($(this).attr('data-name'))
		cat.find("[name='notes']").val($(this).attr('data-notes'))
		end_load()
	})
	$('.delete_category').click(function(){
		_conf("Are you sure to delete this category?","delete_category",[$(this).attr('data-id')])
	})
	function delete_category($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_account_type',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully deleted",'success')
					setTimeout(function(){
						location.reload()
					},500)

				}
			}
		})
	}
	$('table').dataTable()
</script>