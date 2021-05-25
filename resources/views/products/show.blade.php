<x-app-layout>
  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
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
              {{ __('Product') . " #{$product->id}" }}
            </h1>
          </div>

          <div class="flex justify-between">
            <div class="flex-grow max-w-3xl">
              <div>
                <span class="font-bold text-lg underline">{{ __('Title') }}</span>
                <p>{{ $product->title }}</p>
              </div>

              <div class="mt-4">
                <span class="font-bold text-lg underline">{{ __('Description') }}</span>
                <p class="text-justify">{{ $product->description }}</p>
              </div>

              <div class="mt-4">
                <span class="font-bold text-lg underline">{{ __('Slug') }}</span>
                <p>{{ $product->slug }}</p>
              </div>

              <div class="mt-4">
                <span class="font-bold text-lg underline">{{ __('Status') }}</span>
                <p>{{ $product->status->alias }}</p>
              </div>

              <div class="mt-4">
                <span class="font-bold text-lg underline">{{ __('Price') }}</span>
                <p>${{ $product->price }}</p>
              </div>

              <div class="mt-4">
                <span class="font-bold text-lg underline">{{ __('Available count') }}</span>
                <p>{{ $product->available_count }}</p>
              </div>
            </div>

            <div class="w-72 ml-8 mr-4">
              <div class="border border-gray-200 rounded mb-7">
                <img src="{{ $product->thumbnail_url }}" alt="{{ "Product #{$product->id} thumbnail" }}">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
