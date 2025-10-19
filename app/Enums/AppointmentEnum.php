<?php

namespace App\Enums;

enum AppointmentEnum: int
{
    case SCHEDULED = 1;
    case COMPLETED = 2;
    case CANCELED = 3;

    public function label(): string
    {
        return match($this) {
            self::SCHEDULED => 'Programado',
            self::COMPLETED => 'Completado',
            self::CANCELED => 'Cancelado',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::SCHEDULED => 'blue',
            self::COMPLETED => 'green',
            self::CANCELED => 'red',
        };
    }

    public function colorHex(): string
    {
        return match($this) {
            self::SCHEDULED => '#007bff',
            self::COMPLETED => '#28a745',
            self::CANCELED => '#dc3545',
        };
    }

    public function isEditable(): bool
    {
        return $this === self::SCHEDULED;
    }
}
