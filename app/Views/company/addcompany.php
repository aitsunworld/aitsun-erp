<!doctype html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--favicon-->
	<link rel="icon" href="<?= base_url('public'); ?>/images/app_ic.ico" type="image/png" />

	<!-- manifest file -->
    <link rel="manifest" href="<?= base_url('manifest.json'); ?>">

	<!--plugins-->
	
	<!-- loader-->
	<!-- Bootstrap CSS -->
	<link href="<?= base_url('public'); ?>/css/bootstrap.min.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
	<link href="<?= base_url('public'); ?>/css/custom_erp.css" rel="stylesheet">
	<link href="<?= base_url('public'); ?>/css/icons.css" rel="stylesheet">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

	<title><?= langg(get_setting(company($user['id']),'language'),'Aitsun ERP - Company'); ?></title>

	<style type="text/css">
		.home-btn {
		    position: absolute;
		    top: 15px;
		    right: 25px;
		    z-index: 10;
		}
	</style>
</head>

<body class="bg-lock-screen">
	<div class="home-btn d-none d-sm-block">
            <a href="<?= base_url('users/logout'); ?>"><i class="bx bx-log-out-circle h2 text-white"></i></a>
        </div>
	<!--wrapper-->
	<div class="">
		<div class="d-flex align-items-center justify-content-center my-5 my-lg-0"  style="height: 90vh;">
			<div class="container">
				<div class="row ">
					<div class="col mx-auto">
						<div class="my-4 text-center">
							<img src="<?= base_url('public'); ?>/images/logo-text.png" width="180" alt="" />
						</div>
						<div class="card" style="margin: auto;">
							<div class="card-body" style="box-shadow:0px 0px 8px 0px #ca024736;">
								<div class="">
									<div class="text-center mb-3">
										<h5 class="font-weight-semibold"><?= langg(get_setting(company($user['id']),'language'),'ADD COMPANY'); ?></h5>
									</div>

									 <?php if (session()->get('sucmsg')): ?>
							            <div class="alert border-0 border-start border-5 border-success alert-dismissible fade show py-2">
							                <div class="d-flex align-items-center">
							                    <div class="font-35 text-success"><i class="bx bxs-check-circle"></i>
							                    </div>
							                    <div class="ms-3">
							                        <h6 class="mb-0 text-success">Success</h6>
							                        <div><?= session()->get('sucmsg'); ?></div>
							                    </div>
							                </div>
							                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
							            </div>
							        <?php endif ?>
							        <?php if (session()->get('failmsg')): ?>
							        <div class="alert border-0 border-start border-5 border-danger alert-dismissible fade show py-2">
							            <div class="d-flex align-items-center">
							                <div class="font-35 text-danger"><i class="bx bxs-message-square-x"></i>
							                </div>
							                <div class="ms-3">
							                    <h6 class="mb-0 text-danger">Failed!</h6>
							                    <div><?= session()->get('failmsg'); ?></div>
							                </div>
							            </div>
							            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
							        </div>
							        <?php endif ?>
									
									<div class="form-body">
										<form class="row g-3" method="post" enctype="multipart/form-data">
											<?= csrf_field(); ?>
											<div class="col-md-6">
												<label for="formFile" class="form-label">Company Profile</label>
												<input class="form-control" type="file" id="formFile" name="company_logo">
											</div>
											
											<div class="col-md-6">
												<label for="inputLastName" class="form-label"><?= langg(get_setting(company($user['id']),'language'),'Company Name'); ?></label>
												<input type="text" class="form-control" name="cname"  required> 
											</div>
											<div class="col-md-4">
												<label for="inputLastName" class="form-label"><?= langg(get_setting(company($user['id']),'language'),'Company Email'); ?></label>
												<input type="email" class="form-control" name="cemail" required> 
											</div>

											<div class="col-md-4">
												<label class="form-label"><?= langg(get_setting(company($user['id']),'language'),'Company Number'); ?></label>
												<input type="number" class="form-control" placeholder="" name="cnumber" required>
											</div>

											<div class="col-md-4 ">
				                                <label>Country</label> 
				                                <select class="form-select" name="country" id="country_select" required> 
				                                    <?php foreach (countries_array(company($user['id'])) as $ct): ?>
				                                       <option value="<?= $ct['country_name'] ?>"><?= $ct['country_name'] ?></option>
				                                    <?php endforeach ?>
				                                </select>
				                            </div>

				                             <div class="col-md-4 ">
				                                <label>State/Governorate/Emirates</label> 
				                                <div class="position-relative" id="layerer">
				                                    
				                                    <select class="form-select" name="state" id="state_select_box" required>
				                                        <option value="">Choose</option>
				                                        <?php foreach (states_array(company($user['id'])) as $st): ?>
				                                            <option value="<?= $st ?>"><?= $st ?></option>
				                                        <?php endforeach ?>
				                                    </select>
				                                </div>
				                            </div>

				                            <div class="col-md-4 ">
				                                <label>City</label>
				                                <input type="text" class="form-control" name="city"  required>
				                            </div>

				                            

				                            <div class="col-md-4 ">
				                                <label>Postal Code</label>
				                                <input type="number" class="form-control" name="postal_code" required>
				                            </div>

											<div class="col-12 text-center">
												
													<button class="w-50 aitsun-primary-btn infinite_spinner"  name="save_companies"><?= langg(get_setting(company($user['id']),'language'),'Save Company'); ?></button>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!--end row-->
			</div>
		</div>
	</div>

	<input type="hidden" id="base_url" value="<?= base_url(); ?>">
	<!--end wrapper-->
	<!-- Bootstrap JS -->
	<script src="<?= base_url('public'); ?>/js/bootstrap.bundle.min.js"></script>
	<!--plugins-->
	<script src="<?= base_url('public'); ?>/js/custom.js?v=<?= script_version(); ?>"></script>
	<!--Password show & hide js -->
	
	<!--app JS-->

	<script type="text/javascript">
		$(document).ready(function(){
			$(document).on('click','.infinite_spinner',function(){
					var this_btn_content=$(this).html();
					var this_btn=$(this);
					var rep_btn_content=this_btn_content;

					 
				    $(this).html('<div class="spinner-grow spinner-grow-sm" role="status"> <span class="visually-hidden">Saving...</span></div>');
					// $(this_btn).prop('disabled',true);
					setTimeout(function(){
						$(this_btn).html(rep_btn_content);
						// $(this_btn).prop('disabled',false);
					},3000);
					
			})
		});
	</script>
</body>

</html>