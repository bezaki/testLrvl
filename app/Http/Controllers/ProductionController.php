<?php

namespace App\Http\Controllers;

use App\Production;
use Illuminate\Http\Request;
use App\Traits\CalculPolice;
use Illuminate\Support\Facades\Validator;


class ProductionController extends Controller
{
    use CalculPolice;

    public function __construct()
    {
      $this->middleware('auth');
      $this->breadcrumb_lis_append(['title' => 'Productions' , 'url' => 'production.index' ]);
    }

    public function index()
    {	        
      
    	$breadcrumb_lis =  $this->breadcrumb_lis ;
      return view('production.index', compact('breadcrumb_lis'));
    }

    public function production_dataTable(Request $request)
    {       $whereCdt =array();
            if (isset($request->file_id) && !empty($request->file_id)  ) {
                $whereCdt[]= ["POL_IMPORT_ID" ,$request->file_id ]; 
            }
    		$t_prod =Production::getTableName();
            $datas = Production::select("$t_prod.id", 'pol_qtc', 'pol_brn', 'pol_cls', 'pol_effet', 'pol_expiration', 'pol_souscription', 'pol_ref', 'pol_num', 'pol_num_aa', 'pol_ins_name', 'pol_prime_total', 'pol_prime_nette', 'pol_prime_tva', 'pol_prime_reduction', 'pol_cp', 'pol_fga', 'pol_majoration', 'pol_tg', 'pol_td','pol_tp', 'pol_import_id')
                        ->where($whereCdt);
            	// dd($datas->get());
            return datatables()->of($datas)
                ->editColumn('pol_import_id', function($data){
                     
                      return  (is_null($data->pol_import_id) || empty($data->pol_import_id) ) ? "<h5><span class='badge badge-default'>Ajouté</span></h5>"
                        :"<h5><span class='badge badge-default'>Importé</span></h5>" ;
                })
                ->editColumn('pol_effet', function($data){
                     
                      return $data->pol_effet;
                })
                ->addColumn('action', function ($data) {
                    $prodId= $data->id;
                    return view('production.actionTable', compact('prodId'));
	             //    return '<a href="' . route('production.show', $data->id) . '" class="badge badge-primary waves-effect waves-light" title="détail"><i class="ion ion-eye"></i> 
              //       </a>
              //       <a href="' . route('production.showEdit', $data->id) . '" class="badge badge-primary waves-effect waves-light" title="Modifier"><i class="fa fa-edit"></i> 
              //       </a>';

    		        // $t ='<button title="Supprimer" class="btn btn-sm btn-danger" onclick="desactiver(' .$data->id. ')"><i class="typcn typcn-thumbs-down"></i></button>
    		        // ';  
				})
                ->rawColumns(['pol_import_id','pol_effet','action'])
            	->make(true);

    } 

