@extends('crudbooster::admin_template')

@section('content')
  @component('components.panel-form')
    @slot('title')
      <i class="fa fa-plus"></i> Add Asset Aktiva Tetap
    @endslot

    <form action="{{ route('asset-aktiva-tetap::post-create') }}" method="POST" enctype="multipart/form-data" class="form-horizontal">

      @include('partials.fields.text', [
        'name' => 'lokasi',
        'value' => prev_input('lokasi'),
        'required' => true,
        'label' => 'Lokasi Asset',
      ])

      @include('partials.fields.select2', [
        'name' => 'id_model',
        'value' => prev_input('id_model'),
        'required' => true,
        'label' => 'Model',
        'options' => $options_model,
        'emptyOption' => '-- Pilih Model Asset --'
      ])

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

      @include('partials.fields.date', [
        'name' => 'tgl_masuk',
        'value' => prev_input('tgl_masuk'),
        'required' => true,
        'label' => 'Tanggal Pembelian',
        'value' => date('Y-m-d')
      ])

      @include('partials.fields.select2', [
        'name' => 'status',
        'value' => prev_input('status'),
        'required' => true,
        'label' => 'Status Asset',
        'options' => $options_status,
        'emptyOption' => '-- Pilih Status Asset --'
      ])

      @include('partials.fields.image', [
        'name' => 'gambar',
        'value' => prev_input('gambar'),
        'required' => true,
        'label' => 'Foto Asset',
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
          <a href="{{ route('AdminAssetAktivaTetapControllerGetIndex') }}" class="btn btn-default"><i class="fa fa-chevron-left"></i> Batal</a>
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
  var $id_model = $("#input-id_model");
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

  function generateKodeAsset() {
    var id_model = $id_model.val();

    var can_generate = id_model.length > 0;
    if (!can_generate) {
      return '';
    }

    var url = "{{ route('asset-aktiva-tetap::json-get-kode-asset') }}";
    $.getJSON(url, {
      id_model: id_model,
    })
    .done(function(res) {
      if (res.kode_asset) {
        $kd_asset.val(res.kode_asset);
      }
    })
  }

  function updateButtonGenerate() {
    var id_model = $id_model.val();

    var clickable = (id_model.length > 0);

    if (!clickable) {
      $btn_generate_kode.attr('disabled', 'disabled');
    } else {
      $btn_generate_kode.removeAttr('disabled');
    }
  }

  $(function() {
    updateButtonGenerate();

    $id_model.change(function() {
      updateButtonGenerate();
    });

    $btn_generate_kode.click(function(e) {
      e.preventDefault();
      generateKodeAsset();
    });
  });
  </script>
@endsection
