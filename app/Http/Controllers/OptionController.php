<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateOptionRequest;
use App\Models\Option;
use Inertia\Inertia;

class OptionController extends Controller
{
    public function edit(Option $option)
    {
        return Inertia::render('Admin/Option', ['option' => $option]);
    }

    public function update(UpdateOptionRequest $request, Option $option)
    {
        $option->message = $request->message;
        $option->register = $request->boolean('register');
        $option->save();

        return redirect()->route('admin.option.edit', $option)->with('success', 'Options updated.');
    }
}
