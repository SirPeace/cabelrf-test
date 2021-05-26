<x-app-layout>
  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      @if (session('product.update_status') === 'success')
        <div class="bg-green-50 bg-opacity-50 text-green-700 p-4 mb-4 rounded border border-green-600">
          <p>{{ __('The product was successfully updated!') }}</p>
        </div>
      @endif

      <a href="{{ route('products.index') }}" class="inline-flex items-center mb-4 hover:underline">
        <svg class="inline-block h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
        <span>{{ __('Back to products list') }}</span>
      </a>

      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
          <div class="mb-4 border-gray-100 border-b-2 w-full flex justify-between items-center">
            <h1 class="text-2xl font-bold">
              {{ __('Edit product') }}
            </h1>

            <x-delete-product-button :product="$product" class="h-5 w-5 text-gray-500 hover:text-red-700">
              <svg viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                      d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                      clip-rule="evenodd" />
              </svg>
            </x-delete-product-button>
          </div>

          <form action="{{ route('products.update', compact('product')) }}"
                method="post"
                class="flex justify-between"
                enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="flex-grow min-w-max">
              <div>
                <x-label for="product_id" :value="'ID'" />
                <x-input id="product_id"
                         name="product_id"
                         type="text"
                         class="block mt-1 w-full bg-gray-100"
                         :value="$product->id" required disabled />
              </div>

              <div class="mt-4">
                <x-label for="product_title" :value="__('Title')" />
                <x-input id="product_title"
                         name="title"
                         type="text"
                         class="block mt-1 w-full"
                         :value="old('title') ? old('title') : $product->title"
                         required />
                @error('title') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
              </div>

              <div class="mt-4">
                <x-label for="product_description" :value="__('Description')" />
                <x-textarea id="product_description"
                            name="description"
                            type="text"
                            class="block mt-1 w-full"
                            :value="old('description') ? old('description') : $product->description"
                            required />
                @error('description') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
              </div>

              <div class="mt-4">
                <x-label for="product_slug" :value="__('Slug')" />
                <x-input id="product_slug"
                         type="text"
                         class="block mt-1 w-full"
                         name="slug"
                         :value="old('slug') ? old('slug') : $product->slug"
                         required />
                @error('slug') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
              </div>

              <div class="mt-4">
                <x-label for="product_status_id" :value="__('Status')" />
                <x-select id="product_status_id"
                          type="text"
                          class="block mt-1 w-full"
                          name="status_id"
                          :value="old('status_id') ? old('status_id') : $product->status_id">
                  @foreach ($product_statuses as $status)
                    <option value="{{ $status->id }}"
                            @if ($product->status->id == $status->id) selected @endif>
                      {{ __($status->alias) }}
                    </option>
                  @endforeach
                </x-select>
                @error('status_id') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
              </div>

              <div class="mt-4">
                <x-label for="product_price" :value="__('Price')" class="" />
                <div class="relative">
                  <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <span class="text-gray-500 sm:text-sm">
                      $
                    </span>
                  </div>
                  <x-input id="product_price"
                           type="text"
                           class="block mt-1 w-full pl-6"
                           name="price"
                           :value="old('price') ? old('price') : $product->price" required />
                </div>
                @error('price') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
              </div>

              <div class="mt-4">
                <x-label for="product_available_count" :value="__('Available count')" class="" />
                <x-input id="product_available_count"
                         type="number"
                         class="block mt-1 w-full"
                         name="available_count"
                         :value="old('available_count') ? old('available_count') : $product->available_count"
                         required />
                @error('available_count') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
              </div>

              <x-button type="submit" class="mt-4">{{ __('Update product') }}</x-button>
            </div>

            <div class="max-w-xs ml-8 mr-4">
              <div class="border border-gray-200 rounded mb-7">
                <img src="{{ $product->thumbnail_url }}" alt="{{ "Product #{$product->id} thumbnail" }}">
              </div>
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
