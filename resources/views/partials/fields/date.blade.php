@php
$id = "input-{$name}";
$label = isset($label)? $label : ucwords(snake_case(camel_case($name), ' '));
$required = isset($required)? (bool) $required : false;
@endphp

<div class="form-group form-date {{ $errors->has($name)? 'has-error' : '' }}">
  <label class="control-label col-lg-2 col-md-3 col-sm-4" for="{{ $id }}">
    {{ $label }}
    @if($required)
    <strong class="text-danger">*</strong>
    @endif
  </label>
  <div class="col-lg-10 col-md-9 col-sm-8">
    <div class="input-group">
      {!! $groupLeft or '' !!}
      <span class="input-group-addon">
        <i class="fa fa-calendar"></i>
      </span>
      <input
        type="text"
        class="form-control date notfocus"
        value="{{ $value or '' }}"
        name="{{ $name }}"
        id="{{ $id }}"
        {{ $required? 'required' : '' }}
      />
      {!! $groupRight or '' !!}
    </div>
    @if($errors->has($name))
    <div class="help-block">{{ $errors->first($name) }}</div>
    @endif
    @if(isset($help))
    <div class="help-block">{{ $help }}</div>
    @endif
  </div>
</div>

@css('vendor/crudbooster/assets/adminlte/plugins/datepicker/datepicker3.css')
@js('vendor/crudbooster/assets/adminlte/plugins/datepicker/bootstrap-datepicker.js')
@script('init-datepicker')
<script>
$('input.date').datepicker({
  format: 'yyyy-mm-dd',
});
</script>
@endscript
