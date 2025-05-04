<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Spatie\QueryBuilder\QueryBuilder;

class UserController extends Controller
{
    /**
     * Returns a list of all users, paginated, filterable and sortable
     *
     * @return void
     */
    public function index() {
        $users = QueryBuilder::for(User::class)
            ->with('plan')
            ->allowedSorts(['created_at'])
            ->allowedFilters(['email', 'name', 'plan.name'])
            ->paginate();
        
        return Jsonresource::collection($users);
    }

    /**
     * Returns an instance of an user
     *
     * @param User $user
     * @return JsonResource
     */
    public function show(?User $user=null) {
        if ($user) {
            $user->load(['plan']);

            return new JsonResource($user);
        } else {
            return Auth::user();
        }
    }

    /**
     * Stores a new user.
     *
     * @param Request $request
     * @return JsonResource
     */
    public function store(Request $request) {
        return $this->save($request);
    }

    /**
     * Updates an existing user.
     *
     * @param Request $request
     * @param User $user
     * @return JsonResource
     */
    public function update(Request $request, User $user) {
        return $this->save($request, $user);
    }

    /**
     * Validates and saves a user.
     *
     * @param Request $request
     * @param User|null $user
     * @return JsonResource
     */
    public function save(Request $request, ?User $user = null) {
        // Validate the request
        $validated = $request->validate([
            'email' => [
                'required', 
                'email', 
                $user ? Rule::unique('users')->ignore($user->getKey()) : 'unique:users,email'
            ],
            'password' => [
                $user ? 'nullable' : 'required', 
                'string', 
                'min:8', 
                'confirmed'
            ],
            'name' => [
                $user ? 'nullable' : 'required', 
                'string', 
                'max:100'
            ],
            'plan_id' => [
                'nullable', 
                'exists:plans,id'
            ],
        ]);

        $user = $user ?? new User();
        $user->fill($validated);
        $user->save();

        return $this->show($user);
    }

    /**
     * Deletes an existing user model from the database
     *
     * @param User $user
     * @return bool|null
     */
    public function destroy(User $user) {
        return $user->delete();
    }

    /**
     * Attempts to login an user
     *
     * @param Request $request
     * @return void
     */
    public function login(Request $request) {
        $validated = $request->validate([
            'email' => ['required'],
            'password' => ['required'],
        ]);

        $loggedIn = Auth::attempt($validated);

        Validator::make(
            ['email' => $loggedIn],
            ['email' => 'accepted']
        )->validate();

        $token = $request->user()->createToken('API TOKEN')->plainTextToken;

        return new JsonResource(['token' => $token]);
    }

    /**
     * Attempts to log out an user
     *
     * @return void
     */
    public function logout() {
        return Auth::logout();
    }
}
