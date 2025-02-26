@php
$data = array_merge(['columns' => $datagrid->getColumns()], $datagrid->getOptions());
$data['fetching'] = false;
$data['rows'] = [];
$data['search_placeholder'] = $datagrid->getOption('search_placeholder') ?: 'Search ...';
$data['keyword'] = '';
$data['sorts'] = new stdClass;
$data['checkeds'] = [];
$data['check_all'] = false;
$data['filters'] = $datagrid->getColumnFilters() ?: new stdClass;
$data['state'] = [
  'current_page' => 0,
  'per_page' => 15,
  'offset' => 0,
  'total_pages' => null,
  'total_rows' => 1,
];
@endphp
<div class="datagrid hidden" id="datagrid">
  {!! $top_left or '' !!}
  <div class="form-inline pull-right">
    {!! $form_right_start or '' !!}
    <div class="form-group" v-if="hasSearchables">
      <div class="input-group">
        <span class="input-group-addon">
          <i v-if="!fetching" class="fa fa-search"></i>
          <i v-if="fetching" class="fa fa-spin fa-spinner"></i>
        </span>
        <input type="text" v-on:input="updateKeyword" class="form-control" :placeholder="search_placeholder" />
      </div>
    </div>
    <div class="form-group" v-if="limit_options">
      <select v-model="per_page" class="form-control">
        <option v-for="(limit, index) in limit_options" :value="limit">@{{ limit }}</option>
      </select>
    </div>
    {!! $form_right_end or '' !!}
  </div>
  <div class="table-responsive">
    <table class="table table-bordered table-hover table-striped">
      <thead>
        <tr>
          <th class="text-center" width="20" v-if="checkables">
            <input type="checkbox" v-model="check_all"/>
          </th>
          <th v-for="(opt, col) in columns" v-if="opt.display !== false"
            v-on:click="handleClickTh(col)"
            v-bind:class="opt.th_class"
            :width="opt.width">
            <a v-if="opt.sortable" class="col-label">
              @{{ opt.label || col }}
            </a>
            <span v-if="!opt.sortable" class="col-label">
              @{{ opt.label || col }}
            </span>
            <i v-if="sorts[col]" style="float: right; display: inline-block; margin-top: 3px;" class="fa" v-bind:class="{
                'fa-caret-down': sorts[col] === 'asc',
                'fa-caret-up': sorts[col] === 'desc'
              }"></i>
          </th>
        </tr>
      </thead>
      <tbody>
        <tr v-if="!rows.length && state.current_page">
          <td :colspan="countColumns" class="empty-message" v-html="empty_message || 'Data kosong.'"></td>
        </tr>
        <tr v-for="(row, i) in rows" :data-key="row[primary_key]">
          <td class="text-center" width="20" v-if="checkables">
            <input type="checkbox" v-model="checkeds" :value="row[primary_key]" />
          </td>
          <td v-for="(opt, col) in columns" v-if="opt.display !== false"
            v-bind:class="opt.td_class"
            :width="opt.width"
            v-html="row[col]"></td>
        </tr>
      </tbody>
      <tfoot v-if="paginationLinks">
        <tr>
          <th class="text-center" width="20" v-if="checkables">
            <input type="checkbox" v-model="check_all"/>
          </th>
          <th v-for="(opt, col) in columns" v-if="opt.display !== false"
            v-on:click="handleClickTh(col)"
            v-bind:class="opt.th_class"
            :width="opt.width">
            <a v-if="opt.sortable" class="col-label">
              @{{ opt.label || col }}
            </a>
            <span v-if="!opt.sortable" class="col-label">
              @{{ opt.label || col }}
            </span>
            <i v-if="sorts[col]" style="float: right; display: inline-block; margin-top: 3px;" class="fa" v-bind:class="{
                'fa-caret-down': sorts[col] === 'asc',
                'fa-caret-up': sorts[col] === 'desc'
              }"></i>
          </th>
        </tr>
        <tr>
          <td :colspan="countColumns">
            <ul class="pagination">
              <li v-for="link in paginationLinks" v-bind:class="{
                  'active': state.current_page == link.page && !link.disabled,
                  'disabled': link.disabled
                }">
                <a href="#" v-on:click="handleClickPagination(link)" v-html="link.label"></a>
              </li>
            </ul>
          </td>
        </tr>
      </tfoot>
    </table>
  </div>
</div>

@script
<script>
  var datagrid = new Vue({
    el: '#datagrid',
    data: {!! json_encode($data) !!},
    mounted: function() {
      $(this.$el).removeClass('hidden');
      this.fetch(1);
    },
    watch: {
      check_all: function(check_all) {
        if (check_all) {
          var pk = this.primary_key;
          this.checkeds = this.rows.map(function(row) {
            return row[pk];
          });
        } else {
          this.checkeds = [];
        }
      },
      per_page: function() {
        this.fetch(1);
      }
    },
    computed: {
      hasSearchables: function() {
        return Object.values(this.columns).filter(function(col) {
          return col.searchable === true;
        }).length > 0;
      },
      countColumns: function() {
        var count = Object.keys(this.columns).length;
        return this.checkables ? count + 1 : count;
      },
      paginationLinks: function() {
        if (!this.state.total_pages) {
          return null;
        }

        var links = [];
        var total_pages = this.state.total_pages;
        var current_page = this.state.current_page;
        var prev_page = this.current_page > 1 ? this.current_page - 1 : 1;
        var next_page = this.current_page < total_pages ? this.current_page + 1 : total_pages;
        var start = 1;
        var end = total_pages;

        links.push({
          label: "<i class='fa fa-arrow-left'></i>",
          page: prev_page,
          disabled: prev_page === current_page
        });

        for(var p = start; p <= end; p++) {
          links.push({label: p, page: p});
        }

        links.push({
          label: "<i class='fa fa-arrow-right'></i>",
          page: next_page,
          disabled: next_page === current_page
        });

        return links;
      }
    },
    methods: {
      fetch: function(page) {
        var self = this;
        var url = this.fetch_url;
        var data = $.extend({}, {
          filters: this.filters,
          sorts: this.sorts,
          q: this.keyword,
          page: page,
          per_page: this.per_page
        });

        self.fetching = true
        $.getJSON(url, data)
        .done(function(res) {
          self.checkeds = []
          self.checkAll = false
          self.rows = res.data
          self.state.current_page = parseInt(res.current_page)
          self.state.total_pages = parseInt(res.last_page)
          self.state.total_rows = parseInt(res.total)
          self.state.per_page = parseInt(res.per_page)
          self.state.offset = parseInt(res.from)
        })
        .always(function() {
          self.fetching = false
        })
      },
      updateKeyword: debounce(function(e) {
        this.keyword = e.target.value;
        this.fetch(1);
      }, 500),
      handleClickTh: function(colName) {
        var colOption = this.columns[colName];
        var currSort = $.extend({}, this.sorts);
        if (colOption && colOption.sortable) {
          var sorts = {};
          sorts[colName] = (currSort && currSort[colName] == 'asc') ? 'desc' : 'asc';
          this.sorts = sorts;
          return this.fetch(1);
        }
      },
      handleClickPagination: function(link) {
        if (link.disabled) return;
        this.fetch(link.page);
      }
    }
  });
</script>
@endscript
