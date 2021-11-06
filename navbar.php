
<style>
	.collapse a{
		text-indent:10px;
	}
	nav#sidebar{
		/*background: url(assets/uploads/<?php echo $_SESSION['system']['cover_img'] ?>) !important*/
	}
</style>

<nav id="sidebar" class='mx-lt-5 bg-dark' >
		
		<div class="sidebar-list">
				<a href="index.php?page=home" class="nav-item nav-home"><span class='icon-field'><i class="fa fa-tachometer-alt "></i></span> Dashboard</a>
				<?php if($_SESSION['login_type'] == 1): ?>
				<a href="index.php?page=sys_admin" class="nav-item nav-users"><span class='icon-field'><i class="fa fa-users "></i></span> Administrators</a>
				<a href="index.php?page=sys_user" class="nav-item nav-reports"><span class='icon-field'><i class="fa fa-user-friends "></i></span> Customers</a>
				<a href="index.php?page=acc_type" class="nav-item nav-department"><span class='icon-field'><i class="fa fa-th-list "></i></span> Account Type</a>
			<?php else: ?>
				<a href="index.php?page=acc_balance" class="nav-item nav-department"><span class='icon-field'><i class="fa fa-th-list "></i></span> Account Balance</a>
				<a href="index.php?page=customer" class="nav-item nav-reports"><span class='icon-field'><i class="fa fa-user-friends "></i></span> Customers</a>
				
			<?php endif; ?>
		</div>

</nav>
<script>
	$('.nav_collapse').click(function(){
		console.log($(this).attr('href'))
		$($(this).attr('href')).collapse()
	})
	$('.nav-<?php echo isset($_GET['page']) ? $_GET['page'] : '' ?>').addClass('active')
</script>
