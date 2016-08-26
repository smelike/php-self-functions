<?php

	use Ramsey\Uuid\Uuid;

	trait UUIDModel
	{
		public $incrementing = false;
		
		protected static function boot()
		{
			parent::boot();
			static::creating(function ($model) {
				$key = $model->getKeyName();
				if (empty($model->{$key})) {
					$model->{$key} = (string) $model->generateNewId();
				}
			});
		}
		
		public function generateNewUuid()
		{
			return Uuid::uuid4();
		}
	}
