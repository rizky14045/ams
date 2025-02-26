@extends('crudbooster::admin_template')

@section('content')
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
                  <li><a href="#" onclick="restoreCheckeds()">Restore</a></li>
                  <li><a href="#" onclick="deleteCheckeds()">Hapus Permanen</a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
        @endslot
        @slot('form_right_end')
        <a href="#" class="btn btn-print btn-info"><i class="fa fa-print"></i> Print</a>
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
    function restoreArchives(ids, callback) {
      swal({
        title: "KONFIRMASI TINDAKAN",
        text: ids.length + " data asset akan di restore. Apa anda yakin?",
        type: "warning",
        showCloseButton: true,
        showCancelButton: true,
        focusConfirm: false,
        confirmButtonText: 'Restore',
        confirmButtonColor: '#31CE5A',
        cancelButtonText: 'Cancel',
      }, function(sure) {
        if (sure) {
          $.ajax({
            type: 'POST',
            url: '{{ route('asset-extracomptable::restore-archives') }}',
            data: {ids: ids},
            dataType: 'json'
          })
          .done(function(res) {
            swal({
              title: "SUKSES",
              text: "Asset telah direstore.",
              type: "success",
            });
            if (typeof callback === 'function') callback(null, res);
          })
          .fail(function(xhr) {
            if (typeof callback === 'function') callback(xhr, null);
          })
          .always(function() {
            datagrid.fetch(1);
          })
        }
      });
    }

    function deleteArchives(ids, callback) {
      swal({
        title: "PERINGATAN",
        text: "Asset akan dihapus selamanya. Apa anda yakin?",
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
            url: '{{ route('asset-extracomptable::delete-archives') }}',
            data: {ids: ids},
            dataType: 'json'
          })
          .done(function(res) {
            swal({
              title: "SUKSES",
              text: "Asset telah dihapus permanen.",
              type: "success",
            });
            if (typeof callback === 'function') callback(null, res);
          })
          .fail(function(xhr) {
            if (typeof callback === 'function') callback(xhr, null);
          })
          .always(function() {
            datagrid.fetch(1);
          })
        }
      });
    }

    function deleteCheckeds() {
      var checkeds = datagrid.checkeds;
      deleteArchives(checkeds);
    }

    function restoreCheckeds() {
      var checkeds = datagrid.checkeds;
      restoreArchives(checkeds);
    }

    $(document).on('click', '.btn-delete', function(e) {
      e.preventDefault();
      var id = $(this).closest('tr').data('key');
      deleteArchives([id]);
    });

    $(document).on('click', '.btn-restore', function(e) {
      e.preventDefault();
      var id = $(this).closest('tr').data('key');
      restoreArchives([id])
    });
  </script>
@endsection
