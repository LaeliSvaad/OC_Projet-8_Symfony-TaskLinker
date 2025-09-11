<?php

namespace App\Enum;
enum EmployeeContract: string

{

    case CDI = 'CDI';
    case CDD = 'CDD';
    case Freelance = 'freelance';


    public function getLabel(): string

    {

        return match ($this) {

            self::Freelance => 'Freelance',

            self::CDI => 'CDI',

            self::CDD => 'CDD',

        };

    }

}
