<?php 

	class Post extends Eloquent
	{
		pulic static $autoValidate = true;
		protected static $rules = array();
		
		protected static function boot()
		{
			parent::boot();
			// You cane replace this with static::creating or static::updating
			static::saving(function($model)
				if ($model::$autoValidate)
				{
					return $model->validate();
				}
			)
		}
		public function validate()
		{
		}

	}
?>
