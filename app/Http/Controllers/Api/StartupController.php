<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Startup;
use Illuminate\Http\Request;

class StartupController extends Controller
{
    public function index()
    {
        return response()->json(Startup::all());
    }

    public function store(Request $request)
    {
        $startup = Startup::create($request->all());
        return response()->json($startup, 201);
    }

    public function show($id)
    {
        return response()->json(Startup::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $startup = Startup::findOrFail($id);
        $startup->update($request->all());
        return response()->json($startup, 200);
    }

    public function destroy($id)
    {
        Startup::destroy($id);
        return response()->json(null, 204);
    }
}
