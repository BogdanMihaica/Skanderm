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

        return new JsonResource($plans);
    }
}
