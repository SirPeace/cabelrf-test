@props(['product', 'class'])

<form
  action="{{ route('products.destroy', ['product' => $product]) }}"
  method="POST"
  class="inline-block"
>
  @csrf
  @method('DELETE')
  <button
    class="{{ $class }}"
    type="button"
    title="{{ __('Delete') }}"
    onclick='
      if (confirm("{{ __("Delete product #{$product->id}?") }}")) {
        this.closest("form").submit()
      }'
  >
    {{ $slot }}
  </button>
</form>
