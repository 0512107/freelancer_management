<!doctype html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Error 404</title>
		<meta name="msapplication-TileColor" content="#5bc0de" />
		<link rel="stylesheet" href="<?php echo HTTP_LIB_PATH ?>bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="http://netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="<?php echo HTTP_CSS_PATH; ?>style.css">
		<link rel="stylesheet" href="<?php echo HTTP_LIB_PATH ?>animate/animate.min.css">
		<link rel="stylesheet" href="<?php echo HTTP_LIB_PATH ?>validationEngine/css/validationEngine.jquery.css">
		<script type="text/javascript">
			var base_url = '<?php echo base_url() ?>';
		</script>
	</head>
	
	<body class="error">
    <div class="container">
      <div class="col-lg-8 col-lg-offset-2 text-center">
        <div class="logo">
          <h1>404</h1>
        </div>
        <p class="lead text-muted">Nope, not here.</p>
        <div class="clearfix"></div>
        <br>
        <div class="col-lg-6  col-lg-offset-3">
          <div class="btn-group btn-group-justified">
            <a href="<?php echo base_url(); ?>dashboard" class="btn btn-info">Return Dashboard</a>
			<?php 
				if ($this->session->userdata("role") == "admin") {
					echo "<a class='btn btn-warning' href='" . base_url() . "admin/projects" . "'>Return Project List </a>";
				} else {
				echo "<a class='btn btn-warning' href='" . base_url() . "user/projects" . "'>Return Project List </a>";
				}
			?>
          </div>
        </div>
      </div><!-- /.col-lg-8 col-offset-2 -->
    </div>
  </body>
</html>