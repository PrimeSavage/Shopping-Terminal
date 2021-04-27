<?php
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
	}
?>