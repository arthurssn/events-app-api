<?php

namespace App\Models\Events;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Event extends Model
{
  protected $fillable = [
    'title',
    'description',
    'available_slots',
    'start_at',
    'end_at',
    'aacc_hours',
    'parent_id',
    'photo',
    'location'
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

  public function registerToEvent(User $user)
  {
    if ($this->parent_id === null) {
      throw new \Exception('Só é possível se inscrever em tarefas (eventos filhos).', 422);
    }

    if ($this->available_slots <= 0) {
      throw new \Exception('Não há vagas disponíveis para esse evento.', 409);
    }

    if (EventRegistration::active()->where('user_id', $user->id)->where('event_id', $this->id)->exists()) {
      throw new \Exception('Você já está inscrito neste evento.', 409);
    }

    $qrCode = Str::uuid();

    $registration = EventRegistration::updateOrCreate([
      'user_id' => $user->id,
      'event_id' => $this->id,
    ], [
      'qr_code' => $qrCode,
      'canceled_at' => null
    ]);

    $this->decrement('available_slots');

    return $registration;
  }

  public function duration()
  {
    return $this->start_at->diffInMinutes($this->end_at);
  }
}
