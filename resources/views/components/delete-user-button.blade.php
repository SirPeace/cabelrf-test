@props(['user', 'class'])

<form
  action="{{ route('users.destroy', ['user' => $user]) }}"
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
      if (confirm("{{ __("Delete user #{$user->id}?") }}")) {
        this.closest("form").submit()
      }'
  >
    {{ $slot }}
  </button>
</form>
