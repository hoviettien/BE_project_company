<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Speaker;
use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class SpeakerController extends Controller
{
    public function index()
    {
        return response()->json(Speaker::all());
    }

    public function store(Request $request)
    {
        $data = $request->all();

        if ($request->hasFile('image')) {
            $uploaded = Cloudinary::upload(
                $request->file('image')->getRealPath(),
                ['folder' => 'speakers']
            );
            $data['image_url'] = $uploaded->getSecurePath();
        }

        $speaker = Speaker::create($data);
        return response()->json($speaker, 201);
    }

    public function show($id)
    {
        return response()->json(Speaker::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $speaker = Speaker::findOrFail($id);
        $data = $request->all();

        if ($request->hasFile('image')) {
            $uploaded = Cloudinary::upload(
                $request->file('image')->getRealPath(),
                ['folder' => 'speakers']
            );
            $data['image_url'] = $uploaded->getSecurePath();
        }

        $speaker->update($data);
        return response()->json($speaker, 200);
    }

    public function destroy($id)
    {
        Speaker::destroy($id);
        return response()->json(null, 204);
    }
}
