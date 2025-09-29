<?php

namespace App\Enum;
enum ProjectStatus: string

{

    case Todo = 'todo';
    case Doing = 'doing';
    case Done = 'done';


    public function getLabel(): string

    {

        return match ($this) {

            self::Todo => 'To Do',

            self::Doing => 'Doing',

            self::Done => 'Done',

        };

    }

}
