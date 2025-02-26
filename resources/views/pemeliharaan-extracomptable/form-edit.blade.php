@extends('crudbooster::admin_template')

@section('content')
  @component('components.panel-form')
    @slot('title')
      <i class="fa fa-edit"></i> Edit Pemeliharaan Extra Comptable
    @endslot

    <form action="{{ route('pemeliharaan-extracomptable::post-edit', [$pemeliharaan->id]) }}" method="POST" enctype="multipart/form-data" class="form-horizontal">

      @include('partials.fields.text', [
        'name' => 'kd_pemeliharaan',
        'value' => $pemeliharaan->kd_pemeliharaan,
        'required' => true,
        'readonly' => true,
        'label' => 'Kode Pemeliharaan',
      ])

      @include('partials.fields.select2', [
        'name' => 'nik_karyawan',
        'value' => $pemeliharaan->nik_karyawan,
        'required' => true,
        'label' => 'Penanggung Jawab',
        'options' => $options_karyawan,
        'emptyOption' => '-- Pilih Karyawan --'
      ])

      @include('partials.fields.select2', [
        'name' => 'id_jenis_pemeliharaan',
        'value' => $pemeliharaan->id_jenis_pemeliharaan,
        'required' => true,
        'label' => 'Jenis Pemeliharaan',
        'options' => $options_id_jenis_pemeliharaan,
        'emptyOption' => '-- Jenis Pemeliharaan --'
      ])

      <hr>

      @include('partials.fields.date', [
        'name' => 'tgl_mulai',
        'value' => $pemeliharaan->tgl_mulai,
        'required' => true,
        'label' => 'Tanggal Mulai',
        'value' => date('Y-m-d')
      ])

      @include('partials.fields.date', [
        'name' => 'tgl_selesai',
        'value' => $pemeliharaan->tgl_selesai,
        'required' => true,
        'label' => 'Tanggal Akhir',
        'value' => date('Y-m-d')
      ])

      <hr>

      @component('partials.fields.wrapper', ['name' => '', 'label' => ''])
      <h4><i class="fa fa-map-marker"></i> Lokasi</h4>
      @endcomponent

      @include('partials.fields.select2', [
        'name' => 'id_gedung',
        'value' => $pemeliharaan->id_gedung,
        'required' => true,
        'label' => 'Gedung',
        'options' => $options_gedung,
        'emptyOption' => '-- Pilih Gedung --'
      ])

      @include('partials.fields.select2', [
        'name' => 'lantai',
        'value' => $pemeliharaan->lantai,
        'required' => true,
        'label' => 'Lantai',
        'options' => isset($options_lantai) ? $options_lantai : [],
        'emptyOption' => '-- Pilih Lantai --'
      ])

      @include('partials.fields.select2', [
        'name' => 'id_ruang',
        'value' => $pemeliharaan->id_ruang,
        'required' => true,
        'label' => 'Ruang',
        'options' => isset($options_ruang) ? $options_ruang : [],
        'emptyOption' => '-- Pilih Ruang --'
      ])

      <hr>

      @include('partials.fields.textarea', [
        'name' => 'note',
        'value' => $pemeliharaan->note,
        'required' => true,
        'label' => 'Catatan',
      ])

      <hr>

      @component('partials.fields.wrapper', ['name' => 'list_items', 'label' => 'Daftar Barang'])
      <div id="table-list-items">

        <div class="form-inline">
          <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-barcode"></i></span>
            <input ref="searchKodeAsset" v-on:keydown.enter="submitAddItem($event)" type="text" v-model="kd_asset" class="form-control" placeholder="Kode Asset" />
            <div class="input-group-btn">
              <button v-on:click="submitAddItem($event)" class="btn btn-success" :disabled="!kd_asset.length"><i class="fa fa-plus"></i></button>
              <button v-on:click="enableBarcodeScanner($event)" class="btn" :disabled="barcode_enabled" :class="{'btn-danger': barcode_enabled, 'btn-default': !barcode_enabled}"><i class="fa fa-camera"></i></button>
            </div>
          </div>
        </div>
        <div class="viewport-wrapper" :class="{'active': barcode_enabled}">
          <div id="interactive" class="viewport"></div>
          <a style="margin-top: 5px;" href="#" v-on:click="disableBarcodeScanner" class="btn btn-block btn-xs btn-danger">
            <strong><i class="fa fa-times"></i> Tutup</strong>
          </a>
        </div>

        <table style="margin-top: 10px" class="table table-striped table-hover table-bordered">
          <thead>
            <tr>
              <th>No.</th>
              <th>Kode Asset</th>
              <th>Nama Asset</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody class="vhide hidden">
            <tr v-if="!list_items.length">
              <td colspan="6">
                <div class="well well-sm text-center" style="margin:0px">
                  Daftar Barang Masih Kosong.
                </div>
              </td>
            </tr>
            <tr v-for="item, index in list_items">
              <td>@{{ index + 1 }}</td>
              <td>@{{ item.kd_asset }}</td>
              <td>@{{ item.nama_asset }}</td>
              <td>
                <input type="hidden" :name="'items['+index+'][id_asset]'" :value="item.id_asset"/>
                <button v-on:click="deleteItem($event, index)" class="btn btn-danger">Delete</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      @endcomponent

      <hr>

      <div class="form-group">
        <div class="col-md-push-2 col-md-10">
          <a href="{{ route('AdminPemeliharaanExtracomptableControllerGetIndex') }}" class="btn btn-default"><i class="fa fa-chevron-left"></i> Batal</a>
          &nbsp;
          <button name="action" value="save" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
        </div>
      </div>
      {!! csrf_field() !!}
    </form>
  @endcomponent
