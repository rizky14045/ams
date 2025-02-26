<template id="grid-extracomptable-per-jenis">
  <div class="grid-wrapper">
    <table class="table table-bordered table-hover no-margin">
      <thead>
        <tr>
          <th width="20">No.</th>
          <th width="120">Kode Asset</th>
          <th>Nama Asset</th>
          {{-- <th width="160">Jenis</th> --}}
          {{-- <th width="160">Sub Jenis</th> --}}
          <th width="160">Gedung</th>
          <th width="50">Lantai</th>
          <th width="100">Ruang</th>
          <th width="100">Status</th>
          <th width="200">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(asset, i) in assets">
          <td width="20">@{{ offset + i }}</td>
          <td width="120">@{{ asset.kd_asset }}</td>
          <td>@{{ asset.nama_asset }}</td>
          {{-- <td width="120">@{{ asset.jenis.nama }}</td> --}}
          {{-- <td width="120">@{{ asset.subjenis.nama }}</td> --}}
          <td width="160">@{{ asset.gedung.nama }}</td>
          <td width="50">@{{ asset.lantai }}</td>
          <td width="100">@{{ asset.ruang.nama_ruang }}</td>
          <td width="100">@{{ asset.status }}</td>
          <td width="200">
            <a :href="asset.url_detail" class="btn btn-xs btn-info"><i class="fa fa-search"></i> Detail</a>
            <a :href="asset.url_edit" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i> Edit</a>
            <a onclick="return confirm('Apa anda yakin ingin menghapus asset ini?')"  :href="asset.url_delete" class="btn btn-xs btn-danger"><i class="fa fa-trash-o"></i> Hapus</a>
          </td>
        </tr>
      </tbody>
    </table>
    <ul v-if="total_pages && total_pages > 1" class="pagination" style="margin-top: 10px">
      <li v-for="p in pages" :class="{'active': p.page == page}">
        <a v-on:click="fetch(p.page)" href="#">@{{ p.label }}</a>
      </li>
    </ul>
  </div>
</template>

@script('component-grid-extracomptable-per-jenis')
  @parent
  <script>
  Vue.component('grid-extracomptable-per-jenis', {
    template: '#grid-extracomptable-per-jenis',
    props: {
      urlFetch: {
        type: String,
        required: true
      },
      idJenis: {
        type: Number,
        required: true
      },
      idSubjenis: {
        type: Number,
        required: true
      },
    },
    data: function() {
      return {
        fetching: false,
        page: 1,
        limit: 25,
        offset: 0,
        order_by: 'id_jenis',
        order_asc: 'asc',
        total_pages: null,
        total_records: null,
        assets: []
      }
    },
    computed: {
      pages: function() {
        var pages = []
        if (!this.total_pages) return [];

        for (var p = 1; p <= this.total_pages; p++) {
          pages.push({
            page: p,
            label: p
          })
        }

        return pages
      }
    },
    mounted: function() {
      this.fetch(1)
    },
    methods: {
      fetch: function(page) {
        var self = this
        var data = {
          page: page,
          limit: this.limit,
          order_by: this.order_by,
          order_asc: this.order_asc,
          id_jenis: this.idJenis,
          id_subjenis: this.idSubjenis
        }

        self.fetching = true
        $.getJSON(this.urlFetch, data)
        .always(function() {
          self.fetching = false
        })
        .done(function(res) {
          self.page = page
          self.assets = res.data
          self.total_pages = res.last_page
          self.total_records = res.total
          self.offset = res.from
        })
        .fail(function(xhr) {
          alert('Terjadi kesalahan saat mengambil data')
        })
      }
    }
  })
  </script>
@endscript
