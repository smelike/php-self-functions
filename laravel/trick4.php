<?php

	class myModel extends Model
	{
		public function category()
		{
			return $this->belongTo('myCategoryModel', 'categories_id')
				->where('users_id', Auth::user()->id);
		}
	}
	
	$products = Product::where('category', '=', 3)->get();
	
	$products = Product::where('category',3)->get();

	$products = Product::whereCategory(3)->get();
