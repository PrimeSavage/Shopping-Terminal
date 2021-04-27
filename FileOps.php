<?php
	class FileOps
	{
		public function connect(){
			return unserialize(file_get_contents("basketFile.txt"));
		}
		public function add($catalogue, $add){
			$basket = unserialize(file_get_contents("basketFile.txt"));
			foreach ($catalogue as $value){
				if($value->name == $add){
				$basket[] = $value;
				$newBasket = serialize($basket);
				file_put_contents("basketFile.txt", $newBasket);
				} 
			}
		}
		public function remove($basket, $rmv){
			$basket = unserialize(file_get_contents("basketFile.txt"));
			if($basket){
			// Product::display($basket);
			if(isset($rmv)){ // on button click in display a product is being removed
				$remove = $rmv-1;
				unset($basket[$remove]);
				$basket = array_values($basket);
				$newBasket = serialize($basket);
				file_put_contents("basketFile.txt", $newBasket);
				TableDisplay::dispBsk(false);
				}
			}
		}
	}
?>