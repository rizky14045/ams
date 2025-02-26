<div id="modal-pick-item" class="modal fade">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">Pilih Barang</h3>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="">Kategori Barang</label>
          <select ref="inputIdKategori" name="id_kategori" class="use-select2 form-group">
            <option value="">-- Pilih Kategori Barang --</option>
          </select>
        </div>
        <div class="form-group">
          <label for="">Jumlah</label>
          <input type="number" class="form-control" name="jumlah" min="1">
        </div>
        <div class="form-group">
          <label for="">Catatan</label>
          <textarea name="note" class="form-control"></textarea>
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
  this.list_kategori = {!! App\Models\KategoriInventory::orderBy('nama_kategori', 'asc')->get()->toJson() !!};

  this.$el.find('select.use-select2').select2({width: '100%'});

  this.setSelectOptions(this.$el.find("select[name='id_kategori']"), this.list_kategori.map(function(j) {
    return {
      value: j.id,
      label: j.nama_kategori
    }
  }));

  this.$el.find(".btn-cancel").click(function() {
    self.hide();
  });
}

ModalPickItem.prototype.show = function(options) {
  var self = this;
  options = $.extend({
    title: 'Pilih Barang',
    submit_label: 'Submit',
    id_kategori: '',
    note: '',
    jumlah: '',
    submit: null,
  }, options);

  this.resetForm();

  this.$el.find('.modal-title').text(options.title);
  this.$el.find('.btn-submit').text(options.submit_label);
  this.$el.find("input[name='jumlah']").val(options.jumlah);
  this.$el.find("textarea[name='note']").val(options.note);

  if (options.id_kategori) {
    this.$el.find("select[name='id_kategori']").val(options.id_kategori).trigger('change');
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
  this.$el.find("select[name='id_kategori']").val('').trigger('change');
  this.$el.find("input[name='jumlah']").val('');
  this.$el.find("textarea[name='note']").val('');
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
  var id_kategori = this.$el.find("select[name='id_kategori']").val();
  var jumlah = this.$el.find("input[name='jumlah']").val();
  var note = this.$el.find("textarea[name='note']").val();
  var kategori = this.list_kategori.find(function(j) {
    return j.id == id_kategori;
  });
  return {
    kategori: kategori,
    jumlah: jumlah,
    note: note
  }
};

</script>
@endscript
