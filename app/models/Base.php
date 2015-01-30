<?php

use \Venturecraft\Revisionable\RevisionableTrait;

class Base extends Eloquent {

    use RevisionableTrait, ValidatingTrait {
        RevisionableTrait::boot as revisionableBoot;
        ValidatingTrait::boot as validatingBoot;
    }

    public static function boot()
    {
        static::validatingBoot();
        static::revisionableBoot();
    }
}
