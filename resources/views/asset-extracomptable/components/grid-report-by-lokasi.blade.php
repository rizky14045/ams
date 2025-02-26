<template id="grid-report-extracomptable-by-lokasi">
  <div class="grid-wrapper">
    <table class="table table-bordered table-hover no-margin">
      <thead>
        <tr>
          <th width="20">No.</th>
          <th width="160">Gedung</th>
          <th width="50">Lantai</th>
          <th width="200">Ruang</th>
          <th width="140">Jenis</th>
          <th>Sub Jenis</th>
          <th width="50">Jumlah</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(asset, i) in assets">
          <td width="20">@{{ offset + i }}</td>
          <td width="160">@{{ asset.gedung }}</td>
          <td width="50" class="text-center">@{{ asset.lantai }}</td>
          <td width="200">@{{ asset.ruang }}</td>
          <td width="140">@{{ asset.jenis }}</td>
          <td>@{{ asset.subjenis }}</td>
          <td class="text-center">@{{ asset.jumlah }}</td>
        </tr>
        <tr v-if="!assets.length">
          <td colspan="7" style="padding: 15px">
            <h4 class="no-margin">@{{ emptyMessage }}</h4>
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

@script('component-grid-report-extracomptable-by-lokasi')
  @parent
  <script>
  Vue.component('grid-report-extracomptable-by-lokasi', {
    template: '#grid-report-extracomptable-by-lokasi',
    props: {
      urlFetch: {
        type: String,
        required: true
      },
      filter: {
        type: Object,
        required: true
      }
    },
    data: function() {
      return {
        fetching: false,
        page: 1,
        limit: 25,
        offset: 0,
        order_by: 'id_gedung',
        order_asc: 'asc',
        total_pages: null,
        total_records: null,
        assets: [],
        countFetch: 0,
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
      },
      emptyMessage: function() {
        if (this.countFetch) {
          return "Data Asset Kosong"
        } else {
          return "Mengambil data ..."
        }
      }
    },
    mounted: function() {
      this.fetch(1)
    },
    watch: {
      filter: {
        deep: true,
        handler: function() {
          this.fetch(1)
        }
      }
    },
    methods: {
      fetch: function(page) {
        var self = this
        var data = {
          page: page,
          limit: this.limit,
          order_by: this.order_by,
          order_asc: this.order_asc,
          filter: this.filter
        }

        self.fetching = true
        $.getJSON(this.urlFetch, data)
        .always(function() {
          self.fetching = false
          self.countFetch += 1
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
