@extends('crudbooster::admin_template')

@include('asset-extracomptable.components.grid-by-jenis')
@include('asset-extracomptable.components.grid-by-lokasi')

@section('content')
  <div id="grid-container">
    <div class="form-inline">
      <div class="form-group">
        <div class="input-group">
          <div class="input-group-addon">Tampilkan Berdasarkan</div>
          <select v-model="showBy" class="form-control">
            <option value="jenis">Jenis</option>
            <option value="lokasi">Lokasi</option>
          </select>
        </div>
      </div>
      <div class="form-group pull-right">
        <a v-if="showBy == 'jenis'" href="{{ route('asset-extracomptable::download-summary-by-jenis', 'xlsx') }}" class="btn btn-export btn-success">
          <i class="fa fa-file-excel-o"></i> Export to Excel
        </a>
        <a v-if="showBy == 'lokasi'" href="{{ route('asset-extracomptable::download-summary-by-lokasi', 'xlsx') }}" class="btn btn-export btn-success">
          <i class="fa fa-file-excel-o"></i> Export to Excel
        </a>
      </div>
    </div>
    <br>
    <div class="box box-solid">
      <div class="box-body">
        <div v-show="showBy == 'jenis'">
          <grid-extracomptable-by-jenis url-fetch="{{ route('asset-extracomptable::json-get-summary-by-jenis') }}"/>
        </div>
        <div v-show="showBy == 'lokasi'">
          <grid-extracomptable-by-lokasi url-fetch="{{ route('asset-extracomptable::json-get-summary-by-lokasi') }}"/>
        </div>
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
      showBy: "{{ request('show_by') ?: 'jenis' }}"
    }
  })
  </script>
@endscript
