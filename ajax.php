<?php
ob_start();
$action = $_GET['action'];
include 'admin_class.php';
$crud = new Action();
if($action == 'login'){
	$login = $crud->login();
	if($login)
		echo $login;
}
if($action == 'logout'){
	$logout = $crud->logout();
	if($logout)
		echo $logout;
}
if($action == 'save_user'){
	$save = $crud->save_user();
	if($save)
		echo $save;
}
if($action == 'delete_user'){
	$save = $crud->delete_user();
	if($save)
		echo $save;
}
if($action == 'signup'){
	$save = $crud->signup();
	if($save)
		echo $save;
}

if($action == "save_withdraw"){
	$save = $crud->save_withdraw();
	if($save)
		echo $save;
}

if($action == "save_dep"){
	$save = $crud->save_dep();
	if($save)
		echo $save;
}
if($action == "save_account_type"){
	$save = $crud->save_account_type();
	if($save)
		echo $save;
}
if($action == "save_cacc"){
	$save = $crud->save_cacc();
	if($save)
		echo $save;
}
if($action == "save_suser"){
	$save = $crud->save_suser();
	if($save)
		echo $save;
}
if($action == "save_sadmin"){
	$save = $crud->save_sadmin();
	if($save)
		echo $save;
}

if($action == "delete_suser"){
	$save = $crud->delete_suser();
	if($save)
		echo $save;
}
if($action == "money_trans"){
	$save = $crud->money_trans();
	if($save)
		echo $save;
}
ob_end_flush();
?>
