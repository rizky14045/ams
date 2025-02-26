@extends('crudbooster::admin_template')

@section('content')
  @component('components.panel-form')
    @slot('title')
      <i class="fa fa-plus"></i> Add Asset Extra Comptable
    @endslot

    <form action="{{ route('asset-inventory::post-create') }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
      <div class="row">
        <div class="col-md-push-2 col-md-9">
          <h4>Lokasi</h4>
        </div>
      </div>

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

      @include('partials.fields.select2', [
        'name' => 'id_kategori',
        'value' => prev_input('id_kategori'),
        'required' => true,
        'label' => 'Kategori',
        'options' => $options_kategori,
        'emptyOption' => '-- Pilih Kategori Barang --'
      ])

      <hr>

      @component('partials.fields.text', [
        'name' => 'kd_asset',
        'value' => prev_input('kd_asset'),
        'required' => true,
        'label' => 'Kode Asset',
      ])
        @slot('groupRight')
        <div class="input-group-btn">
          <button id="btn-generate-kode" class="btn btn-success">Generate</button>
        </div>
        @endslot
      @endcomponent

      @include('partials.fields.text', [
        'name' => 'nama_asset',
        'value' => prev_input('nama_asset'),
        'required' => true,
        'label' => 'Nama Asset',
      ])

      @include('partials.fields.number', [
        'name' => 'jumlah',
        'value' => prev_input('jumlah'),
        'required' => true,
        'label' => 'Jumlah',
      ])

      @include('partials.fields.number', [
        'name' => 'jumlah_minimum',
        'value' => prev_input('jumlah_minimum'),
        'required' => true,
        'label' => 'Jumlah Minimum',
      ])

      @include('partials.fields.image', [
        'name' => 'gambar',
        'value' => prev_input('gambar'),
        'required' => true,
        'label' => 'Foto Barang',
      ])

      <hr>

      {{-- @include('partials.fields.select2', [
        'name' => 'ref_id_request',
        'value' => prev_input('ref_id_request'),
        'required' => false,
        'options' => [],
        'emptyOption' => '-- Pilih Kode Request --',
        'label' => 'Referensi Kode Request (opsional)',
      ]) --}}

      <hr>

      <div class="form-group">
        <div class="col-md-push-2 col-md-10">
          <a href="{{ route('AdminAssetInventoryControllerGetIndex') }}" class="btn btn-default"><i class="fa fa-chevron-left"></i> Batal</a>
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

@section('scripts')
  @parent
  <script>
  var $id_gedung = $("#input-id_gedung");
  var $lantai = $("#input-lantai");
  var $id_ruang = $("#input-id_ruang");
  var $id_kategori = $("#input-id_kategori");
  var $btn_generate_kode = $("#btn-generate-kode");
  var $kd_asset = $("#input-kd_asset");
  var $nama_asset = $("#input-nama_asset");

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

  function generateKodeAsset() {
    var id_gedung = $id_gedung.val();
    var lantai = $lantai.val();
    var id_ruang = $id_ruang.val();
    var id_kategori = $id_kategori.val();

    var can_generate = (id_gedung && lantai && id_ruang && id_kategori);
    if (!can_generate) {
      return '';
    }

    var url = "{{ route('asset-inventory::json-get-kode-asset') }}"
    $.getJSON(url, {
      id_gedung: id_gedung,
      lantai: lantai,
      id_ruang: id_ruang,
      id_kategori: id_kategori,
    })
    .done(function(res) {
      if (res.kode_asset) {
        $kd_asset.val(res.kode_asset);
      }
    })
  }

  function updateButtonGenerate() {
    var id_gedung = $id_gedung.val();
    var lantai = $lantai.val();
    var id_ruang = $id_ruang.val();
    var id_kategori = $id_kategori.val();

    var clickable = (id_gedung && lantai && id_ruang && id_kategori);

    if (!clickable) {
      $btn_generate_kode.attr('disabled', 'disabled');
    } else {
      $btn_generate_kode.removeAttr('disabled');
    }
  }

  $(function() {
    updateButtonGenerate();

    $id_gedung.change(function() {
      updateOptionsLantai();
      updateButtonGenerate();
    });

    $lantai.change(function() {
      updateOptionsRuang();
      updateButtonGenerate();
    });

    $id_kategori.change(function() {
      updateButtonGenerate();
    });

    $btn_generate_kode.click(function(e) {
      e.preventDefault();
      generateKodeAsset();
    });
  });
  </script>
@endsection
