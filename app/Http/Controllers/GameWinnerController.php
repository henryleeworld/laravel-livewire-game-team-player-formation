<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGameWinnerRequest;
use App\Models\Game;
use Illuminate\Http\Request;

class GameWinnerController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Game $game)
    {
        $game->load(['users']);

        $places = [];

        for ($i = 1; $i <= $game->users->count(); $i++) {
            $places[$i] = 'Place ' . $i;
        }

        return view('games.winners', compact('game', 'places'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreGameWinnerRequest $request, Game $game)
    {
        $game->load(['users']);

        foreach ($game->users as $user) {
            $game->users()->updateExistingPivot($user->id, [
                'place' => $request->input('players.' . $user->id)
            ]);
        }

        return redirect()->route('games.index');
    }
}
