<div id="modal-pick-item" class="modal fade">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">Pilih Barang</h3>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="">Barang</label>
          <select ref="inputIdBarang" name="id_asset" class="use-select2 form-group">
            <option value="">-- Pilih Barang --</option>
          </select>
        </div>
        <div class="form-group">
          <label for="">Current Qty</label>
          <input disabled type="number" class="form-control" name="current_qty" min="1">
        </div>
        <div class="form-group">
          <label for="">New Qty</label>
          <input type="number" class="form-control" name="new_qty" min="1">
        </div>
        <div class="form-group">
          <label for="">Catatan</label>
          <textarea name="description" class="form-control"></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <a class="btn-cancel btn btn-default">Batal</a>
        <a class="btn-submit btn btn-primary">Submit</a>
      </div>
    </div>
  </div>
</div>

@css('vendor/crudbooster/assets/adminlte/plugins/select2/select2.min.css')
@js('vendor/crudbooster/assets/adminlte/plugins/select2/select2.min.js')

@style('init-select2')
<style type="text/css">
  .select2-container--default .select2-selection--single {border-radius: 0px !important}
  .select2-container .select2-selection--single {height: 35px}
  .select2-container--default .select2-selection--multiple .select2-selection__choice {
    background-color: #3c8dbc !important;
    border-color: #367fa9 !important;
    color: #fff !important;
  }
  .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
    color: #fff !important;
  }
</style>
@endstyle

@script('modal-pick-item')
<script>
var ModalPickItem = function() {
  var self = this;
  this.$el = $("#modal-pick-item");
  this.id_ruang = null;
  this.list_asset = {!! App\Models\AssetInventory::orderBy('nama_asset', 'asc')->get()->toJson() !!};

  this.$el.find('select.use-select2').select2({width: '100%'});

  this.setSelectOptions(this.$el.find("select[name='id_asset']"), this.list_asset.map(function(j) {
    return {
      value: j.id,
      label: j.nama_asset
    }
  }));

  this.$el.find("select[name='id_asset']").change(function() {
    self.fetchCurrentQty();
  });

  this.$el.find(".btn-cancel").click(function() {
    self.hide();
  });
}

ModalPickItem.prototype.show = function(options) {
  var self = this;
  options = $.extend({
    title: 'Pilih Barang',
    submit_label: 'Submit',
    id_asset: '',
    description: '',
    id_ruang: '',
    current_qty: '',
    new_qty: '',
    submit: null,
  }, options);

  this.resetForm();
  this.id_ruang = options.id_ruang;

  this.$el.find('.modal-title').text(options.title);
  this.$el.find('.btn-submit').text(options.submit_label);
  this.$el.find("input[name='current_qty']").val(options.current_qty);
  this.$el.find("input[name='new_qty']").val(options.new_qty);
  this.$el.find("textarea[name='description']").val(options.description);

  if (options.id_asset) {
    this.$el.find("select[name='id_asset']").val(options.id_asset).trigger('change');
  }

  if (typeof options.submit == 'function') {
    this.$el.find('.btn-submit').one('click', function() {
      options.submit.apply(self, [self.getData()])
    });
  }

  this.$el.modal('show');
}

ModalPickItem.prototype.hide = function() {
  this.$el.modal('hide');
}

ModalPickItem.prototype.resetForm = function() {
  this.$el.find("select[name='id_asset']").val('').trigger('change');
  this.$el.find("input[name='current_qty']").val('');
  this.$el.find("input[name='new_qty']").val('');
  this.$el.find("textarea[name='description']").val('');
}

ModalPickItem.prototype.setSelectOptions = function(el, options, value) {
  $(el).find("option").not("[value='']").remove();
  options.forEach(function(opt) {
    $(el).append('<option value="'+opt.value+'">'+opt.label+'</option>');
  });
  if (value) {
    $(el).val(value);
  }
  if ($(el).data('select2')) {
    $(el).select2('destroy').select2({width: '100%'});
  }
}

ModalPickItem.prototype.getData = function() {
  var id_asset = this.$el.find("select[name='id_asset']").val();
  var current_qty = this.$el.find("input[name='current_qty']").val();
  var new_qty = this.$el.find("input[name='new_qty']").val();
  var description = this.$el.find("textarea[name='description']").val();
  var asset = this.list_asset.find(function(j) {
    return j.id == id_asset;
  });
  return {
    asset: asset,
    current_qty: current_qty,
    new_qty: new_qty,
    description: description
  }
};

ModalPickItem.prototype.fetchCurrentQty = function(callback) {
  var self = this;
  var id_ruang = this.id_ruang;
  var id_asset = this.$el.find("select[name='id_asset']").val();
  var url = "{{ route('asset-inventory::json-get-quantity') }}";
  $.getJSON(url, {id_ruang: id_ruang, id_asset: id_asset}).done(function(res) {
    self.$el.find("input[name='current_qty']").val(res.qty);
    if (typeof callback == 'function') {
      callback(res.qty);
    }
  });
}


</script>
@endscript
