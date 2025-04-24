<?php

namespace App\Http\Controllers\Api\Events;

use App\Actions\Events\CancelRegisterEventAction;
use App\Http\Controllers\Controller;
use App\Http\Resources\Events\EventResource;
use App\Models\Events\Event;
use App\Models\Events\EventRegistration;

class EventController extends Controller
{
  public function index()
  {
    try {
      $events = Event::with('children')
        ->whereNull('parent_id')
        ->get();
      return $this->success(EventResource::collection($events), 'Eventos carregados com sucesso');
    } catch (\Throwable $th) {
      return $this->error($th->getMessage(), $th->getCode());
    }
  }

  public function show(Event $event)
  {
    try {
      $event->load('children');

      return $this->success(new EventResource($event), 'Evento carregado com sucesso');
    } catch (\Throwable $th) {
      return $this->error($th->getMessage(), $th->getCode());
    }
  }

  public function register(Event $event)
  {
    try {
      $event->registerToEvent(auth()->user());
      return $this->success(true, 'Inscricao realizada com sucesso');
    } catch (\Throwable $th) {
      return $this->error($th->getMessage());
    }
  }

  public function myRegistrations()
  {
    try {
      $registrations = auth()->user()->eventRegistrations()->with('event')->where('canceled_at', null)->with('event')->get();

      return $this->success($registrations, 'Eventos carregados com sucesso.');
    } catch (\Throwable $th) {
      return $this->error($th->getMessage());
    }
  }

  public function cancelRegistration(int $id)
  {
    try {
      $eventRegistration = EventRegistration::findOrFail($id);
      $eventRegistration->cancelRegistration();

      return $this->success(null, 'Inscrição cancelada com sucesso.');
    } catch (\Throwable $th) {
      return $this->error($th->getMessage());
    }
  }
}