@endsection

@js('vendor/instascan/instascan.min.js')
@js('assets/js/barcode.js')

@section('scripts')
  @parent
  <script>
  var $id_gedung = $("#input-id_gedung");
  var $lantai = $("#input-lantai");
  var $id_ruang = $("#input-id_ruang");

  function resetSelect2(el) {
    $(el).select2('destroy').select2({width: '100%'});
  }

  function setSelectOptions(el, options, value) {
    $(el).find('option').not('[value=""]').remove();
    options.forEach(function(opt) {
      $(el).append('<option value="'+opt.value+'">'+opt.label+'</option>');
    });
    resetSelect2(el);
  }

  function updateOptionsLantai() {
    var id_gedung = $id_gedung.val();
    if (!id_gedung) {
      return setSelectOptions($lantai, []);
    }

    var url = "{{ route('lokasi::json-options-lantai') }}";
    $.getJSON(url, {id_gedung: id_gedung}).done(function(res) {
      var list_lantai = res.list_lantai;
      setSelectOptions($lantai, list_lantai.map(function(lantai) {
        return {
          label: lantai,
          value: lantai
        };
      }));
      updateOptionsRuang();
    });
  }

  function updateOptionsRuang() {
    var id_gedung = $id_gedung.val();
    var lantai = $lantai.val();
    if (!id_gedung || !lantai) {
      return setSelectOptions($id_ruang, []);
    }

    var url = "{{ route('lokasi::json-options-ruang') }}";
    $.getJSON(url, {id_gedung: id_gedung, lantai: lantai}).done(function(res) {
      var list_ruang = res.list_ruang;
      setSelectOptions($id_ruang, list_ruang.map(function(ruang) {
        return {
          label: ruang.nama_ruang,
          value: ruang.id
        };
      }));
    });
  }

  $(function() {
    $id_gedung.change(function() {
      updateOptionsLantai();
    });
    $lantai.change(function() {
      updateOptionsRuang();
    });

    var form = new Vue({
      el: '#table-list-items',
      data: {
        barcode_enabled: false,
        list_items: {!! json_encode($list_items) !!},
        kd_asset: '',
      },
      mounted: function() {
        $(".vhide.hidden").removeClass('hidden');
      },
      methods: {
        deleteItem: function(e, index) {
          e.preventDefault();
          this.list_items.splice(index, 1);
        },
        submitAddItem: function(e) {
          e.preventDefault();
          var self = this;
          var kd_asset = this.kd_asset.trim();
          var url = "{{ route('asset-extracomptable::json-get-detail-asset', ['']) }}";
          var exists = self.list_items.find(function(item) {
            return item.kd_asset == kd_asset;
          });

          if (exists) {
            this.kd_asset = '';
            $(self.$refs.searchKodeAsset).focus();
            return;
          }

          if (!kd_asset) {
            return alert('Kode asset tidak boleh kosong');
          }

          self.fetchingItem = true;
          $.getJSON(url+'/'+kd_asset)
          .done(function(res) {
            if (res.asset) {
              self.list_items.push(res.asset);
            } else {
              alert('Terjadi kesalahan saat mengambil data asset.');
            }
          })
          .fail(function(xhr) {
            if (xhr.status == 404) {
              alert('Asset dengan kode "'+kd_asset+'" tidak ditemukan.');
            } else if(xhr.status == 403) {
              alert('Anda tidak dapat menambahkan asset ini.');
            } else {
              alert('Terjadi kesalahan saat mengambil data asset.');
            }
          })
          .always(function() {
            self.fetchingItem = false;
            self.kd_asset = '';
            $(self.$refs.searchKodeAsset).focus();
          });
        },
        enableBarcodeScanner: function(e) {
          e.preventDefault()
          var self = this;
          barcode.scan({
            onStarted: function() {
              self.barcode_enabled = true;
            },
            onDetected: function(code) {

              self.kd_asset = code;
              self.submitAddItem();
            }
          });
        },
        disableBarcodeScanner: function(e) {
          barcode.stop();
          this.barcode_enabled = false;
        },
      }
    })
  });
  </script>
@endsection
