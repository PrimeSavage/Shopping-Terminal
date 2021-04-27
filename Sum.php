<?php
	class TotalCalculator
	{
		public function totalSum($basket){	// this method distributes products by classes and calculates the total price
			// require 'Product.php';
			// require 'ProductWVolume.php';
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
?>