<?php

namespace App\Enums;

enum Permission: int
{
    case titleCreate = 1000;
    case titleEdit = 1001;
    case titleDelete = 1002;
    case titleRead = 1003;
}
