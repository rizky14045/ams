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
      class="form-control select2"
      name="{{ $name }}"
      id="{{ $id }}"
      {{ $required? 'required' : '' }}>
      @if($emptyOption)
      <option value="">{{ $emptyOption }}</option>
      @endif
      @foreach($options as $option)
        @if(isset($option['options']))
          <optgroup label="{{ $option['label'] }}" {!! isset($option['attributes'])? html_attributes($option['attributes']) : "" !!}>
            @foreach($option['options'] as $opt)
            <option value="{{ $opt['value'] }}" {{ $value == $opt['value']? 'selected' : '' }} {!! isset($opt['attributes'])? html_attributes($opt['attributes']) : "" !!}>{{ $opt['label'] }}</option>
            @endforeach
          </optgroup>
        @else
          <option value="{{ $option['value'] }}" {{ $value == $option['value']? 'selected' : '' }} {!! isset($option['attributes'])? html_attributes($option['attributes']) : "" !!}>{{ $option['label'] }}</option>
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

@css('vendor/crudbooster/assets/adminlte/plugins/select2/select2.min.css')
@js('vendor/crudbooster/assets/adminlte/plugins/select2/select2.min.js')
@style('init-select2')
<style type="text/css">
  .select2-container--default .select2-selection--single {border-radius: 0px !important}
  .select2-container .select2-selection--single {height: 35px}
  .select2-container--default .select2-selection--multiple .select2-selection__choice {
    background-color: #3c8dbc !important;
    border-color: #367fa9 !important;
    color: #fff !important;
  }
  .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
    color: #fff !important;
  }
</style>
@endstyle
@script('init-select2')
<script>
  $('select.select2').select2({})
</script>
@endscript
