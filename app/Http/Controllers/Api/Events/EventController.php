<?php

namespace App\Http\Controllers\Api\Events;

use App\Http\Controllers\Controller;
use App\Http\Resources\Events\EventResource;
use App\Models\Events\Event;

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
}
