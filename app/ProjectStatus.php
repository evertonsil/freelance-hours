<?php

namespace App;

enum ProjectStatus: string
{
    case Open = 'open';
    case Closed = 'closed';

    public function label(): string
    {
        //o método match nesse caso subsitui uma sequência de if´s
        return match ($this) {
            self::Open => 'Aceitando propostas',
            self::Closed => 'Encerrado',
        };
    }
}