   public function showEdit(Production $production)
    {   
        $breadcrumb_lis = $this->breadcrumb_lis;
        $breadcrumb_lis = $this->breadcrumb_lis_append(['title' => 'Modifier ('.$production->id.')' , 'url' => '/productions/'.$production->id.'/edit']);

        $Edit = 1;
        $calculCommission = $this->calculCommTvaTotal($production->POL_PRIME_NETTE , $production->POL_BRN);
        return view('production.edit', compact('breadcrumb_lis','production','Edit','calculCommission'));
    }
public function info(Production $production)
    {  
        return $production;
    }    
public function show(Production $production)
    {   
        $breadcrumb_lis = $this->breadcrumb_lis;
        $breadcrumb_lis = $this->breadcrumb_lis_append(['title' => 'Voir ('.$production->id.')' , 'url' => '/productions/show/'.$production->id]);
        $Edit = false;
        return view('production.show', compact('breadcrumb_lis','production','Edit'));
    }    
	
public function update(Request $request,Production $production )
    {
          // // validate
          // ['POL_QTC','POL_BRN', 'POL_CLS', 'POL_REF', 'POL_NUM', 'POL_NUM_AA', 'POL_EFFET', 'POL_EXPIRATION', 'POL_SOUSCRIPTION', 'POL_INS_NAME', 'POL_PRIME_TOTAL', 'POL_PRIME_NETTE', 'POL_PRIME_TVA', 'POL_PRIME_REDUCTION', 'POL_CP', 'POL_FGA','POL_TP', 'POL_MAJORATION', 'POL_TG', 'POL_TD', 'POL_IMPORT_ID','commGestion','commApport','commMHT','commTVA','commTotal']; 
          $request->validate([
            'POL_EFFET' => 'bail|date',
            'POL_EXPIRATION' => 'bail|date',
            'POL_SOUSCRIPTION' => 'bail|date',
            'POL_INS_NAME' => 'bail|required|max:180',
            'POL_PRIME_TOTAL' => 'bail|required|numeric',
            'POL_PRIME_NETTE' => 'bail|required|numeric',
            'POL_PRIME_TVA' => 'bail|required|numeric',
            // 'POL_PRIME_REDUCTION' => '',
            // 'POL_CP' => '',
            // 'POL_FGA' => '',
            // 'POL_TP' => '',
            // 'POL_MAJORATION' => '',
            // 'POL_TG' => '',
            // 'POL_TD' => '',
            // 'POL_IMPORT_ID' => '',
            // 'commGestion' => '',
            // 'commApport' => '',
            // 'commMHT' => '',
            // 'commTVA' => '',
            // 'commTotal' => ''
            ]); 
        try {
          $production->update($request->all());
          return redirect()->route('production.showEdit',$production->id)
                           ->withSuccess("La police ". $production->POL_REF ." a été modifiée");
        } catch (\Exception $e){
            return redirect()->route('production.showEdit',$production->id)
                             ->withErrors(['erreurs' =>  $e->getMessage() ]);
        }
        
    }

public function ShowAdd()
    {   
        $breadcrumb_lis = $this->breadcrumb_lis;
        $breadcrumb_lis = $this->breadcrumb_lis_append(['title' => 'Ajouter' , 'url' => 'production.add']);
        return view('production.ajouter', compact('breadcrumb_lis'));
    }     
    
public function store(Request $request )
    {
          // // validate
          // ['POL_QTC','POL_BRN', 'POL_CLS', 'POL_REF', 'POL_NUM', 'POL_NUM_AA', 'POL_EFFET', 'POL_EXPIRATION', 'POL_SOUSCRIPTION', 'POL_INS_NAME', 'POL_PRIME_TOTAL', 'POL_PRIME_NETTE', 'POL_PRIME_TVA', 'POL_PRIME_REDUCTION', 'POL_CP', 'POL_FGA','POL_TP', 'POL_MAJORATION', 'POL_TG', 'POL_TD', 'POL_IMPORT_ID','commGestion','commApport','commMHT','commTVA','commTotal']; 
          $request->validate([
            'POL_QTC' => 'bail|required|numeric',
            'POL_BRN' => 'bail|required',
            'POL_CLS' => 'bail|required',
            'POL_REF' => 'bail|required|max:50|unique:gdf_prod,POL_REF',
            'POL_NUM' => 'bail|required|numeric',
            'POL_NUM_AA' => 'bail|max:10',
            'POL_EFFET' => 'bail|date',
            'POL_EXPIRATION' => 'bail|date',
            'POL_SOUSCRIPTION' => 'bail|date',
            'POL_INS_NAME' => 'bail|required|max:180',
            'POL_PRIME_TOTAL' => 'bail|required|numeric',
            'POL_PRIME_NETTE' => 'bail|required|numeric',
            'POL_PRIME_TVA' => 'bail|required|numeric',
            // 'POL_PRIME_REDUCTION' => '',
            // 'POL_CP' => 'bail|required|numeric',
            // 'POL_FGA' => 'bail|required|numeric',
            // 'POL_TP' => 'bail|required|numeric',
            // 'POL_MAJORATION' => '',
            // 'POL_TG' => 'bail|required|numeric',
            // 'POL_TD' => 'bail|required|numeric',
            // 'POL_IMPORT_ID' => '',
            // 'commGestion' => '',
            // 'commApport' => '',
            // 'commMHT' => '',
            // 'commTVA' => '',
            // 'commTotal' => ''
            ]); 
        try {
          $production = Production::create($request->all());
          return redirect()->route('production.index',$production->id)
                           ->withSuccess("La police ". $production->POL_REF ." a été Ajoutée");
        } catch (\Exception $e){
            return redirect()->route('production.add')
                             ->withErrors(['erreurs' =>  $e->getMessage() ]);
        }
        
    }

    
public function tauxCommBr(Request $request)
{       // return les taus Apport et gestion de la branche br
        return (array)$this->getCommissionBranche($request->br);
}
public function tauxTva(Request $request)
{       //return les tauw de tva (comm et prime)
    return (['tvaComm'=> $this->getTvaComm()->taux ,
                        'tvaProd'=> $this->getTvaProd()->taux ]) ;
}

public function deleteProductionId(Request $req)
{
   if (isset($req->file_id) && !empty($req->file_id)) {
       if($req->ajax()){
          $validator = Validator::make($req->all(), [
            'file_id' => 'bail|required|numeric|exists:gdf_prod,id'
            ]);
          if ($validator->fails()) {
            return Response()->JSON(['errors' => 'Erreur de données'],403);
            // return redirect('post/');
          }
          $prod = Production::findOrFail($req->file_id);
          // controle if we can delete the imported prod
          $refProd = $prod->POL_REF;
          $isDelFile = $this->isDeletedProd($prod);
          if($isDelFile['is'] =='deleted' ){
            $totalDeleted = $prod->delete();
            $data=['totalDeleted'=> $totalDeleted,
                   'file'        => $refProd
               ]; 
            return Response()->JSON(['status' => 'ok'
                                    ,'success'=>'Success'
                                    ,'msg'=>'La production a été supprimée avec successé',
                                    'data'=>$data],200);            
         }
         else{
            return Response()->JSON(['errors' => 'Impossible de supprimer La Production : '.$isDelFile['why']],403);   
         }
         return Response()->JSON(['errors' => 'Erreur, pas de données'],403);
         }

    }else{
       return Response()->JSON(['errors' => 'Erreur, pas de données'],403);
    }
}
public function isDeletedProd($prod='')
{
       if (auth()->user()->hasAnyPermission(['Production Delete'])){
          //Control....
           $rs = ['is'  => 'deleted' ,
                  'why' => '' 
                ];
       }else{
            $rs = ['is'  => 'nonDeleted',
                   'why' => 'Utilisateur non autorisé!'
                  ]  ;
       } 
       return $rs; 
}

}
