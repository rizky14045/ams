@extends('crudbooster::admin_template')

@include('asset-extracomptable.components.grid-per-lokasi')

@section('content')
  <div id="grid-container">
    <div class="form-group">
      <a href="{{ route('asset-extracomptable::page-summary', ['show_by' => 'lokasi']) }}" class="btn btn-default"><i class="fa fa-chevron-left"></i> Kembali</a>
      <a href="{{ route('asset-extracomptable::download-list-per-lokasi', ['format' => 'xlsx', 'id_ruang' => $id_ruang]) }}" class="btn btn-success pull-right"><i class="fa fa-file-excel-o"></i> Export to Excel</a>
    </div>
    <div class="box box-solid">
      <div class="box-body">
        <grid-extracomptable-per-lokasi
          url-fetch="{{ route('asset-extracomptable::json-get-list-per-lokasi') }}"
          :id-gedung="id_gedung"
          :lantai="lantai"
          :id-ruang="id_ruang"/>
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
      id_gedung: {{ $id_gedung }},
      lantai: '{{ $lantai }}',
      id_ruang: {{ $id_ruang }},
    }
  })
  </script>
@endscript
