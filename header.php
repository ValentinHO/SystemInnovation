<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#"><span>SYSTEM</span>INNOVATION</a>
				<ul class="user-menu">
					<li class="dropdown pull-right">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg> Bienvenido <?php echo $_SESSION['nombreUsuario']; ?> <span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="#"><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg> Profile</a></li>
							<li><a href="#"><svg class="glyph stroked gear"><use xlink:href="#stroked-gear"></use></svg> Settings</a></li>
							<li><a href="#" id="logout"><svg class="glyph stroked cancel"><use xlink:href="#stroked-cancel"></use></svg> Salir</a></li>
						</ul>
					</li>
				</ul>
			</div>
							
		</div><!-- /.container-fluid -->
	</nav>
		
	<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
		
		<ul class="nav menu">
			<li><a href="main.php"><svg class="glyph stroked home"><use xlink:href="#stroked-home"/></svg> Inicio</a></li>
			<li><a href="mechanics.php"><svg class="glyph stroked male user "><use xlink:href="#stroked-male-user"/></svg> Mecánicos</a></li>
			<li><a href="tips.php"><svg class="glyph stroked eye"><use xlink:href="#stroked-eye"/></svg> Tips</a></li>
			<li><a href="services.php"><svg class="glyph stroked table"><use xlink:href="#stroked-table"></use></svg> Servicios</a></li>
			<li><a href="reports.php"><svg class="glyph stroked line-graph"><use xlink:href="#stroked-line-graph"></use></svg> Reportes</a></li>
		</ul>

	</div><!--/.sidebar-->