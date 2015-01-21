<?php

use Illuminate\Database\Eloquent\ScopeInterface;
use Illuminate\Database\Eloquent\Builder;

class RequireEmailScope implements ScopeInterface {

	/**
	 * Join the e-mail address table so we can log them in.
	 * 
	 * @param  Builder $builder
	 * @return [type]          
	 */
	public function apply(Builder $builder) {
		$model = $builder->getModel();

		$builder->select($model->getTable() . '.*');
		$builder->join(
			'party_email',
			'party_email' . '.' . 'party_id',
			'=',
			$model->getTable() . '.' . 'party_id'
		);
	}

	public function remove(Builder $builder) {

	}
}
