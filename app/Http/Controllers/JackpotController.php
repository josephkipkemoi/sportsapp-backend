<?php

namespace App\Http\Controllers;

use App\Http\Requests\JackpotRequest;
use App\Models\Jackpot;
use Illuminate\Http\Request;

class JackpotController extends Controller
{
    //
    public function store(Jackpot $jackpot, JackpotRequest $request)
    {
    //    return $jackpot->create($request->validated());
    }
}
