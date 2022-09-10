<?php

namespace App\Http\Controllers;

use App\Models\Tooltip;
use Illuminate\Http\Request;

class TooltipController extends Controller
{
    //
    public function show(Tooltip $tooltip, Request $request)
    {
        return $tooltip->where('user_id', $request->query('user_id'))->get('tooltip_active')->first();
    }

    public function update(Tooltip $tooltip, Request $request)
    {
        return $tooltip->where('user_id', $request->query('user_id'))
                       ->create([
                            'user_id' => $request->input('user_id'),
                            'tooltip_active' => $request->input('tooltip_status')
                        ]);
    }
}
