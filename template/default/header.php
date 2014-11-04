<html>
<head>
	<title><?php print HEADER; ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<!-- DataTables CSS -->
	<link rel="stylesheet" type="text/css" href="/addressbook/DataTables-1.10.2/media/css/jquery.dataTables.css">
	  
	<!-- jQuery -->
	<script type="text/javascript" charset="utf8" src="/addressbook/DataTables-1.10.2/media/js/jquery.js"></script>
	  
	<!-- DataTables -->
	<script type="text/javascript" charset="utf8" src="/addressbook/DataTables-1.10.2/media/js/jquery.dataTables.js"></script>
	
	<script type="text/javascript" charset="utf8" src="/addressbook/DataTables-1.10.2/extensions/FixedHeader/js/dataTables.fixedHeader.min.js"></script>
	<link rel="stylesheet" href="/addressbook/DataTables-1.10.2/extensions/FixedHeader/css/dataTables.fixedHeader.min.css">
		
	<script type="text/javascript" charset="utf8" src="/addressbook/DataTables-1.10.2/extensions/Responsive/js/dataTables.responsive.js"></script>
	<link rel="stylesheet" href="/addressbook/DataTables-1.10.2/extensions/Responsive/css/dataTables.responsive.css">
	
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="/addressbook/bootstrap/css/bootstrap.min.css">
	
	<!-- Optional theme -->
	<link rel="stylesheet" href="/addressbook/bootstrap/css/bootstrap-theme.min.css">
	
	<!-- Latest compiled and minified JavaScript -->
	<script src="/addressbook/bootstrap/js/bootstrap.min.js"></script>
	
	<link rel="stylesheet" type="text/css" href="<?php print "/addressbook/template/$template/css"; ?>/style.css" />
	
	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	  ga('create', 'UA-29533308-2', 'auto');
	  ga('send', 'pageview');

	</script>
	
</head>

<body>
	<div class="container-fluid">
		<div class="row">
			<header class="col-xs-12">
				<div class="col-xs-12 text-center">
					<h1 >
					    <!--<a href="<?php $_SERVER['PHP_SELF'] ?>" class="">-->
						<?php print HEADER; ?>
					   <!-- </a>-->
					</h1>
				</div>		
			</header>
		</div>
		<?php if (isset($_SESSION['username'])): ?>
		<div class="row">
			<ul class="nav nav-pills nav-justified col-xs-12">
				<li><a href="/addressbook/index.php"><?php print SEARCH; ?></a></li>
				<li><a onclick="add()"><?php print ADD_CONTACT; ?></a></li>
				<?php if (isset($_SESSION['admin']) && ($_SESSION['admin'] == "yes")): ?>
					<li><a href="/addressbook/users/user.php"><?php print USERS_MANAGEMENT; ?></a></li>
				<?php endif; ?>
				<li><a href="/addressbook/index.php?logout=1"><?php print LOGOUT; ?></a></li>
			</ul>
		</div>
		<?php endif; ?>