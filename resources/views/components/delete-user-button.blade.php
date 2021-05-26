@props(['user', 'class'])

<button class="{{ $class }}"
        type="button"
        title="{{ __('Delete') }}"
        onclick='
            // TODO Bad solution, try to create different form
            if (confirm("{{ __("Delete product #{$product->id}?") }}")) {
                let checkbox = this.closest("tr").querySelector(`input[type="checkbox"]`);
                checkbox.checked = true;

                this.closest("form").submit();
            }
        '>
  {{ $slot }}
</button>
