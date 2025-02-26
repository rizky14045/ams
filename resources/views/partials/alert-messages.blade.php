@foreach(['info', 'danger', 'warning', 'success'] as $type)
  @if($message = session('alert-'.$type))
  <div class="alert alert-{{ $type }}">
    <b class="close" data-dismiss="alert">&times;</b>
    {!! $message !!}
  </div>
  @endif
@endforeach
