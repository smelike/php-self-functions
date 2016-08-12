<?php

	class Post extends Eloquent
	{
		protected static function boot()
		{
			parent::boot();
			static::updating(function($model)
			{
				return false;
			});
		}
	}

?>
