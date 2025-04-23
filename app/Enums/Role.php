<?php

namespace App\Enums;

enum Role: string
{
  case ADMIN = 'admin';
  case STUDENT = 'student';
  case COORDINATOR = 'coordinator';
  case EXTERNAL = 'external';

  public function label(): string
  {
    return match ($this) {
      self::STUDENT => 'Aluno',
      self::COORDINATOR => 'Coordenador',
      self::ADMIN => 'Administrador',
      self::EXTERNAL => 'Externo',
    };
  }
}
