@php
$id = "input-{$name}";
$label = isset($label)? $label : ucwords(snake_case(camel_case($name), ' '));
$required = isset($required)? (bool) $required : false;
$empty_option = isset($empty_option)? $empty_option : 'Pick '.$label;
$value = isset($value)? $value : '';
@endphp

<div class="form-group form-icheck-checkbox {{ $errors->has($name)? 'has-error' : '' }}">
  <label class="control-label col-lg-2 col-md-3 col-sm-4" for="{{ $id }}">
    {{ $label }}
    @if($required)
    <strong class="text-danger">*</strong>
    @endif
  </label>
  <div class="col-lg-10 col-md-9 col-sm-8">
    @foreach($options as $option)
      <label class="input-checkbox">
        <input id="cb-{{ $id }}-{{ $option['value'] }}" name="{{ $name }}" type='checkbox' value="{{ $option['value'] }}" {{ $value == $option['value']? 'checked' : '' }}>
        <span>{{ $option['label'] }}</span>
      </label>
      <br>
    @endforeach
    @if($errors->has($name))
    <div class="help-block">{{ $errors->first($name) }}</div>
    @endif
    @if(isset($help))
    <div class="help-block">{{ $help }}</div>
    @endif
  </div>
</div>

@css('vendor/admin-lte/plugins/iCheck/all.css')
@js('vendor/admin-lte/plugins/iCheck/icheck.min.js')
@script('init-icheck-checkbox')
<script>
  $(function() {
    $('.form-icheck-checkbox input[type="checkbox"]').iCheck({
      checkboxClass: 'icheckbox_minimal-blue'
    });
  });
</script>
@endscript
