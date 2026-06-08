<?php

namespace App\Http\Controllers;

use Override;

class ReflectionController extends LifeController
{
    #[Override]
    public function segment()
    {
        return 'reflection';
    }
}
