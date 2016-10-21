<?php

  /*
   *  datetime: August/12/2016 
   *  author: jamesxu
   */

  class Post extends Eloquent
  {
	public static $autoValidate = true;
	protected static $rules = array();
  	
	protected static function boot()
	{
		parent::boot();
		static::saving(function($model)
		{
			if ($model::$autoValidate)
			{
				return $model->validate();
			}
		});
	}
	public function validate() 
	{
	}
  }

?>
