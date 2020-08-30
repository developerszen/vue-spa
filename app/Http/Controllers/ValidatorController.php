<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ValidatorController extends Controller
{
    function unique(Request $request)
    {
        $args = $request->input('args');
        $value = $request->input('value');
        $id = $args[2] === 'undefined' ? null : $args[2];

        $valid = DB::table($args[0])->where($args[1], $value)
            ->where('deleted_at', null)
            ->when($id, function ($query) use ($id) {
                $query->whereNotIn('id', [$id]);
            })->exists();

        return response()->json([
            'valid' => !$valid
        ]);
    }
}
