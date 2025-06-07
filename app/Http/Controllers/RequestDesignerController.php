<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RequestDesigner;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class RequestDesignerController extends Controller
{
    public function store(Request $request, $designerId)
    {
        $validated = $request->validate([
            'land_size' => 'required|string|max:50',
            'land_shape' => 'required|string|max:50',
            'sun_orientation' => 'required|string|max:100',
            'wind_orientation' => 'required|string|max:100',
            'province_id' => 'required|string|max:10',
            'city_id' => 'required|string|max:10',
            'budget' => 'nullable|numeric',
            'deadline' => 'nullable|date',
            'notes' => 'required|string',
            'design_reference_path' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:16384',
        ]);

        $designReferencePath = null;
        if ($request->hasFile('design_reference_path')) {
            $file = $request->file('design_reference_path');
            $designReferencePath = $file->store('design_references', 'public');
        }

        // Get province and city names
        $provinceResponse = Http::get("https://www.emsifa.com/api-wilayah-indonesia/api/province/{$validated['province_id']}.json");
        $cityResponse = Http::get("https://www.emsifa.com/api-wilayah-indonesia/api/regency/{$validated['city_id']}.json");

        $provinceName = $provinceResponse->successful() ? $provinceResponse->json()['name'] : '';
        $cityName = $cityResponse->successful() ? $cityResponse->json()['name'] : '';

        $designerRequest = RequestDesigner::create([
            'client_id' => Auth::id(),
            'designer_id' => $designerId,
            'land_size' => $validated['land_size'],
            'land_shape' => $validated['land_shape'],
            'sun_orientation' => $validated['sun_orientation'],
            'wind_orientation' => $validated['wind_orientation'],
            'province' => $provinceName,
            'city' => $cityName,
            'budget' => $validated['budget'] ?? null,
            'deadline' => $validated['deadline'] ?? null,
            'notes' => $validated['notes'],
            'design_reference_path' => $designReferencePath,
            'purchased_design_id' => null,
            'status' => 'waiting',
            'progress' => 'form_submitted',
        ]);

        return response()->json([
            'message' => 'Request berhasil dikirim.',
            'data' => $designerRequest
        ], 201);
    }

    public function show(RequestDesigner $requestDesigner)
    {
        return response()->json($requestDesigner);
    }
}
