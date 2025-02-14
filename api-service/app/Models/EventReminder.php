<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventReminder extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'title',
        'description',
        'date_time',
        'status',
        'reminder_email'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($event) {
            $event->event_id = 'EVENT-' . strtoupper(substr(uniqid(), -5));
        });
    }
}
