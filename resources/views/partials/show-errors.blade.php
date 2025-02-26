@if($errors->count())
<div class="alert alert-danger">
  <ul>
    {!! implode("", $errors->all("<li>:message</li>")) !!}
  </ul>
</div>
@endif
