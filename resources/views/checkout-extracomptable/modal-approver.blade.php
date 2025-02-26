<div id="modal-approver" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="" method="post">
        <div class="modal-header">
          <h4 class="modal-title">Approve Checkout</h4>
        </div>
        <div class="modal-body">
          <p class="text-muted">
            <i class="fa fa-info-circle"></i> Klik approve jika barang-barang dibawah ini sudah sampai di ruang tujuan.
          </p>
          <table class="table table-striped table-hover table-bordered" style="margin-bottom:0px">
            <thead>
              <tr>
                <th width="20" class="text-center">No.</th>
                <th width="120">Kode Asset</th>
                <th>Nama Asset</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
        <div class="modal-footer">
          {!! csrf_field() !!}
          <a class="btn btn-default pull-left" data-dismiss="modal">Batal</a>
          <button class="btn btn-success submit-approve"><i class="fa fa-check"></i> Approve</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  function showModalApprove(url, options) {
    options = $.extend({}, options);
    var $modal = $("#modal-approver");
    var $form = $modal.find('form');
    var idCheckout = url.split('/').pop();
    var urlFetchCheckout = "{{ route('checkout-extracomptable::get-json-detail', ':id') }}";

    if (typeof options.beforeFetchCheckout == 'function') {
      options.beforeFetchCheckout(xhr);
    }
    $.getJSON(urlFetchCheckout.replace(':id', idCheckout))
    .done(function(res) {
      if (typeof options.onCheckoutFetchSucces == 'function') {
        options.onCheckoutFetchSucces(xhr);
      }

      var $tbody = $modal.find('tbody');
      $form.attr('action', url);
      $tbody.html('');
      try {
        res.checkout.items.forEach(function(item, i) {
          var $tr = $("<tr></tr>");
          $tr.append("<td>"+(i+1)+"</td>");
          $tr.append("<td>"+item.asset.kd_asset+"</td>");
          $tr.append("<td>"+item.asset.nama_asset+"</td>");
          $tr.appendTo($tbody);
        });
        $modal.modal('show');
      } catch(err) {
        alert('Checkout tidak dapat di approve. Terdapat data yang corrupt pada checkout ini. Harap hubungi pengembang untuk memeriksa keutuhan data.');
        console.error(err);
      }
    })
    .fail(function(xhr) {
      alert('Error '+xhr.status+'. \n\nMohon maaf, saat ini kamu tidak dapat approve. Terjadi kesalahan saat mengambil data checkout.');
      if (typeof options.onCheckoutFetchFailed == 'function') {
        options.onCheckoutFetchFailed(xhr);
      }
    })
    .always(function(xhr) {
      if (typeof options.afterFetchCheckout == 'function') {
        options.afterFetchCheckout(xhr);
      }
    });
  }

  $(function() {
    $('.btn-approve').click(function(e) {
      e.preventDefault();
      var href = $(this).attr('href');
      showModalApprove(href);
    });
  })
</script>
