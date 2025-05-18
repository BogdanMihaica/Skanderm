<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlanController extends Controller
{
    /**
     * Returns a list of all plans
     *
     * @return AnnonymousResourceCollection
     */
    public function index()
    {
        $plans = Plan::all();

        return JsonResource::collection($plans);
    }

    public function show(Plan $plan) {
        return New JsonResource($plan);
    }

    public function update(Request $request, Plan $plan) {
        $validated = $request->validate([
            'is_active' => 'required|boolean'
        ]);

        $plan->fill($validated);
        $plan->save();
        
        return $this->show($plan);
    }
}
