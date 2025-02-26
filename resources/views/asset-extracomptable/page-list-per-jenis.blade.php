@extends('crudbooster::admin_template')

@include('asset-extracomptable.components.grid-per-jenis')

@section('content')
  <div id="grid-container">
    <div class="form-group">
      <a href="{{ route('asset-extracomptable::page-summary', ['show_by' => 'jenis']) }}" class="btn btn-default"><i class="fa fa-chevron-left"></i> Kembali</a>
      <a href="{{ route('asset-extracomptable::download-list-per-jenis', ['format' => 'xlsx', 'id_subjenis' => $id_subjenis]) }}" class="btn btn-success pull-right"><i class="fa fa-file-excel-o"></i> Export to Excel</a>
    </div>
    <div class="box box-solid">
      <div class="box-body">
        <grid-extracomptable-per-jenis
          url-fetch="{{ route('asset-extracomptable::json-get-list-per-jenis') }}"
          :id-jenis="id_jenis"
          :id-subjenis="id_subjenis"/>
      </div>
    </div>
  </div>
@endsection

@script
  @parent
  <script>
  var app = new Vue({
    el: '#grid-container',
    data: {
      id_jenis: {{ $id_jenis }},
      id_subjenis: {{ $id_subjenis }},
    }
  })
  </script>
@endscript
