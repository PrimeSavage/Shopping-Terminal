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
			class Product
			{
				public $name;
				public $price;
				
				public function __construct($name, $price) {	// main constructor
					$this->name = $name;
					$this->price = $price;
				}
				public function sum($value){	// this method sums price for products w/o volume
					if($value != 0)
					return array_sum(array_column($value, 'price'));
				}
				public function display($basket){	// this method displays a basket as a table
					echo '<script type="text/javascript">',	// this script refreshes a container for a basket
					'document.getElementById("del").innerHTML = "";',
					'</script>';
					echo "<form method='POST'>";
					echo "<table border='1'><tr><th>Order</th><th>    </th></tr>";
					for ($i = 1 ; $i <= count($basket) ; ++$i)
					{
					echo "<tr>";
					echo "<td>";
					print_r($basket[$i-1]->{'name'});
					echo "</td>";
					echo '<td><button type="submit" name="remove" value="'.$i.'">Remove</button></td>';	// delete button
					echo "</tr>";
					}
					echo "</table>";
					$total = ProductWVolume::totalSum($basket);
					echo "<br><p>Total: '$total'";
					echo "</form>";
					return $_POST['remove'];
				}
			}
			class ProductWVolume extends Product
			{
				public $amountToVolume;
				public $volumePrice;
				
				public function __construct($name, $price, $amountToVolume, $volumePrice) {	// main constructor override
					$this->name = $name;
					$this->price = $price;
					$this->amountToVolume = $amountToVolume;
					$this->volumePrice = $volumePrice;
				}
				public function sum($value){	// this method transforms 2 dimension array to 3 to gather all occurences of a product into a separate array
					$extArr = array();
					if($value){
					foreach($value as $data){
						$extArr[$data['name']][] = $data;
						}
					}
					foreach($extArr as $ea){
						$genSum += ProductWVolume::auxSum($ea);
					}
					return $genSum;
				}
				public function auxSum($value){	// this method calculates total price for each array of identical products
					$cnt = count($value);
					$atv = $value[0]['amountToVolume'];
					$vp = $value[0]['volumePrice'];
					$nvp = $value[0]['price'];
					$divInt = intdiv($cnt, $atv);
					$divRest = $cnt % $atv;
					if($cnt < $atv){
						return array_sum(array_column($value, 'price'));
					}
					else{
						$sum = ($divInt*$vp) + ($divRest*$nvp);
						return $sum;
					}
				}
				public function totalSum($basket){	// this method distributes products by classes and calculates the total price
					if(!empty($basket)){
					foreach ($basket as $value){
					if(get_class($value) == 'Product')
					$buffRetail[] = (array) $value;	// this array is calculated by Product class method
					else
					$buffVolume[] = (array) $value;	// this array is calculated by ProductWVolume class method
					}
					return (Product::sum($buffRetail) + ProductWVolume::sum($buffVolume));
					}
				}
			}
			$catalogue = [];	// a program forms a catalogue of objects, which can be added or deleted in code below
			$catalogue[] = new Product('YB', 12);
			$catalogue[] = new Product("GD", 0.15);
			$catalogue[] = new Product("UK", 5);
			$catalogue[] = new ProductWVolume("ZA", 2, 4, 7);
			$catalogue[] = new ProductWVolume("FC", 1.25, 6, 6);
			$catalogue[] = new ProductWVolume("WE", 0.5, 4, 1);
			echo "<form method='POST'>";	// a table for a catalogue
			echo "<table border='1'><tr><th>Name</th><th>Price</th><th>Volume</th><th>    </th></tr>";
			for ($i = 0 ; $i < count($catalogue) ; ++$i)
			{
					$valueName = $catalogue[$i]->{'name'};
					$valuePrice = $catalogue[$i]->{'price'};
					$valueATV = $catalogue[$i]->{'amountToVolume'};
					$valueVP = $catalogue[$i]->{'volumePrice'};
				echo "<tr>";
				echo "<td>$valueName</td>";
				echo "<td>$valuePrice</td>";
				if($valueATV == null || $valueVP == null)
				{echo "<td> - </td>"; }
				else 
				{echo "<td>$valueATV for $valueVP</td>";}
				echo '<td><button type=submit name="button" value="'.$valueName.'">To Basket</button></td>';	// add button
				echo "</tr>";
			}
			echo "</table>";
			echo "</form>";

			$filename = "basketFile.txt";	// since php dies after reaching the end, I`ve decided to store a basket in a file
			$basket = unserialize(file_get_contents($filename));
			foreach ($catalogue as $value){
				if($value->name == $_POST['button']){
				$basket[] = $value;
				$newBasket = serialize($basket);
				file_put_contents($filename, $newBasket);
				} 
			}
			$basket = unserialize(file_get_contents($filename));
			?>
			</div>
			<div class="basket" id="del">
			<?php
			if($basket){
			Product::display($basket);
			if(isset($_POST['remove'])){ // on button click in display a product is being removed
				$remove = $_POST['remove']-1;
				unset($basket[$remove]);
				$basket = array_values($basket);
				$newBasket = serialize($basket);
				file_put_contents($filename, $newBasket);
				Product::display($basket);
				}
			}
			?>
			</div>
		</div>
	</body>
</html>