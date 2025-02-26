@extends('crudbooster::admin_template')

@section('content')
  @include('partials.alert-messages')

  @component('components.panel-form')
    @slot('title')
      <i class="fa fa-plus"></i> Tambah User Group
    @endslot
    <form action="{{ route('user-group::post-edit', [$user_group->getKey()]) }}" method="POST" class="form-horizontal">
      @include('partials.fields.text', [
        'name' => 'name',
        'value' => $user_group->name,
        'required' => true,
        'label' => 'Nama Group',
      ])

      @component('partials.fields.wrapper', [
        'name' => 'akses_ruang',
      ])
        <select multiple name="list_akses_ruang[]" id="list_akses_ruang" class="multi-select form-control">
          @foreach($list_gedung as $gedung)
          <optgroup label="{{ $gedung->nama }}">
            @foreach($gedung->list_ruang()->orderBy('lantai', 'asc')->get() as $ruang)
            <option {{ in_array($ruang->getKey(), $user_group->getListAksesRuang()) ? 'selected' : '' }} value="{{ $ruang->getKey() }}">
              [Lt.{{ $ruang->lantai }}] {{ $ruang->nama_ruang }}
            </option>
            @endforeach
          </optgroup>
          @endforeach
        </select>
      @endcomponent

      <hr>

      <div class="form-group">
        <div class="col-md-push-2 col-md-10">
          <a href="{{ route('user-group::index') }}" class="btn btn-default"><i class="fa fa-chevron-left"></i> Batal</a>
          &nbsp;
          <button name="action" value="save-and-new" class="btn btn-success"><i class="fa fa-plus"></i> Simpan dan Buat Baru</button>
          &nbsp;
          <button name="action" value="save" class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
        </div>
      </div>
      {!! csrf_field() !!}
    </form>
  @endcomponent
@endsection

@css('vendor/multi-select/css/multi-select.css')
@js('vendor/multi-select/js/jquery.multi-select.js')

@section('scripts')
  @parent
  <script>
    $(function() {
      $("#list_akses_ruang").multiSelect({
        selectableOptgroup: true,
        selectableHeader: "<h4 class='text-muted'>Daftar Ruang</h4>",
        selectionHeader: "<h4 class='text-muted'>Dipilih</h4>",
      })
    });
  </script>
@endsection
