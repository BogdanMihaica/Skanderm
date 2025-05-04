<?php

namespace App\Http\Controllers;

use App\Models\SkinCondition;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
}
