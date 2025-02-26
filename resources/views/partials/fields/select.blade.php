@php
$id = "input-{$name}";
$label = isset($label)? $label : ucwords(snake_case(camel_case($name), ' '));
$required = isset($required)? (bool) $required : false;
$emptyOption = isset($emptyOption)? $emptyOption : 'Pick '.$label;
$value = isset($value)? $value : '';
@endphp

<div class="form-group {{ $errors->has($name)? 'has-error' : '' }}">
  <label class="control-label col-lg-2 col-md-3 col-sm-4" for="{{ $id }}">
    {{ $label }}
    @if($required)
    <strong class="text-danger">*</strong>
    @endif
  </label>
  <div class="col-lg-10 col-md-9 col-sm-8">
    <select
      class="form-control"
      name="{{ $name }}"
      id="{{ $id }}"
      {{ $required? 'required' : '' }}>
      @if($emptyOption)
      <option value="">{{ $emptyOption }}</option>
      @endif
      @foreach($options as $option)
        @if(isset($option['options']))
          <optgroup label="{{ $option['label'] }}">
            @foreach($option['options'] as $opt)
            <option value="{{ $opt['value'] }}" {{ $value == $opt['value']? 'selected' : '' }}>{{ $opt['label'] }}</option>
            @endforeach
          </optgroup>
        @else
          <option value="{{ $option['value'] }}" {{ $value == $option['value']? 'selected' : '' }}>{{ $option['label'] }}</option>
        @endif
      @endforeach
    </select>
    @if($errors->has($name))
    <div class="help-block">{{ $errors->first($name) }}</div>
    @endif
    @if(isset($help))
    <div class="help-block">{{ $help }}</div>
    @endif
  </div>
</div>
