@extends('crudbooster::admin_template')

@section('content')
  @component('components.panel-form')
    @slot('title')
      <i class="fa fa-file-text"></i>
      Detail Asset
      <strong>
        {{ $asset->nama_asset }}
      </strong>
    @endslot
    <div class="row">
      <div class="col-md-8">
        <div class="table-responsive">
          <table class="table table-hover table-bordered">
            <tr>
              <td width="200">Nama Asset</td>
              <td><strong>{{ $asset->nama_asset }}</strong></td>
            </tr>
            <tr>
              <td width="200">Kode Asset</td>
              <td><strong>{{ $asset->kd_asset }}</strong></td>
            </tr>
            <tr>
              <td width="200">Kategori</td>
              <td><strong>{{ $asset->kategori ? $asset->kategori->nama_kategori : '-' }}</strong></td>
            </tr>
            <tr>
              <td width="200">Lokasi</td>
              <td><strong>{!! $asset->getLocation() !!}</strong></td>
            </tr>
            <tr>
              <td width="200">Tgl. Masuk</td>
              <td><strong>{!! date('d/m/Y', strtotime($asset->tgl_masuk)) !!}</strong></td>
            </tr>
          </table>
        </div>
      </div>
      <div class="col-md-4">
        <img style="width:100%; height:auto;" src="{{ $asset->urlGambar() }}" alt="" class="thumbnail">
      </div>
    </div>
  @endcomponent
  @component('components.panel-form')
    @slot('title')
      <i class="fa fa-history"></i>
      <strong>Log Perubahan</strong>
    @endslot
    <div class="table-responsive">
      <table id="histories" class="table table-bordered table-hover table-striped">
        <thead>
          <tr>
            <th>Waktu</th>
            <th>Foto</th>
            <th>Pengguna</th>
            <th>Nama Asset</th>
            <th>Kategori</th>
            <th>Lokasi</th>
            <th>Jumlah</th>
            <th>Jumlah Minimum</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="log in histories">
            <td width="120">@{{ date(log.time, 'DD-MM-YYYY, HH:mm') }}</td>
            <td width="100">
              <a class="link-image" :href="log.asset ? log.asset.url_image : '#'" target="_blank">
                <img :src="log.asset ? log.asset.url_image : '#'" style="width: 100px;"/>
              </a>
            </td>
            <td>@{{ log.user ? log.user.name : '- tidak diketahui -' }}</td>
            <td>@{{ log.asset ? log.asset.nama_asset : '-' }}</td>
            <td>@{{ log.asset && log.asset.kategori ? log.asset.kategori.nama_kategori : '-' }}</td>
            <td>
              @{{ log.asset && log.asset.ruang ? log.asset.ruang.nama_ruang : '-' }}
              /
              @{{ log.asset ? log.asset.lantai : '-' }}
              /
              @{{ log.asset && log.asset.gedung ? log.asset.gedung.nama : '-' }}
            </td>
            <td>@{{ log.asset ? log.asset.jumlah : '-' }}</td>
            <td>@{{ log.asset ? log.asset.jumlah_minimum : '-' }}</td>
          </tr>
          <tr v-if="!histories.length">
            <td colspan="10">
              <div class="text-center" style="padding: 10px">
                - Tidak ada log perubahan -
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  @endcomponent
@endsection

@section('styles')
  @parent
  <style>
    .link-image:hover {
      cursor: zoom-in: ;
    }
  </style>
@endsection
@section('scripts')
  @parent
  <script>
    var urlHistories = "{{ route('asset-inventory::json-get-histories', $asset->getKey()) }}";
    var history = new Vue({
      el: '#histories',
      data: {
        histories: []
      },
      mounted: function () {
        this.fetchHistories()
      },
      methods: {
        fetchHistories: function () {
          var self = this;
          $.getJSON(urlHistories, {
            type: ['create', 'update']
          })
          .done(function(res) {
            self.histories = res.data
          })
          .fail(function() {
            alert('Terjadi kesalahan saat mengambil data log perubahan.')
          })
        },
        date: function(date, format) {
          return moment(date).format(format)
        }
      }
    });
  </script>
@endsection
