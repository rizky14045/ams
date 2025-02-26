<?php namespace App\Http\Controllers;

use App\Models\CheckoutInventory;
use App\Models\User;
use App\Traits\GetMasterOptions;

	use Session;
	use Request;
	use DB;
	use CRUDBooster;

	class AdminCheckoutInventoryController extends \crocodicstudio\crudbooster\controllers\CBController {

        use GetMasterOptions;

	    public function cbInit() {

			# START CONFIGURATION DO NOT REMOVE THIS LINE
			$this->title_field = "id";
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
			$this->button_import = false;
			$this->button_export = false;
			$this->table = "checkout_inventory";
			# END CONFIGURATION DO NOT REMOVE THIS LINE

			# START COLUMNS DO NOT REMOVE THIS LINE
			$this->col = [];
			$this->col[] = ["label"=>"Kode Checkout","name"=>"kd_checkout"];
			$this->col[] = ["label"=>"Tanggal","name"=>"tanggal"];
			$this->col[] = ["label"=>"Gedung","name"=>"id_gedung","join"=>"gedung,nama"];
			$this->col[] = ["label"=>"Lantai","name"=>"lantai"];
			$this->col[] = ["label"=>"Ruang","name"=>"id_ruang","join"=>"ruang,nama_ruang"];
			$this->col[] = ["label"=>"Nik Karyawan","name"=>"nik_karyawan"];
            # END COLUMNS DO NOT REMOVE THIS LINE
            $this->col[] = [
                "label" => "Status",
                "name" => "approved_at",
                "width" => 100,
                "callback" => function($row) {
                    if ($row->approved_at) {
                        return "<span class='label label-success'>approved</span>";
                    } else {
                        return "<span class='label label-default'>pending</span>";
                    }
                }
            ];

			# START FORM DO NOT REMOVE THIS LINE
			$this->form = [];
			$this->form[] = ['label'=>'Kode Checkout','name'=>'kd_checkout','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Tanggal','name'=>'tanggal','type'=>'date','validation'=>'required|date','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Gedung','name'=>'id_gedung','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-10','datatable'=>'gedung,nama'];
			$this->form[] = ['label'=>'Lantai','name'=>'lantai','type'=>'number','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Ruang','name'=>'id_ruang','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-10','datatable'=>'ruang,nama_ruang'];
			$this->form[] = ['label'=>'Nik Karyawan','name'=>'nik_karyawan','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			# END FORM DO NOT REMOVE THIS LINE

			# OLD START FORM
			//$this->form = [];
			//$this->form[] = ["label"=>"Kd Checkout","name"=>"kd_checkout","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Tanggal","name"=>"tanggal","type"=>"date","required"=>TRUE,"validation"=>"required|date"];
			//$this->form[] = ["label"=>"Gedung","name"=>"id_gedung","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"gedung,nama"];
			//$this->form[] = ["label"=>"Lantai","name"=>"lantai","type"=>"number","required"=>TRUE,"validation"=>"required|integer|min:0"];
			//$this->form[] = ["label"=>"Ruang","name"=>"id_ruang","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"ruang,nama_ruang"];
			//$this->form[] = ["label"=>"Nik Karyawan","name"=>"nik_karyawan","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			# OLD END FORM

			/*
	        | ----------------------------------------------------------------------
	        | Sub Module
	        | ----------------------------------------------------------------------
			| @label          = Label of action
			| @path           = Path of sub module
			| @foreign_key 	  = foreign key of sub table/module
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
	        | @color 	   = Default is primary. (primary, warning, succecss, info)
	        | @showIf 	   = If condition when action show. Use field alias. e.g : [id] == 1
	        |
	        */
	        $this->addaction = array();
            $this->addaction[] = [
                'label' => 'Approve',
                'url' => route('checkout-inventory::post-approve', null).'/[id]',
                'icon' => 'fa fa-check',
                'color' => 'success btn-approve',
                'showIf' => "![approved_at]"
            ];


	        /*
	        | ----------------------------------------------------------------------
	        | Add More Button Selected
	        | ----------------------------------------------------------------------
	        | @label       = Label of action
	        | @icon 	   = Icon from fontawesome
	        | @name 	   = Name of button
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
	        $this->script_js = NULL;


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
                $query->where('id', 0);
            } else {
                $query->whereIn('id_ruang', $listAksesRuang);
            }

            $query->where('kd_checkout', 'like', 'CI%');
	    }

        public function getIndex()
        {
            // I know it is not the way it should be
            // But I'm too lazy to learn how their controller works :p
            view()->composer('crudbooster::admin_template', function($view) {
                $view->with('bottom_views', [
                    'checkout-inventory.modal-approver' => []
                ]);
            });

            return parent::getIndex();
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

        public function getAdd()
        {
            $id_gedung = prev_input('id_gedung');
            $lantai = prev_input('lantai');
            $data['options_karyawan'] = $this->getOptionsKaryawan();
            $data['options_gedung'] = $this->getOptionsGedung();
            if ($id_gedung) {
                $data['options_lantai'] = $this->getOptionsLantai($id_gedung);
                if ($lantai) {
                    $data['options_ruang'] = $this->getOptionsRuang($id_gedung, $lantai);
                }
            }

            $data['kd_checkout'] = CheckoutInventory::generateKodeCheckout();
            $this->cbLoader();
            return view('checkout-inventory.form-add', $data);
        }

        public function getEdit($id)
        {
            $checkout = CheckoutInventory::findOrFail($id);
            $data['checkout'] = $checkout;
            $data['options_karyawan'] = $this->getOptionsKaryawan();
            $data['options_gedung'] = $this->getOptionsGedung();
            $data['options_lantai'] = $this->getOptionsLantai($checkout->id_gedung);
            $data['options_ruang'] = $this->getOptionsRuang($checkout->id_gedung, $checkout->lantai);
            $data['list_items'] = $this->getListItems($checkout);
            $this->cbLoader();
            return view('checkout-inventory.form-edit', $data);
        }

        protected function getListItems(CheckoutInventory $checkout)
        {
            return $checkout->items()->with(['asset'])->orderBy('id', 'asc')->get()->map(function($item) {
                $asset = $item->asset;
                return [
                    'id_asset' => $asset->id,
                    'kd_asset' => $asset->kd_asset,
                    'nama_asset' => $asset->nama_asset,
                    'kategori' => $asset->kategori->toArray(),
                    'jumlah' => (int) $item->jumlah,
                    'note' => $item->note
                ];
            })->toArray();
        }



	    //By the way, you can still create your own method in here... :)


	}
