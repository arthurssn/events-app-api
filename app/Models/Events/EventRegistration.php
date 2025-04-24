<?php

namespace App\Models\Events;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class EventRegistration extends Model
{
  protected $fillable = [
    'user_id',
    'event_id',
    'qr_code',
    'checked_in_at',
    'certificate_path',
  ];

  public $timestamps = true;

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function event()
  {
    return $this->belongsTo(Event::class);
  }
}
