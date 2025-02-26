@extends('crudbooster::admin_template')

@include('asset-extracomptable.components.grid-report-by-lokasi')

@section('content')
  <div id="grid-container">
    <form class="form-inline" ref="formFilter">
      <div class="form-group">
        <div class="input-group">
          <div class="input-group-addon">Gedung</div>
          <select v-model="filter.id_gedung" class="form-control">
            <option value="">-- Semua --</option>
            <option v-for="opt in optionsGedung" :value="opt.id">@{{ opt.nama }}</option>
          </select>
        </div>
      </div>
      <div class="form-group">
        <div class="input-group">
          <div class="input-group-addon">Lantai</div>
          <select v-model="filter.lantai" class="form-control">
            <option value="">-- Semua --</option>
            <option v-for="opt in optionsLantai" :value="opt">@{{ opt }}</option>
          </select>
        </div>
      </div>
      <div class="form-group">
        <div class="input-group">
          <div class="input-group-addon">Ruang</div>
          <select v-model="filter.id_ruang" class="form-control">
            <option value="">-- Semua --</option>
            <option v-for="opt in optionsRuang" :value="opt.id">@{{ opt.nama_ruang }}</option>
          </select>
        </div>
      </div>
      <div class="form-group pull-right">
        <a :href="urlExportExcel" class="btn btn-export btn-success">
          <i class="fa fa-file-excel-o"></i> Export to Excel
        </a>
      </div>
    </form>
    <br>
    <div class="box box-solid">
      <div class="box-body">
        <grid-report-extracomptable-by-lokasi :filter="filter" url-fetch="{{ route('asset-extracomptable::json-get-report') }}"/>
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
      filter: {
        id_gedung: '',
        lantai: '',
        id_ruang: ''
      },
      optionsGedung: [],
      optionsLantai: [],
      optionsRuang: []
    },
    watch: {
      'filter.id_gedung': function () {
        this.filter.lantai = ''
        this.filter.id_ruang = ''
        this.optionsLantai = []
        this.optionsRuang = []
        this.fetchOptionsLantai();
      },
      'filter.lantai': function () {
        this.filter.id_ruang = ''
        this.optionsRuang = []
        this.fetchOptionsRuang();
      },
      'filter.id_ruang': function () {
      },
    },
    mounted: function() {
      this.fetchOptionsGedung();
    },
    computed: {
      urlExportExcel: function() {
        var url = "{{ route('asset-extracomptable::download-report', 'xlsx') }}";
        var filters = $.extend({}, this.filter);
        var params = [];
        for (var key in filters) {
          if (filters[key]) params.push(key+"="+filters[key]);
        }
        return url+"?"+params.join('&');
      }
    },
    methods: {
      fetchOptionsGedung: function() {
        var self = this;
        $.getJSON("{{ route('lokasi::json-options-gedung') }}")
        .done(function(res) {
          self.optionsGedung = res.list_gedung
        })
        .fail(function() {
          alert('Terjadi kesalahan saat mengambil opsi gedung');
        });
      },
      fetchOptionsLantai: function() {
        if (!this.filter.id_gedung) {
          return
        }

        var self = this;
        var id_gedung = this.filter.id_gedung;
        $.getJSON("{{ route('lokasi::json-options-lantai') }}", {id_gedung: id_gedung})
        .done(function(res) {
          self.optionsLantai = res.list_lantai
        })
        .fail(function() {
          alert('Terjadi kesalahan saat mengambil opsi lantai');
        });
      },
      fetchOptionsRuang: function() {
        if (!this.filter.id_gedung || !this.filter.lantai) {
          return
        }

        var self = this;
        var id_gedung = this.filter.id_gedung;
        var lantai = this.filter.lantai;
        $.getJSON("{{ route('lokasi::json-options-ruang') }}", {id_gedung: id_gedung, lantai: lantai})
        .done(function(res) {
          self.optionsRuang = res.list_ruang
        })
        .fail(function() {
          alert('Terjadi kesalahan saat mengambil opsi ruang');
        });
      }
    }
  })
  </script>
@endscript
