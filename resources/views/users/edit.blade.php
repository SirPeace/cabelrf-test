<x-app-layout>
  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      @if (session('user.update_status') === 'success')
        <div class="bg-green-50 bg-opacity-50 text-green-700 p-4 mb-4 rounded border border-green-600">
          <p>{{ __('The user was successfully updated!') }}</p>
        </div>
      @endif

      <a href="{{ route('users.index') }}" class="inline-flex items-center mb-4 hover:underline">
        <svg class="inline-block h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
        <span>{{ __('Back to users list') }}</span>
      </a>

      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
          <div class="mb-4 border-gray-100 border-b-2 w-full flex justify-between items-center">
            <h1 class="text-2xl font-bold">
              {{ __('Edit user') }}
            </h1>

            <x-delete-user-button :user="$user" class="h-5 w-5 text-gray-500 hover:text-red-700">
              <svg viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                      d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                      clip-rule="evenodd" />
              </svg>
            </x-delete-user-button>
          </div>

          <form action="{{ route('users.update', compact('user')) }}"
                method="post"
                class="flex justify-between"
                enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="flex-grow min-w-max">
              <div>
                <x-label for="user_id" :value="'ID'" />
                <x-input id="user_id"
                         name="user_id"
                         type="text"
                         class="block mt-1 w-full bg-gray-100"
                         :value="$user->id" required disabled />
              </div>

              <div class="mt-4">
                <x-label for="user_name" :value="__('Name')" />
                <x-input id="user_name"
                         name="name"
                         type="text"
                         class="block mt-1 w-full"
                         :value="old('name') ? old('name') : $user->name"
                         required />
                @error('name') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
              </div>

              <div class="mt-4">
                <x-label for="user_age" :value="__('Age')" />
                <x-input id="user_age"
                           type="text"
                           class="block mt-1 w-full"
                           name="age"
                           :value="old('age') ? old('age') : $user->age" required />
                @error('age') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
              </div>

              <div class="mt-4">
                <x-label for="user_sex" :value="__('Sex')" />
                <x-select id="user_sex"
                          type="text"
                          class="block mt-1 w-full"
                          name="sex"
                          :value="old('sex') ? old('sex') : $user->sex">
                  @foreach ([ ['F', 'Female'], ['M', 'Male'] ] as $sex)
                    <option value="{{ $sex[0] }}"
                            @if ($user->sex == $sex[0]) selected @endif>
                      {{ $sex[1] }}
                    </option>
                  @endforeach
                </x-select>
                @error('sex') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
              </div>

              <div class="mt-4">
                <x-label for="user_role_id" :value="__('Role')" />
                <x-select id="user_role_id"
                          type="text"
                          class="block mt-1 w-full"
                          name="role_id"
                          :value="old('role_id') ? old('role_id') : $user->role_id">
                  @foreach ($user_roles as $role)
                    <option value="{{ $role->id }}"
                            @if ($user->role->id == $role->id) selected @endif>
                      {{ $role->alias }}
                    </option>
                  @endforeach
                </x-select>
                @error('role_id') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
              </div>

              <x-button type="submit" class="mt-4">Update user</x-button>
            </div>

            <div class="max-w-xs ml-8 mr-4">
              <div class="border border-gray-200 rounded mb-7">
                <img src="{{ $user->avatar_url }}" alt="{{ "User #{$user->id} avatar" }}">
              </div>
              <div>
                <x-label for="file-uploader" :value="__('Upload avatar')" />
                <x-file-uploader id="file-uploader" name="avatar" />
                @error('avatar') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
