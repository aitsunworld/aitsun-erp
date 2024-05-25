<!DOCTYPE html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--favicon-->
	<link rel="icon" href="<?= base_url('public'); ?>/images/app_icon.ico" type="image/png" />
	<!-- loader-->
	<link rel="manifest" href="<?= base_url('manifest.json'); ?>">


	<link href="<?= base_url('public'); ?>/css/pace.min.css" rel="stylesheet" />
	<script src="<?= base_url('public'); ?>/js/pace.min.js"></script>
	<!-- Bootstrap CSS -->
	<link href="<?= base_url('public'); ?>/css/bootstrap.min.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
	<link href="<?= base_url('public'); ?>/css/app.css" rel="stylesheet">
	<link href="<?= base_url('public'); ?>/css/icons.css" rel="stylesheet">
	<title>101 - Permission Denied</title>
</head>

<body>
	<!-- wrapper -->
	<div class="wrapper bg-white">
		 
		<div class="error-404 d-flex align-items-center justify-content-center " style="display: flex; height: 100vh; width: 100%;">
			<div class="card-body text-center p-4">
				<h1 class="display-1"><span class="text-primary">1</span><span class="text-danger">0</span><span class="text-success">1</span></h1>
				<h2 class="font-weight-bold display-4">Permission Denied</h2>
				<p>
					You are not permitted to access any branch. <br> Please contact administrator to seek a help
				</p>
				<div class="mt-4"> <a href="<?= base_url('users/logout'); ?>" class="btn btn-sm btn-primary btn-lg px-md-5 radius-30">Logout</a>
					
				</div>
			</div>
		</div>
	 
	</div>
	<!-- end wrapper -->
	<!-- Bootstrap JS -->
	<script src="<?= base_url('public'); ?>/js/bootstrap.bundle.min.js"></script>
</body>

</html>