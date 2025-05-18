<?php

namespace App\Http\Controllers;

use App\Models\BaseModel;
use App\Models\SkinCondition;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class SkinConditionController extends Controller
{
    /**
     * Returns a list of all skin conditions
     *
     * @return JsonResource
     */
    public function index()
    {
        $skinConditions = SkinCondition::all();

        return new JsonResource($skinConditions);
    }

    public function show(SkinCondition $skinCondition) {
        return new JsonResource($skinCondition);
    }

    public function destroy(SkinCondition $skinCondition) {
        return $skinCondition->delete();
    }

    public function store(Request $request) {
        return $this->save($request);
    }

    public function update(Request $request, SkinCondition $skinCondition) {
        return $this->save($request, $skinCondition);
    }

    public function save(Request $request, ?SkinCondition $skinCondition = null) {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'description' => ['required', 'string', 'max:4096'],
            'image' => ['nullable', 'image', 'mimes:jpg,bmp,png', 'max:20480']
        ]);

        $skinCondition = $skinCondition ?? new SkinCondition();

        $skinCondition->fill(Arr::except($validated, 'image'));

        if ($validated['image']) {
            $filename = BaseModel::generatRandomFilename() . '.' . $validated['image']->extension();
            $path = BaseModel::generateRandomPath();
            $skinCondition->image_filename = $filename;
            $skinCondition->image_path = $path;

            $validated['image']->storeAs('files/' . $path, $filename, 'public');
        }

        $skinCondition->save();

        return $this->show($skinCondition);
    }
    
}
