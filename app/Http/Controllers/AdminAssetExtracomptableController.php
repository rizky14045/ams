<?php namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\AssetUtils;
use App\Models\AssetExtracomptable;
use App\Models\Gedung;
use App\Models\JenisExtracomptable;
use App\Models\User;
use App\Traits\GetMasterOptions;

    use Session;
    use Request;
    use DB;
    use CRUDBooster;

    class AdminAssetExtracomptableController extends \crocodicstudio\crudbooster\controllers\CBController {

        use GetMasterOptions;
        use AssetUtils;

        protected $model = 'App\Models\AssetExtracomptable';

        public function cbInit() {

            # START CONFIGURATION DO NOT REMOVE THIS LINE
            $this->title_field = "nama_asset";
            $this->limit = "20";
            $this->orderby = "id,desc";
            $this->global_privilege = false;
            $this->button_table_action = true;
            $this->button_bulk_action = true;
            $this->button_action_style = "button_icon";
            $this->button_add = true;
            $this->button_edit = true;
            $this->button_delete = true;
            $this->button_detail = true;
            $this->button_show = true;
            $this->button_filter = true;
            $this->button_import = true;
            $this->button_export = true;
            $this->table = "asset_extracomptable";
            # END CONFIGURATION DO NOT REMOVE THIS LINE

			# START COLUMNS DO NOT REMOVE THIS LINE
			$this->col = [];
			$this->col[] = ["label"=>"Kode Asset","name"=>"kd_asset"];
			$this->col[] = ["label"=>"Gedung","name"=>"id_gedung","join"=>"gedung,nama"];
			$this->col[] = ["label"=>"Lantai","name"=>"lantai"];
			$this->col[] = ["label"=>"Ruang","name"=>"id_ruang","join"=>"ruang,nama_ruang"];
			$this->col[] = ["label"=>"Jenis","name"=>"id_jenis","join"=>"jenis_extracomptable,nama"];
			$this->col[] = ["label"=>"Subjenis","name"=>"id_subjenis","join"=>"subjenis_extracomptable,nama"];
            $this->col[] = ["label"=>"Nama Asset","name"=>"nama_asset"];
            $this->col[] = [
                "label" => "Status",
                "name" => "status",
                "width" => 10,
                "callback" => function($row) {
                    $configs = config('asset.status_extracomptable');
                    $config = array_first($configs, function($opt) use ($row) { return $opt['value'] == $row->status; });
                    $class = !empty($config) ? $config['class'] : 'label-default';
                    return "<span class='label {$class}'>{$row->status}</span>";
                }
            ];
            $this->col[] = [
                "label" => "QRCode",
                "name" => "id",
                "sorting" => false,
                "width" => 50,
                "callback" => function($row) {
                    $asset = AssetExtracomptable::find($row->id);
                    $qrcodeUrl = $asset->qrcode()->getUrl();
                    return "<a download href='{$qrcodeUrl}'><img class='qrcode' style='width: 50px;' src='{$qrcodeUrl}'/></a>";
                }
            ];
            $this->col[] = [
                "label" => "Print",
                "name" => "id",
                "sorting" => false,
                "width" => 50,
                "callback" => function($row) {
                    return "
                        <button class='btn-print-qrcode btn btn-default btn-xs'><i class='fa fa-print'></i> Print QRCode</button>
                        <div class='hidden'><iframe src='about:blank' class='iframe-qrcode'></iframe></div>
                    ";
                }
            ];

            # END COLUMNS DO NOT REMOVE THIS LINE

            # START FORM DO NOT REMOVE THIS LINE
            $this->form = [];
            $this->form[] = ['label'=>'Kode Asset','name'=>'kd_asset','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
            $this->form[] = ['label'=>'Gedung','name'=>'id_gedung','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-10','datatable'=>'gedung,nama'];
            $this->form[] = ['label'=>'Lantai','name'=>'lantai','type'=>'number','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
            $this->form[] = ['label'=>'Ruang','name'=>'id_ruang','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-10','datatable'=>'ruang,nama_ruang'];
            $this->form[] = ['label'=>'Jenis','name'=>'id_jenis','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-10','datatable'=>'jenis_extracomptable,id'];
            $this->form[] = ['label'=>'Subjenis','name'=>'id_subjenis','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-10','datatable'=>'jenis_extracomptable,id'];
            $this->form[] = ['label'=>'Nama Asset','name'=>'nama_asset','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
            $this->form[] = ['label'=>'Tgl Masuk','name'=>'tgl_masuk','type'=>'date','validation'=>'required|date','width'=>'col-sm-10'];
            $this->form[] = ['label'=>'Status','name'=>'status','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
            $this->form[] = ['label'=>'Gambar','name'=>'gambar','type'=>'upload','validation'=>'required|image|max:3000','width'=>'col-sm-10','help'=>'File types support : JPG, JPEG, PNG, GIF, BMP'];
            $this->form[] = ['label'=>'Ref Request','name'=>'ref_id_request','type'=>'number','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
            # END FORM DO NOT REMOVE THIS LINE

            # OLD START FORM
            //$this->form = [];
            //$this->form[] = ["label"=>"Kd Asset","name"=>"kd_asset","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
            //$this->form[] = ["label"=>"Gedung","name"=>"id_gedung","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"gedung,nama"];
            //$this->form[] = ["label"=>"Lantai","name"=>"lantai","type"=>"number","required"=>TRUE,"validation"=>"required|integer|min:0"];
            //$this->form[] = ["label"=>"Ruang","name"=>"id_ruang","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"ruang,nama_ruang"];
            //$this->form[] = ["label"=>"Jenis","name"=>"id_jenis","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"jenis,id"];
            //$this->form[] = ["label"=>"Subjenis","name"=>"id_subjenis","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"subjenis,id"];
            //$this->form[] = ["label"=>"Nama Asset","name"=>"nama_asset","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
            //$this->form[] = ["label"=>"Tgl Masuk","name"=>"tgl_masuk","type"=>"date","required"=>TRUE,"validation"=>"required|date"];
            //$this->form[] = ["label"=>"Status","name"=>"status","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
            //$this->form[] = ["label"=>"Gambar","name"=>"gambar","type"=>"upload","required"=>TRUE,"validation"=>"required|image|max:3000","help"=>"File types support : JPG, JPEG, PNG, GIF, BMP"];
            //$this->form[] = ["label"=>"Ref Request","name"=>"ref_id_request","type"=>"number","required"=>TRUE,"validation"=>"required|integer|min:0"];
            # OLD END FORM

            /*
            | ----------------------------------------------------------------------
            | Sub Module
            | ----------------------------------------------------------------------
            | @label          = Label of action
            | @path           = Path of sub module
            | @foreign_key       = foreign key of sub table/module
            | @button_color   = Bootstrap Class (primary,success,warning,danger)
            | @button_icon    = Font Awesome Class
            | @parent_columns = Sparate with comma, e.g : name,created_at
            |
            */
            $this->sub_module = array();


            /*
            | ----------------------------------------------------------------------
            | Add More Action Button / Menu
            | ----------------------------------------------------------------------
            | @label       = Label of action
            | @url         = Target URL, you can use field alias. e.g : [id], [name], [title], etc
            | @icon        = Font awesome class icon. e.g : fa fa-bars
            | @color        = Default is primary. (primary, warning, succecss, info)
            | @showIf        = If condition when action show. Use field alias. e.g : [id] == 1
            |
            */
            $this->addaction = array();

            /*
            | ----------------------------------------------------------------------
            | Add More Button Selected
            | ----------------------------------------------------------------------
            | @label       = Label of action
            | @icon        = Icon from fontawesome
            | @name        = Name of button
            | Then about the action, you should code at actionButtonSelected method
            |
            */
            $this->button_selected = array();


            /*
            | ----------------------------------------------------------------------
            | Add alert message to this module at overheader
            | ----------------------------------------------------------------------
            | @message = Text of message
            | @type    = warning,success,danger,info
            |
            */
            $this->alert        = array();



            /*
            | ----------------------------------------------------------------------
            | Add more button to header button
            | ----------------------------------------------------------------------
            | @label = Name of button
            | @url   = URL Target
            | @icon  = Icon from Awesome.
            |
            */
            $this->index_button = array();



            /*
            | ----------------------------------------------------------------------
            | Customize Table Row Color
            | ----------------------------------------------------------------------
            | @condition = If condition. You may use field alias. E.g : [id] == 1
            | @color = Default is none. You can use bootstrap success,info,warning,danger,primary.
            |
            */
            $this->table_row_color = array();


            /*
            | ----------------------------------------------------------------------
            | You may use this bellow array to add statistic at dashboard
            | ----------------------------------------------------------------------
            | @label, @count, @icon, @color
            |
            */
            $this->index_statistic = array();



            /*
            | ----------------------------------------------------------------------
            | Add javascript at body
            | ----------------------------------------------------------------------
            | javascript code in the variable
            | $this->script_js = "function() { ... }";
            |
            */
            $this->script_js = "
                $('.btn-print-qrcode').click(function(e) {
                    e.preventDefault();
                    var img = $(this).closest('tr').find('img.qrcode')[0];
                    var iframe = $(this).closest('tr').find('.iframe-qrcode')[0];
                    var doc = iframe.contentWindow.document
                    doc.open();
                    doc.write('<html><body><img style=\"height:3.6cm;width:auto;\" src=\"'+$(img).attr('src')+'\"/><script>window.onload = print<\/script><\/body></html>')
                    doc.close();
                });
            ";


            /*
            | ----------------------------------------------------------------------
            | Include HTML Code before index table
            | ----------------------------------------------------------------------
            | html code to display it before index table
            | $this->pre_index_html = "<p>test</p>";
            |
            */
            $this->pre_index_html = null;



            /*
            | ----------------------------------------------------------------------
            | Include HTML Code after index table
            | ----------------------------------------------------------------------
            | html code to display it after index table
            | $this->post_index_html = "<p>test</p>";
            |
            */
            $this->post_index_html = null;



            /*
            | ----------------------------------------------------------------------
            | Include Javascript File
            | ----------------------------------------------------------------------
            | URL of your javascript each array
            | $this->load_js[] = asset("myfile.js");
            |
            */
            $this->load_js = array();



            /*
            | ----------------------------------------------------------------------
            | Add css style at body
            | ----------------------------------------------------------------------
            | css code in the variable
            | $this->style_css = ".style{....}";
            |
            */
            $this->style_css = NULL;



            /*
            | ----------------------------------------------------------------------
            | Include css File
            | ----------------------------------------------------------------------
            | URL of your css each array
            | $this->load_css[] = asset("myfile.css");
            |
            */
            $this->load_css = array();


        }


        /*
        | ----------------------------------------------------------------------
        | Hook for button selected
        | ----------------------------------------------------------------------
        | @id_selected = the id selected
        | @button_name = the name of button
        |
        */
        public function actionButtonSelected($id_selected,$button_name) {
            //Your code here

        }


        /*
        | ----------------------------------------------------------------------
        | Hook for manipulate query of index result
        | ----------------------------------------------------------------------
        | @query = current sql query
        |
        */
        public function hook_query_index(&$query) {
            $user = \CB::me();
            $user = User::find($user->id);
            $listAksesRuang = $user->getListAksesRuang();
            if (!$listAksesRuang) {
                $query->where('asset_extracomptable.id', 0);
            } else {
                $query->whereIn('asset_extracomptable.id_ruang', $listAksesRuang);
            }
        }

        /*
        | ----------------------------------------------------------------------
        | Hook for manipulate row of index table html
        | ----------------------------------------------------------------------
        |
        */
        public function hook_row_index($column_index,&$column_value) {
            //Your code here
        }

        /*
        | ----------------------------------------------------------------------
        | Hook for manipulate data input before add data is execute
        | ----------------------------------------------------------------------
        | @arr
        |
        */
        public function hook_before_add(&$postdata) {
            //Your code here

        }

        /*
        | ----------------------------------------------------------------------
        | Hook for execute command after add public static function called
        | ----------------------------------------------------------------------
        | @id = last insert id
        |
        */
        public function hook_after_add($id) {
            //Your code here

        }

        /*
        | ----------------------------------------------------------------------
        | Hook for manipulate data input before update data is execute
        | ----------------------------------------------------------------------
        | @postdata = input post data
        | @id       = current id
        |
        */
        public function hook_before_edit(&$postdata,$id) {
            //Your code here

        }

        /*
        | ----------------------------------------------------------------------
        | Hook for execute command after edit public static function called
        | ----------------------------------------------------------------------
        | @id       = current id
        |
        */
        public function hook_after_edit($id) {
            //Your code here

        }

        /*
        | ----------------------------------------------------------------------
        | Hook for execute command before delete public static function called
        | ----------------------------------------------------------------------
        | @id       = current id
        |
        */
        public function hook_before_delete($id) {
            //Your code here

        }

        /*
        | ----------------------------------------------------------------------
        | Hook for execute command after delete public static function called
        | ----------------------------------------------------------------------
        | @id       = current id
        |
        */
        public function hook_after_delete($id) {
            //Your code here

        }

        public function getDetail($id)
        {
            $data['asset'] = $this->findAssetOrFail($id);
            return view('asset-extracomptable/page-detail', $data);
        }

        public function getAdd()
        {
            $id_gedung = prev_input('id_gedung');
            $lantai = prev_input('lantai');
            $id_jenis = prev_input('id_jenis');

            $data['page_title'] = "Add Asset Extra Comptable";
            $data['options_gedung'] = $this->getOptionsGedung();
            $data['options_jenis'] = $this->getOptionsJenis();
            $data['options_status'] = $this->getOptionsStatusExtracomptable();
            if ($id_gedung) {
                $data['options_lantai'] = $this->getOptionsLantai($id_gedung);
                if ($lantai) {
                    $data['options_ruang'] = $this->getOptionsRuang($id_gedung, $lantai);
                }
            }
            if ($id_jenis) {
                $data['options_subjenis'] = $this->getOptionsSubJenis($id_jenis);
            }
            $this->cbLoader();
            return view('asset-extracomptable.form-add', $data);
        }

        public function getEdit($id)
        {
            $asset = AssetExtracomptable::findOrFail($id);

            $data['page_title'] = "Edit Asset Extra Comptable";
            $data['asset'] = $asset;
            $data['options_gedung'] = $this->getOptionsGedung();
            $data['options_jenis'] = $this->getOptionsJenis();
            $data['options_status'] = $this->getOptionsStatusExtracomptable();
            $data['options_lantai'] = $this->getOptionsLantai($asset->id_gedung);
            $data['options_ruang'] = $this->getOptionsRuang($asset->id_gedung, $asset->lantai);
            $data['options_subjenis'] = $this->getOptionsSubJenis($asset->id_jenis);
            $this->cbLoader();
            return view('asset-extracomptable.form-edit', $data);
        }

        //By the way, you can still create your own method in here... :)


    }
