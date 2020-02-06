<div class="form-group">
  <label for="_{{ $key }}">{{ $label }}</label>
  <select name="{{ $key }}" id="_{{ $key }}" class="form-control custom-select">
    @foreach ($options as $value => $label)
    <option value="{{ $value }}" {{ $selected === $value ? 'selected' : '' }}>{{ $label }}</option>
    @endforeach
  </select>
  @if (isset($help))
  <small class="form-text text-muted">{!! $help !!}</small>
  @endif
</div>
