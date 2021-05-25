<x-app-layout>
  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
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
              {{ __('Add new user') }}
            </h1>
          </div>

          <form action="{{ route('users.store') }}"
                method="post"
                class="flex justify-between"
                enctype="multipart/form-data">
            @csrf

            <div class="flex-grow">
              <div>
                <x-label for="user_title" :value="__('Title')" required />
                <x-input id="user_title"
                         name="title"
                         type="text"
                         class="block mt-1 w-full"
                         :value="old('title') ? old('title') : null"
                         required />
                @error('title') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
              </div>

              <div class="mt-4">
                <x-label for="user_slug" :value="__('Slug') . ' (generates from title by default)'" />
                <x-input id="user_slug"
                         type="text"
                         class="block mt-1 w-full"
                         name="slug"
                         :value="old('slug') ? old('slug') : null" />
                @error('slug') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
              </div>

              <div class="mt-4">
                <x-label for="user_description" :value="__('Description')" required />
                <x-textarea id="user_description"
                            name="description"
                            type="text"
                            class="block mt-1 w-full"
                            :value="old('description') ? old('description') : null"
                            required />
                @error('description') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
              </div>

              <div class="mt-4">
                <x-label for="user_status_id" :value="__('Status')" required />
                <x-select id="user_status_id"
                          type="text"
                          class="block mt-1 w-full"
                          name="status_id"
                          :value="old('status_id') ? old('status_id') : null">
                  @foreach ($user_statuses as $status)
                    <option value="{{ $status->id }}">{{ $status->alias }}</option>
                  @endforeach
                </x-select>
                @error('status_id') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
              </div>

              <div class="mt-4">
                <x-label for="user_price" :value="__('Price')" required />
                <div class="relative">
                  <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <span class="text-gray-500 sm:text-sm">
                      $
                    </span>
                  </div>
                  <x-input id="user_price"
                           type="text"
                           class="block mt-1 w-full pl-6"
                           name="price"
                           :value="old('price') ? old('price') : null"
                           required />
                </div>
                @error('price') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
              </div>

              <div class="mt-4">
                <x-label for="user_available_count" :value="__('Available count')" required />
                <x-input id="user_available_count"
                         type="number"
                         class="block mt-1 w-full"
                         name="available_count"
                         :value="old('available_count') ? old('available_count') : null"
                         required />
                @error('available_count') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
              </div>

              <x-button type="submit" class="mt-4">Add user</x-button>
            </div>

            <div class="w-72 ml-8 mr-4">
              <div>
                <x-label for="file-uploader" :value="__('Upload thumbnail')" />
                <x-file-uploader id="file-uploader" name="thumbnail" />
                @error('thumbnail') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
