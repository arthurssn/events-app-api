<?php

namespace Database\Seeders;

use App\Models\Events\Event;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class EventSeeder extends Seeder
{
  public function run(): void
  {
    $devDay = Event::create([
      'title' => 'DevDay',
      'description' => 'Um dia inteiro de programação e palestras.',
      'start_at' => Carbon::parse('2025-05-10 08:00'),
      'end_at' => Carbon::parse('2025-05-10 18:00'),
      'available_slots' => 0,
      'aacc_hours' => 0,
    ]);

    Event::create([
      'title' => 'Palestra: Laravel na prática',
      'description' => 'Uma palestra sobre boas práticas em Laravel.',
      'start_at' => Carbon::parse('2025-05-10 09:00'),
      'end_at' => Carbon::parse('2025-05-10 10:30'),
      'available_slots' => 50,
      'aacc_hours' => 1.5,
      'parent_id' => $devDay->id,
    ]);

    Event::create([
      'title' => 'Workshop: React Native do Zero',
      'description' => 'Aprenda os conceitos básicos de React Native.',
      'start_at' => Carbon::parse('2025-05-10 11:00'),
      'end_at' => Carbon::parse('2025-05-10 13:00'),
      'available_slots' => 30,
      'aacc_hours' => 2.0,
      'parent_id' => $devDay->id,
    ]);

    Event::create([
      'title' => 'Palestra: Educação Pública e Acessível',
      'description' => 'Discussão sobre políticas públicas educacionais.',
      'start_at' => Carbon::parse('2025-05-15 14:00'),
      'end_at' => Carbon::parse('2025-05-15 15:30'),
      'available_slots' => 80,
      'aacc_hours' => 1.5,
    ]);
  }
}
