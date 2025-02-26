<template id="grid-extracomptable-by-jenis">
  <div class="grid-wrapper">
    <table class="table table-bordered table-hover no-margin">
      <thead>
        <tr>
          <th width="20">No.</th>
          <th width="120">Jenis</th>
          <th>Sub Jenis</th>
          <th width="50">Jumlah</th>
          <th width="50">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(asset, i) in assets">
          <td>@{{ offset + i }}</td>
          <td>@{{ asset.jenis }}</td>
          <td>@{{ asset.subjenis }}</td>
          <td class="text-center">@{{ asset.jumlah }}</td>
          <td width="50">
            <a :href="asset.url_detail" target="_blank" class="btn btn-xs btn-info"><i class="fa fa-list"></i> Detail</a>
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

@script('component-grid-extracomptable-by-jenis')
  @parent
  <script>
  Vue.component('grid-extracomptable-by-jenis', {
    template: '#grid-extracomptable-by-jenis',
    props: {
      urlFetch: {
        type: String,
        required: true
      }
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
          order_asc: this.order_asc
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
