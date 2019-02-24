<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class BaseClass extends Model
{
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        parent::creating(function(BaseClass $record){

            if(
            Schema::hasColumn($record->getTable(), 'author_id')
            )
            {
                $record->author_id = auth()->id();
            }

        });
    }

    public function author()
    {
        return $this->belongsTo(User::class);
    }
}