<?php

	public function save(array $options = array())
	
	protected function performUpdate(Builder $query, array $options = [])
	{
		if ($this->timestamps && array_get($options, 'timestamp', true))
		{
			$this->updateTimestamps();
		}
		
		$product = Product::find($id);
		$product->update_at = '2016-08-19 18:00:00';
		$product->save(['timestamp' =>false]);
	}
 
