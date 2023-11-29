<?php
namespace App\Enums;


enum AgeEnum: int
{
    case LESSTHAN25 = 1;
    case FROM25TO35 = 2;
    case MORETHAN35 = 3;
}
