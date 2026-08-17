<div>
    @foreach($players as $i => $user)
        <div wire:key="team-player-{{ $i }}" class="mb-4 grid grid-cols-3 gap-4">
            <div>
                <label class="text-xl text-gray-600" for="players-{{ $i }}-id">{{ __('Player') }}<span class="text-red-500">*</span></label>
                <select name="players[{{ $i }}][id]" id="players-{{ $i }}-id" wire:model.live="players.{{ $i }}.id"
                        class="border-2 border-gray-300 p-2 w-full">
                    <option value="">{{ __('Select Player') }}</option>
                    @foreach($users as $id => $name)
                        <option value="{{ $id }}"
                            @disabled(
                                collect($players)
                                    ->except($i)
                                    ->pluck('id')
                                    ->contains((string) $id)
                            )
                        >{{ $name }}</option>
                    @endforeach
                </select>
                @error("players.{$i}.id")
                <div class="text-red-500 mt-2 text-sm">
                    {{ __($message) }}
                </div>
                @enderror
            </div>
            <div>
                <label class="text-xl text-gray-600" for="players-{{ $i }}-position">{{ __('Position') }}<span
                            class="text-red-500">*</span></label>
                <select name="players[{{ $i }}][position]" id="players-{{ $i }}-position"
                        wire:model.live="players.{{ $i }}.position"
                        class="border-2 border-gray-300 p-2 w-full">
                    <option value="">{{ __('Select Position') }}</option>
                    @foreach($positions as $id => $name)
                        <option value="{{ $id }}"
                            @disabled(
                                collect($players)
                                    ->except($i)
                                    ->pluck('position')
                                    ->contains($id)
                            )
                        >{{ __($name) }}</option>
                    @endforeach
                </select>
                @error("players.{$i}.position")
                <div class="text-red-500 mt-2 text-sm">
                    {{ __($message) }}
                </div>
                @enderror
            </div>
            <div>
                <button type="button" wire:click="removeUser({{ $i }})"
                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded mt-8">
                    {{ __('Remove') }}
                </button>
            </div>
        </div>
    @endforeach

    <div class="mb-4">
        @error('players')
        <div class="text-red-500 mt-2 text-sm">
            {{ $message }}
        </div>
        @enderror
    </div>

    <button type="button" wire:click="addUser"
            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4">
        {{ __('Add Player') }}
    </button>
</div>
