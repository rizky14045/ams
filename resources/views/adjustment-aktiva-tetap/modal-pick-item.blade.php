<div id="modal-pick-item" class="modal fade">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">Pilih Barang</h3>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="">Model Barang</label>
          <select name="id_model" class="use-select2 form-group">
            <option value="">-- Pilih Model Barang --</option>
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
  this.lokasi = null;
  this.list_model = {!! App\Models\ModelAktivaTetap::orderBy('nama_model', 'asc')->get()->toJson() !!};

  this.$el.find('select.use-select2').select2({width: '100%'});

  this.setSelectOptions(this.$el.find("select[name='id_model']"), this.list_model.map(function(j) {
    return {
      value: j.id,
      label: j.nama_model
    }
  }));

  this.$el.find("select[name='id_model']").change(function() {
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
    id_model: '',
    description: '',
    lokasi: '',
    current_qty: '',
    new_qty: '',
    submit: null,
  }, options);

  this.resetForm();
  this.lokasi = options.lokasi;

  this.$el.find('.modal-title').text(options.title);
  this.$el.find('.btn-submit').text(options.submit_label);
  this.$el.find("input[name='current_qty']").val(options.current_qty);
  this.$el.find("input[name='new_qty']").val(options.new_qty);
  this.$el.find("textarea[name='description']").val(options.description);

  if (options.id_model) {
    this.$el.find("select[name='id_model']").val(options.id_model).trigger('change');
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
  this.$el.find("select[name='id_model']").val('').trigger('change');
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
  var id_model = this.$el.find("select[name='id_model']").val();
  var current_qty = this.$el.find("input[name='current_qty']").val();
  var new_qty = this.$el.find("input[name='new_qty']").val();
  var description = this.$el.find("textarea[name='description']").val();
  var model = this.list_model.find(function(j) {
    return j.id == id_model;
  });
  return {
    model: model,
    current_qty: current_qty,
    new_qty: new_qty,
    description: description
  }
};

ModalPickItem.prototype.fetchCurrentQty = function(callback) {
  var self = this;
  var lokasi = this.lokasi;
  var id_model = this.$el.find("select[name='id_model']").val();
  var url = "{{ route('asset-aktiva-tetap::json-get-quantity') }}";
  $.getJSON(url, {lokasi: lokasi, id_model: id_model}).done(function(res) {
    self.$el.find("input[name='current_qty']").val(res.qty);
    if (typeof callback == 'function') {
      callback(res.qty);
    }
  });
}


</script>
@endscript
