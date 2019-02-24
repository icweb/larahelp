<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attachment extends BaseClass
{
    protected $fillable = [
        'ticket_id',
        'disk_path',
        'file_name',
        'file_size',
        'file_extension',
    ];

    protected $appends = [
        'full_disk_path'
    ];

    public function getFullDiskPathAttribute()
    {
        return $this->disk_path . '' .  $this->file_name;
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
