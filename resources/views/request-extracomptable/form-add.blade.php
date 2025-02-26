@extends('crudbooster::admin_template')

@section('content')
  @component('components.panel-form')
    @slot('title')
      <i class="fa fa-plus"></i> Add Request Extra Comptable
    @endslot

    <form action="{{ route('request-extracomptable::post-create') }}" method="POST" enctype="multipart/form-data" class="form-horizontal">

      @include('partials.fields.text', [
        'name' => 'kd_request',
        'value' => $kd_request,
        'required' => true,
        'readonly' => true,
        'label' => 'Kode Request',
      ])

      <hr>

      @include('partials.fields.select2', [
        'name' => 'id_gedung',
        'value' => prev_input('id_gedung'),
        'required' => true,
        'label' => 'Gedung',
        'options' => $options_gedung,
        'emptyOption' => '-- Pilih Gedung --'
      ])

      @include('partials.fields.select2', [
        'name' => 'lantai',
        'value' => prev_input('lantai'),
        'required' => true,
        'label' => 'Lantai',
        'options' => isset($options_lantai) ? $options_lantai : [],
        'emptyOption' => '-- Pilih Lantai --'
      ])

      @include('partials.fields.select2', [
        'name' => 'id_ruang',
        'value' => prev_input('id_ruang'),
        'required' => true,
        'label' => 'Ruang',
        'options' => isset($options_ruang) ? $options_ruang : [],
        'emptyOption' => '-- Pilih Ruang --'
      ])

      <hr>

      @component('partials.fields.wrapper', ['name' => 'list_items', 'label' => 'Daftar Barang'])
      <div id="table-list-items">
        <button v-on:click="showModalAddItem($event)" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> Tambah Barang</button>
        <table style="margin-top: 10px" class="table table-striped table-hover table-bordered">
          <thead>
            <tr>
              <th>No.</th>
              <th>Jenis Barang</th>
              <th>Sub Jenis Barang</th>
              <th>Jumlah</th>
              <th>Catatan</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody class="vhide hidden">
            <tr v-if="!list_items.length">
              <td colspan="6">
                <div class="well well-sm text-center" style="margin:0px">
                  Daftar Permintaan Barang Masih Kosong.
                  Silahkan klik tombol 'Tambah Barang' diatas.
                </div>
              </td>
            </tr>
            <tr v-for="item, index in list_items">
              <td>@{{ index + 1 }}</td>
              <td>@{{ item.jenis.nama }}</td>
              <td>@{{ item.subjenis.nama }}</td>
              <td>@{{ item.jumlah }}</td>
              <td>@{{ item.note }}</td>
              <td>
                <input type="hidden" :name="'items['+index+'][id_jenis]'" :value="item.jenis.id"/>
                <input type="hidden" :name="'items['+index+'][id_subjenis]'" :value="item.subjenis.id"/>
                <input type="hidden" :name="'items['+index+'][jumlah]'" :value="item.jumlah"/>
                <input type="hidden" :name="'items['+index+'][note]'" :value="item.note"/>
                <button v-on:click="showModalEditItem($event, index)" class="btn btn-primary">Edit</button>
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
          <a href="{{ route('AdminRequestExtracomptableControllerGetIndex') }}" class="btn btn-default"><i class="fa fa-chevron-left"></i> Batal</a>
          &nbsp;
          <button name="action" value="save" class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
        </div>
      </div>
      {!! csrf_field() !!}
    </form>
  @endcomponent
  @include('request-extracomptable.modal-pick-item')
@endsection

@section('scripts')
  @parent
  <script>
  var $id_gedung = $("#input-id_gedung");
  var $lantai = $("#input-lantai");
  var $id_ruang = $("#input-id_ruang");
  var modalPickItem = new ModalPickItem();

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
        list_items: []
      },
      mounted: function() {
        $(".vhide.hidden").removeClass('hidden');
      },
      methods: {
        showModalAddItem: function(e) {
          e.preventDefault();
          var self = this;
          modalPickItem.show({
            submit: function(data) {
              self.list_items.push(data);
              modalPickItem.hide();
            }
          })
        },
        showModalEditItem: function(e, index) {
          e.preventDefault();
          var self = this;
          var item = this.list_items[index];
          modalPickItem.show({
            id_jenis: item.jenis.id,
            id_subjenis: item.subjenis.id,
            note: item.note,
            jumlah: item.jumlah,
            submit: function(data) {
              for(var key in data) {
                self.list_items[index][key] = data[key];
              }
              modalPickItem.hide();
            }
          });
        },
        deleteItem: function(e, index) {
          e.preventDefault();
          this.list_items.splice(index, 1);
        }
      }
    })
  });
  </script>
@endsection
