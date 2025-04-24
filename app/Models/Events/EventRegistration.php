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
    'canceled_at',
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

  public function cancelRegistration()
  {
    if ($this->event->start_at < now()) {
      throw new \Exception('Você não pode cancelar a inscrição após o evento ter começado.');
    }

    if ($this->checked_in_at) {
      throw new \Exception(' Vocé ja fez check-in neste evento.');
    }

    if ($this->canceled_at) {
      throw new \Exception('Inscrição ja cancelada.');
    }

    $this->update(['canceled_at' => now()]);
    $this->event->increment('available_slots');
  }
}
