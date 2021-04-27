<?php
	require 'FileOps.php';
	require 'Sum.php';
	class TableDisplay
	{
		public function dispCtl($catalogue){
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
			FileOps::add($catalogue, $_POST['button']);
			// return $_POST['button'];
		}
		public function dispBsk($b){
			$basket = FileOps::connect();
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
			$total = TotalCalculator::totalSum($basket);
			echo "<br><p>Total: '$total'";
			echo "</form>";
			if($b)
			FileOps::remove($basket, $_POST['remove']);
			// return $_POST['remove'];
		}
	}
?>