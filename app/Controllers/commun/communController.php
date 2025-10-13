<?php

namespace App\Controllers\commun;
use App\Controllers\BaseController;

class communController extends BaseController
{
    public function MentionLegale():string
    {
        return view('commun\MentionsLegales').
            view('commun\footer');
    }
}