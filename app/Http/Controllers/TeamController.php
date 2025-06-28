<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTeamRequest;
use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teams = Team::with('users')->get();

        return view('teams.index', compact('teams'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('teams.create', [
            'users' => User::pluck('name', 'id')->toArray()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTeamRequest $request)
    {
        DB::transaction(function() use ($request) {
            $team = Team::create($request->validated());

            $playersArray = [];
            foreach($request->input('players') as $player) {
                $playersArray[$player['id']] = ['position' => $player['position']];
            }
            $team->users()->attach($playersArray);
//
//            $team->users()->attach(
//                collect($request->input('players'))
//                    ->mapWithKeys(function ($item) {
//                        return [$item['id'] => ['position' => $item['position']]];
//                    })
//            );
        });

        return redirect()->route('teams.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Team $team)
    {
        $team->load(['users']);

        return view('teams.edit', [
            'team' => $team,
            'users' => User::pluck('name', 'id')->toArray(),
            'teamUsers' => $team->users->map(function ($user) {
                return [
                    'id' => $user->id,
                    'position' => $user->pivot->position
                ];
            })
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreTeamRequest $request, Team $team)
    {
        DB::transaction(function() use ($team, $request) {
            $team->update($request->validated());

            $playersArray = [];
            foreach($request->input('players') as $player) {
                $playersArray[$player['id']] = ['position' => $player['position']];
            }
            $team->users()->sync($playersArray);
//            $team->users()->sync(
//                collect($request->input('players'))
//                    ->mapWithKeys(function ($item) {
//                        return [$item['id'] => ['position' => $item['position']]];
//                    })
//            );
        });

        return redirect()->route('teams.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Team $team)
    {
        $team->delete();

        return redirect()->route('teams.index');
    }
}
