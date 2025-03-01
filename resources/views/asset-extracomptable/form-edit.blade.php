@extends('crudbooster::admin_template')

@section('content')
  @component('components.panel-form')
    @slot('title')
      <i class="fa fa-edit"></i> Edit Asset Extra Comptable
    @endslot

    <form action="{{ route('asset-extracomptable::post-edit', [$asset->id]) }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
      <div class="row">
        <div class="col-md-push-2 col-md-9">
          <h4>Lokasi</h4>
        </div>
      </div>

      @include('partials.fields.select2', [
        'name' => 'id_gedung',
        'value' => $asset->id_gedung,
        'required' => true,
        'label' => 'Gedung',
        'options' => $options_gedung,
        'emptyOption' => '-- Pilih Gedung --'
      ])

      @include('partials.fields.select2', [
        'name' => 'lantai',
        'value' => $asset->lantai,
        'required' => true,
        'label' => 'Lantai',
        'options' => isset($options_lantai) ? $options_lantai : [],
        'emptyOption' => '-- Pilih Lantai --'
      ])

      @include('partials.fields.select2', [
        'name' => 'id_ruang',
        'value' => $asset->id_ruang,
        'required' => true,
        'label' => 'Ruang',
        'options' => isset($options_ruang) ? $options_ruang : [],
        'emptyOption' => '-- Pilih Ruang --'
      ])

      <hr>

      @include('partials.fields.select2', [
        'name' => 'id_jenis',
        'value' => $asset->id_jenis,
        'required' => true,
        'label' => 'Jenis',
        'options' => $options_jenis,
        'emptyOption' => '-- Pilih Jenis Barang --'
      ])

      @include('partials.fields.select2', [
        'name' => 'id_subjenis',
        'value' => $asset->id_subjenis,
        'required' => true,
        'label' => 'Sub Jenis',
        'options' => isset($options_subjenis) ? $options_subjenis : [],
        'emptyOption' => '-- Pilih Sub Jenis Barang --'
      ])

      <hr>

      @component('partials.fields.text', [
        'name' => 'kd_asset',
        'value' => $asset->kd_asset,
        'required' => true,
        'readonly' => true,
        'label' => 'Kode Asset',
      ])
        @slot('groupRight')
        <div class="input-group-btn">
          <button disabled id="btn-generate-kode" class="btn btn-success">Generate</button>
        </div>
        @endslot
      @endcomponent

      @include('partials.fields.text', [
        'name' => 'nama_asset',
        'value' => $asset->nama_asset,
        'required' => true,
        'label' => 'Nama Asset',
      ])

      @include('partials.fields.date', [
        'name' => 'tgl_masuk',
        'value' => $asset->tgl_masuk,
        'required' => true,
        'label' => 'Tanggal Pembelian',
        'value' => date('Y-m-d')
      ])

      @include('partials.fields.select2', [
        'name' => 'status',
        'value' => $asset->status,
        'required' => true,
        'label' => 'Status Barang',
        'options' => $options_status,
        'emptyOption' => '-- Pilih Status Barang --'
      ])

      @include('partials.fields.image', [
        'name' => 'gambar',
        'value' => $asset->gambar,
        'required' => false,
        'label' => 'Foto Barang',
      ])
      @include('partials.fields.text', [
        'name' => 'rfid',
        'value' => $asset->rfid,
        'required' => true,
        'label' => 'RFID',
      ])


      <hr>

      {{-- @include('partials.fields.select2', [
        'name' => 'ref_id_request',
        'value' => $asset->ref_id_request,
        'required' => false,
        'options' => [],
        'emptyOption' => '-- Pilih Kode Request --',
        'label' => 'Referensi Kode Request (opsional)',
      ]) --}}

      <hr>

      <div class="form-group">
        <div class="col-md-push-2 col-md-10">
          <a href="{{ route('AdminAssetExtracomptableControllerGetIndex') }}" class="btn btn-default"><i class="fa fa-chevron-left"></i> Batal</a>
          &nbsp;
          <button name="action" value="save" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
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
  var $id_jenis = $("#input-id_jenis");
  var $id_subjenis = $("#input-id_subjenis");
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

  function updateOptionsSubjenis() {
    var id_jenis = $id_jenis.val();
    if (!id_jenis) {
      return setSelectOptions($id_subjenis, []);
    }

    var url = "{{ route('jenis-extracomptable::json-options-subjenis') }}";
    $.getJSON(url, {id_jenis: id_jenis}).done(function(res) {
      var list_subjenis = res.list_subjenis;
      setSelectOptions($id_subjenis, list_subjenis.map(function(subjenis) {
        return {
          label: subjenis.nama,
          value: subjenis.id
        };
      }));
    });
  }

  function generateKodeAsset() {
    var id_gedung = $id_gedung.val();
    var lantai = $lantai.val();
    var id_ruang = $id_ruang.val();
    var id_jenis = $id_jenis.val();
    var id_subjenis = $id_subjenis.val();

    var can_generate = (id_gedung && lantai && id_ruang && id_jenis && id_subjenis);
    if (!can_generate) {
      return '';
    }

    var url = "{{ route('asset-extracomptable::json-get-kode-asset') }}"
    $.getJSON(url, {
      id_gedung: id_gedung,
      lantai: lantai,
      id_ruang: id_ruang,
      id_jenis: id_jenis,
      id_subjenis: id_subjenis,
    })
    .done(function(res) {
      if (res.kode_asset) {
        $kd_asset.val(res.kode_asset);
      }
    })
  }

  function updateNamaAsset() {
    var id_subjenis = $id_subjenis.val();
    if (!id_subjenis) {
      $nama_asset.val("");
    } else {
      var nama_asset = $id_subjenis.find("option[value='"+id_subjenis+"']").text();
      $nama_asset.val(nama_asset);
    }
  }

  function updateButtonGenerate() {
    var id_gedung = $id_gedung.val();
    var lantai = $lantai.val();
    var id_ruang = $id_ruang.val();
    var id_jenis = $id_jenis.val();
    var id_subjenis = $id_subjenis.val();

    var clickable = (id_gedung && lantai && id_ruang && id_jenis && id_subjenis);

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

    $id_jenis.change(function() {
      updateOptionsSubjenis();
      updateButtonGenerate();
    });

    $id_subjenis.change(function() {
      updateButtonGenerate();
      if (!$nama_asset.val()) {
        updateNamaAsset();
      }
    });

    $btn_generate_kode.click(function(e) {
      e.preventDefault();
      generateKodeAsset();
    });
  });
  </script>
@endsection
