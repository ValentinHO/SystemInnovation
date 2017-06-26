<header class="menu" >
	<input type="checkbox" id="toggle" checked value="6887" >
	
	<div class="icon-menu le">
		<label for="toggle"><img src="img/menu.png"></label>
	</div>
	
	<div class="logo-header le">
		System Innovation
	</div>

	<div class="usernamemenu le">
		Bienvenido <?php echo $_SESSION['nombreUsuario']; ?>
		<label class="letter-main"><?php echo substr($_SESSION['nombreUsuario'],0,1); ?></label>
		<a href="#" id="logout"><i class="fa fa-sign-out fa-fw"></i> Salir</a>
	</div>

	<nav class="menu-lateral" id="menu-lateral">
		<ul>
			<li><a href="main.php"><i class="fa fa-home fa-fw"></i> Inicio</a></li>
			<li><a href="mechanics.php"><i class="fa fa-user fa-fw"></i> Mecánicos</a></li>
			<li><a href="tips.php"><i class="fa fa-info fa-fw"></i> Tips</a></li>
			<li><a href="services.php"><i class="fa fa-wrench fa-fw"></i> Servicios</a></li>
			<li><a href="reports.php"><i class="fa fa-book fa-fw"></i> Reportes</a></li>
			<!--<li><a href="settings.php"><i class="fa fa-gear fa-fw"></i> Configuración</a></li>-->
			<li class="hidden-logout"><a href="#" id="logout"><i class="fa fa-sign-out fa-fw"></i> Salir</a></li>
		</ul>
	</nav>
</header>