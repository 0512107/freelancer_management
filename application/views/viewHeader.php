<?php 
	$ci = &get_instance();
	$ci->load->model('ModelProjects');
	$likeQuery = '"id":"' . $this->session->userdata("id") . '"';
	$listProjectMenu = $ci->ModelProjects->search("id, code, name", array("is_completed" => 0), array("members" => $likeQuery), "name DESC", 5);
?>

<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		
		<title><?php echo $pageTitle ?></title>
		
		<link href="<?php echo HTTP_LIB_PATH; ?>/bootstrap/css/bootstrap.css" rel="stylesheet">
		<link rel="stylesheet" href="http://netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="<?php echo HTTP_CSS_PATH; ?>style.css">
		<link rel="stylesheet" href="<?php echo HTTP_LIB_PATH; ?>metismenu/metisMenu.min.css">
		
		<link rel="stylesheet" href="<?php echo HTTP_CSS_PATH; ?>style-switcher.css">
		<link rel="stylesheet/less" type="text/css" href="<?php echo HTTP_CSS_PATH; ?>less/theme.less">
		<?php 
			if (isset($pluginsCSS)) {
				foreach($pluginsCSS as $key => $css) {
					echo '<link rel="stylesheet" href="' . $css . '">';
				}
			}
		?>
		<script>
			var base_url = '<?php echo base_url(); ?>';
		</script>
		
		<script src="<?php echo HTTP_LIB_PATH; ?>less/less-1.7.5.min.js"></script>
		<script src="<?php echo HTTP_LIB_PATH; ?>modernizr/modernizr.min.js"></script>
	</head>
	
	<body class="  ">
		<div class="bg-dark dk" id="wrap">
			<div id="left" class="hidden-sm">
				<div id="user_logged" class="media user-media bg-dark dker">
					<div class="user-media-toggleHover">
						<span class="fa fa-user"></span> 
					</div>
					<div class="user-wrapper bg-dark">
						
						<div class="media-body">
							<h5 class="media-heading"><?php echo "Hello " . $this->session->userdata('full_name'); ?></h5>
							<ul class="list-unstyled user-info">
								<li> <a href=""><?php echo "Role: " . ucfirst($this->session->userdata('role')); ?></a>  </li>
							</ul>
						</div>
					</div>
				</div>
				
				<ul id="menu" class="bg-blue dker">
					<li class="nav-header">Menu</li>
					<li class="nav-divider"></li>
					<li <?php echo  $page =='dash' ? 'class="active"' : '' ?>>
						<a href="<?php echo base_url() ?>dashboard">
						  <i class="fa fa-dashboard <?php echo $page =='dash' ? 'fa-spin' : '' ?>"></i><span class="link-title">&nbsp;Dashboard</span> 
						</a> 
					</li>
					<li <?php echo $page =='projects' ? 'class="active"' : '' ?>>
						<a href="javascript:;">
						  <i class="fa fa-tasks"></i>
						  <span class="link-title">&nbsp;Projects</span> 
						  <span class="fa arrow"></span>
						</a>
						<ul>
							<?php 
								foreach ($listProjectMenu as $key => $project) {
							?>
								<li class="<?php echo (isset($subPage) && $subPage == "project_{$project['id']}") ? "active" : '' ?>"><a href="<?php echo base_url() . 'project/'  . $project["id"] ?>"><i class='fa fa-archive <?php echo isset($subPage) && $subPage == "project_{$project['id']}"  ? 'fa-spin' : '' ?>'></i>&nbsp; <?php echo $project["name"] ?></a></li>
							<?php
							}
							?>
							<li id="more_project" class="<?php echo (isset($subPage) && $subPage == "projects") ? "active" : '' ?>"> 
								<?php if ($this->session->userdata("role") == "admin") { ?>
									<a href="<?php echo base_url() . "admin/projects"?>"><i class="fa fa-ellipsis-h <?php echo (isset($subPage) && $subPage == 'projects') ? 'fa-spin' : '' ?>"></i>&nbsp; More project</a>
								<?php } else { ?>
									<a href="<?php echo base_url() . "user/projects"?>"><i class="fa fa-ellipsis-h <?php echo isset($subPage) && $subPage =='projects' ? 'fa-spin' : '' ?>"></i>&nbsp; More project</a>
								<?php } ?>
							</li>
						</ul>
					</li>
					<li class="nav-divider"></li>
					<?php if ($this->session->userdata("role") == "admin") { ?>
					<li <?php echo  $page =='customers' ? 'class="active"' : '' ?>>
						<a href="<?php echo base_url() ?>admin/customers">
						  <i class="fa fa-user-circle-o <?php echo  $page =='customers' ? 'fa-spin' : '' ?>"></i><span class="link-title">&nbsp;Customer</span> 
						</a> 
					</li>
					<li <?php echo  $page =='users' ? 'class="active"' : '' ?>>
						<a href="<?php echo base_url() ?>admin/users">
						  <i class="fa fa-users <?php echo  $page =='users' ? 'fa-spin' : '' ?>""></i><span class="link-title">&nbsp;Users</span> 
						</a> 
					</li>
					<li class="nav-divider"></li>
					<?php } ?>
					
					<li <?php echo  $page =='personal-infor' ? 'class="active"' : '' ?>>
						<a href="<?php echo base_url() ?>user/personal_infor">
						  <i class="fa fa-info <?php echo  $page =='personal-infor' ? 'fa-spin' : '' ?>"></i><span class="link-title">&nbsp;&nbsp;&nbsp;Personal Infor</span> 
						</a> 
					</li>
					<li <?php echo  $page =='update-pass' ? 'class="active"' : '' ?>>
						<a href="<?php echo base_url() ?>login/update_pass">
						  <i class="fa fa-key <?php echo  $page =='update-pass' ? 'fa-spin' : '' ?>"></i><span class="link-title">&nbsp;Update Password</span> 
						</a> 
					</li>
					<li>
						<a href="<?php echo base_url() ?>logout">
						  <i class="fa fa-sign-out"></i><span class="link-title">&nbsp;Logout</span> 
						</a> 
					</li>
				</ul>
			</div>
			
			<div id="right" class="bg-light lter">
				<div>content right</div>
			</div>
			
			<div id="content">
				
					