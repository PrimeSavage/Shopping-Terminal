<html>
	<head>
	<link rel="stylesheet" href="style.css">
	<meta charset="utf-8">
        <title>Shopping Terminal</title>
    </head>
	<body>
		<div class="main">
			<div class="catalogue">
			<?php
			require 'Product.php';
			require 'ProductWVolume.php';
			$catalogue = [];	// a program forms a catalogue of objects
			$catalogue[] = new Product('YB', 12);
			$catalogue[] = new Product("GD", 0.15);
			$catalogue[] = new Product("UK", 5);
			$catalogue[] = new ProductWVolume("ZA", 2, 4, 7);
			$catalogue[] = new ProductWVolume("FC", 1.25, 6, 6);
			$catalogue[] = new ProductWVolume("WE", 0.5, 4, 1);
			require 'Display.php';
			TableDisplay::dispCtl($catalogue);
			?>
			</div>
			<div class="basket" id="del">
			<?php
			TableDisplay::dispBsk(true); 
			?>
			</div>
		</div>
	</body>
</html>