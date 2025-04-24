<?php

namespace App\Models\Events;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
  protected $fillable = [
    'title',
    'description',
    'available_slots',
    'start_at',
    'end_at',
    'aacc_hours',
    'parent_id'
  ];

  protected $casts = [
    'start_at' => 'datetime',
    'end_at' => 'datetime',
    'is_visible' => 'boolean',
    'aacc_hours' => 'decimal:2',
  ];

  public function parent()
  {
    return $this->belongsTo(Event::class, 'parent_id');
  }

  public function children()
  {
    return $this->hasMany(Event::class, 'parent_id');
  }

  public function registrations()
  {
    return $this->hasMany(EventRegistration::class);
  }
}
