<nav class="navbar navbar-expand-lg py-3 navbar-dark bg-dark shadow-sm">
	<div class="container">
		<a href="#" class="navbar-brand">
			<img id="logo" class="d-inline-block align-middle mr-2"" alt="Logo" src="../assets/logo.png">
			<span class="font-weight-bold">RTLS Asset Management</span>
		</a>

		<button type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler"><span class="navbar-toggler-icon"></span></button>

		<div id="navbarSupportedContent" class="collapse navbar-collapse">
			<ul class="navbar-nav ml-auto">
				<li class="nav-item"><a class="nav-link <?php if ($CURRENT_PAGE == "Index") {?>active<?php }?>" href="index.php">Home</a></li>
				<li class="nav-item"><a class="nav-link <?php if ($CURRENT_PAGE == "About") {?>active<?php }?>" href="about.php">About Us</a></li>
			</ul>
		</div>
  	</div>
</nav>