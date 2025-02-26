@extends('crudbooster::admin_template')

@section('content')
<div class="form-group">
  <a href="{{ route('user-group::form-create') }}" class="btn btn-success btn-create"><i class="fa fa-plus"></i> Tambah</a>
</div>
<div id="grid-container">
  @include('partials.alert-messages')
  <div class="box box-solid">
    <div class="box-body">
      @component('components.datagrid', ['datagrid' => $datagrid])
        @slot('top_left')
        <div class="form-group form-inline">
          <div class="input-group">
            <span class="input-group-addon">@{{ checkeds.length }} dipilih</span>
            <div class="input-group-btn">
              <div class="dropdown">
                <button :disabled="!checkeds.length" class="btn btn-primary dropdown-toggle" type="button" id="bulk-action" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                  Terapkan Aksi
                  <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" aria-labelledby="bulk-action">
                  <li><a href="#" onclick="deleteCheckeds()">Hapus</a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
        @endslot
      @endcomponent
    </div>
  </div>
</div>
@endsection

@section('styles')
  @parent
  <style>
    tfoot .pagination {
      margin: 0px;
    }
  </style>
@endsection

@section('scripts')
  @parent
  <script>
    function deletes(ids, callback) {
      swal({
        title: "PERINGATAN",
        text: ids.length + " user group akan dihapus. Apa anda yakin?",
        type: "warning",
        showCloseButton: true,
        showCancelButton: true,
        focusConfirm: false,
        confirmButtonText: 'Delete',
        confirmButtonColor: '#E13737',
        cancelButtonText: 'Cancel',
      }, function(sure) {
        if (sure) {
          $.ajax({
            type: 'POST',
            url: '{{ route('user-group::deletes') }}',
            data: {ids: ids},
            dataType: 'json'
          })
          .done(function(res) {
            swal({
              title: "SUKSES",
              text: "User group telah dihapus permanen.",
              type: "success",
            });
            if (typeof callback === 'function') callback(null, res);
          })
          .fail(function(xhr) {
            if (typeof callback === 'function') callback(xhr, null);
          })
          .always(function() {
            datagrid.fetch(1);
          });
        }
      });
    }

    function deleteCheckeds() {
      var checkeds = datagrid.checkeds;
      deletes(checkeds);
    }

    $(document).on('click', '.btn-delete', function(e) {
      e.preventDefault();
      var id = $(this).closest('tr').data('key');
      deletes([id]);
    });
  </script>
@endsection
