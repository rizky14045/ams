@extends('crudbooster::admin_template')

@section('content')
  @component('components.panel-form')
    @slot('title')
      <i class="fa fa-plus"></i> Add Asset Inventory
    @endslot

    <form action="{{ route('pos-asset-inventory::post-create') }}" method="POST" enctype="multipart/form-data" class="form-horizontal">

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
          <a href="{{ route('AdminPosInventoryControllerGetIndex') }}" class="btn btn-default"><i class="fa fa-chevron-left"></i> Batal</a>
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
  var $id_kategori = $("#input-id_kategori");
  var $btn_generate_kode = $("#btn-generate-kode");
  var $kd_asset = $("#input-kd_asset");
  var $nama_asset = $("#input-nama_asset");

  function generateKodeAsset() {
    var id_kategori = $id_kategori.val();

    var can_generate = (id_kategori);
    if (!can_generate) {
      return '';
    }

    var url = "{{ route('pos-asset-inventory::json-get-kode-asset') }}"
    $.getJSON(url, {
      id_kategori: id_kategori,
    })
    .done(function(res) {
      if (res.kode_asset) {
        $kd_asset.val(res.kode_asset);
      }
    })
  }

  function updateButtonGenerate() {
    var id_kategori = $id_kategori.val();
    var clickable = id_kategori;

    if (!clickable) {
      $btn_generate_kode.attr('disabled', 'disabled');
    } else {
      $btn_generate_kode.removeAttr('disabled');
    }
  }

  $(function() {
    updateButtonGenerate();

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
