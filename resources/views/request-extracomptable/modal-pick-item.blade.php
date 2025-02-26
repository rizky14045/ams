<div id="modal-pick-item" class="modal fade">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">Pilih Barang</h3>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="">Jenis Barang</label>
          <select ref="inputIdJenis" name="id_jenis" class="use-select2 form-group">
            <option value="">-- Pilih Jenis Barang --</option>
          </select>
        </div>
        <div class="form-group">
          <label for="">Sub Jenis Barang</label>
          <select ref="inputIdSubJenis" name="id_subjenis" class="use-select2 form-group">
            <option value="">-- Pilih Sub Jenis Barang --</option>
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
  this.list_jenis = {!! App\Models\JenisExtracomptable::orderBy('nama', 'asc')->get()->toJson() !!};
  this.list_subjenis = [];

  this.$el.find('select.use-select2').select2({width: '100%'});

  this.$el.find("select[name='id_jenis']").change(function() {
    var id_jenis = $(this).val();
    if (id_jenis) {
      self.fetchListSubJenis(id_jenis);
    }
  });

  this.setSelectOptions(this.$el.find("select[name='id_jenis']"), this.list_jenis.map(function(j) {
    return {
      value: j.id,
      label: j.nama
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
    id_jenis: '',
    id_subjenis: '',
    note: '',
    jumlah: '',
    submit: null,
  }, options);

  this.resetForm();

  this.$el.find('.modal-title').text(options.title);
  this.$el.find('.btn-submit').text(options.submit_label);
  this.setSelectOptions(this.$el.find('select[name="id_subjenis"]'), [], '');

  this.$el.find("input[name='jumlah']").val(options.jumlah);
  this.$el.find("textarea[name='note']").val(options.note);

  if (options.id_jenis) {
    this.$el.find("select[name='id_jenis']").val(options.id_jenis).trigger('change');
    this.fetchListSubJenis(options.id_jenis, options.id_subjenis);
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
  this.$el.find("select[name='id_jenis']").val('').trigger('change');
  this.$el.find("select[name='id_subjenis']").val('');
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

ModalPickItem.prototype.fetchListSubJenis = function(id_jenis, value) {
  var self = this;
  var url = "{{ route('jenis-extracomptable::json-options-subjenis') }}";
  return $.getJSON(url, {id_jenis: id_jenis}).done(function(res) {
    self.list_subjenis = res.list_subjenis;
    self.setSelectOptions(self.$el.find('select[name="id_subjenis"]'), res.list_subjenis.map(function(sj) {
      return {
        label: sj.nama,
        value: sj.id
      }
    }), value);
  });
};

ModalPickItem.prototype.getData = function() {
  var id_jenis = this.$el.find("select[name='id_jenis']").val();
  var id_subjenis = this.$el.find("select[name='id_subjenis']").val();
  var jumlah = this.$el.find("input[name='jumlah']").val();
  var note = this.$el.find("textarea[name='note']").val();
  var jenis = this.list_jenis.find(function(j) {
    return j.id == id_jenis;
  });
  var subjenis = this.list_subjenis.find(function(sj) {
    return sj.id == id_subjenis;
  });
  return {
    jenis: jenis,
    subjenis: subjenis,
    jumlah: jumlah,
    note: note
  }
};

</script>
@endscript
