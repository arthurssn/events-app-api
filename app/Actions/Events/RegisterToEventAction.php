<?php

namespace App\Actions\Events;

use App\Models\Events\Event;
use App\Models\Events\EventRegistration;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\HttpException;


class RegisterToEventAction
{
  public static function execute(Event $event): EventRegistration
  {
    $user = Auth::user();

    if ($event->parent_id === null) {
      throw new HttpException(422, 'Só é possível se inscrever em tarefas (eventos filhos).');
    }

    if ($event->available_slots <= 0) {
      throw new HttpException(409, 'Não há vagas disponíveis para esse evento.');
    }

    if (EventRegistration::where('user_id', $user->id)->where('event_id', $event->id)->exists()) {
      throw new HttpException(409, 'Você já está inscrito neste evento.');
    }


    $qrCode = Str::uuid();

    $registration = EventRegistration::create([
      'user_id' => $user->id,
      'event_id' => $event->id,
      'qr_code' => $qrCode,
    ]);

    $event->decrement('available_slots');

    return $registration;
  }
}
