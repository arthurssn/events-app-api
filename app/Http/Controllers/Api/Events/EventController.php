<?php

namespace App\Http\Controllers\Api\Events;

use App\Http\Controllers\Controller;
use App\Http\Resources\Events\EventResource;
use App\Models\Events\Event;
use App\Actions\Events\RegisterToEventAction;
use Symfony\Component\HttpKernel\Exception\HttpException;

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
      RegisterToEventAction::execute($event);
      return $this->success(true, 'Inscricao realizada com sucesso');
    } catch (HttpException $e) {
      return $this->error($e->getMessage(), $e->getStatusCode());
    } catch (\Throwable $th) {
      return $this->error();
    }
  }
}
