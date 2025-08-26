<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PartnerController extends Controller
{
    public function index()
    {
        return response()->json(Partner::all());
    }

    public function store(Request $request)
    {
        $partner = Partner::create([
            'id' => Str::uuid(),
            'name' => $request->name,
            'logo' => $request->logo,
            'category' => $request->category,
            'url' => $request->url,
            'description' => $request->description,
            'website' => $request->website,
            'event' => $request->event,
        ]);

        return response()->json($partner, 201);
    }

    public function show($id)
    {
        return response()->json(Partner::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $partner = Partner::findOrFail($id);
        $partner->update($request->all());
        return response()->json($partner, 200);
    }

    public function destroy($id)
    {
        Partner::destroy($id);
        return response()->json(null, 204);
    }
}
