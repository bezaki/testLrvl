<?php

namespace App\Http\Controllers\Report;

use Carbon\Carbon;
use PdfReport;
use ExcelReport;
use App\classs;
use App\Production;
use App\Report\PdfTopTitle;
use App\Report\FactureDuMois;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\NombreEnLettre;

class FactureDuMoisController extends Controller
{
    
    use NombreEnLettre;
     public function __construct()
    {
      $this->middleware('auth');
     
    }

    public function primes()
    {	        
    	$this->breadcrumb_lis_append(['title' => 'Report' , 'url' => 'report.FactureDuMois' ]);
    	$breadcrumb_lis =  $this->breadcrumb_lis ;
    	 $classes=classs::All();
    	return view('report.FactureDuMois', compact('breadcrumb_lis','classes'));
    }
    

       public function primesFile(Request $request)
    {	     
    $request->validate([
            'souscript_du' => 'bail|required|date',
            // 'souscript_au' => 'bail|required|date',
            // 'classe' => 'bail|nullable|numeric|exists:class,code',
            // 'branche' => 'bail|nullable|numeric|exists:branche,code',
            'type_report' => 'bail|required|in:PDF',
            ]); 

	//preparation des parametres du report

	// preparation de la requete
     $fromDate = Carbon::parse($request->souscript_du)->startOfMonth()->toDateString();
      $toDate = Carbon::parse($fromDate)->endOfMonth()->toDateString();
    // $toDate = $request->souscript_au;
    
    //where des classe/ branche de la police
    $whereClasse = array();
    if ( isset($request->classe) && !empty($request->classe) ) $whereClasse[]= ["class" ,$request->classe ];
    if ( isset($request->branche) && !empty($request->branche) ) $whereClasse[]= ["branche" ,$request->branche ];

    // $whereClasse[]= ["souscription",'>=' ,$fromDate ];
    // $whereClasse[]= ["souscription" ,'<=',$toDate ];
    
    $whereClasse[]= ['dater' ,'=',$request->souscript_du ];

    // $sortBy = $request->input('sort_by');
    // FactureDuMois
    $queryBuilder =  FactureDuMois::select( [ 'CLS', 'code_branche', \DB::raw( 'CONCAT("Automobile(" , branche, ")" ) AS branche')  , 'primenette', 'commapport', 'commgestion', 'commtotal', 'dater' ])
    					// ->innerJoin() 
                        ->where($whereClasse)
                        ->where('CLS', '11')
                        // ->orderBy('souscription','asc')
                         ->union(FactureDuMois::select([ 'CLS', 'code_branche', 'branche' , 'primenette', 'commapport', 'commgestion', 'commtotal', 'dater' ])
					    					// ->innerJoin() 
					                        ->where($whereClasse)
					                        ->where('CLS','!=' ,'11')
					                    )
                        ->orderBy('code_branche','asc')
                        ;
    $TotalComm =  FactureDuMois::where($whereClasse)->sum( 'commtotal' );
	// ->innerJoin() 
   
     // dd( $queryBuilder->toSql(), $whereClasse);
	// dd($TotalComm );
	//Title 
	$duDate =Carbon::parse($request->souscript_du)->startOfMonth()->locale('fr');
	// $duDate->locale('fr');
	// $duDate->startOfMonth();
	$title = 'FACTURE N°' .  $duDate->isoFormat('MM') .' '. mb_strtoupper($duDate->isoFormat('MMMM YYYY'), 'UTF-8')  ; // Report title

    $meta = [ // For displaying filters description on header
        ' ' => ' Du '.$fromDate. ' Au ' . $toDate, 
        // 'Classe' =>  $request->classe?? 'Toutes les Classes',
        // 'Branche' =>  $request->branche?? 'Toutes les branches'
    ];

	// preparation des colonnes
 
    $columns = [ // Set Column to be displayed
    //'CLS', 'code_branche', 'branche' , 'primenette', 'commapport', 'commgestion', 'commtotal' ,'dater'

        "Code branche" => 'code_branche',
        "Branche d'Assurance"		   	 => 'branche', 
        'Prime NETTE'		 => 'primenette',
		'Commissions Gestion'	 => 'commgestion',
		'Commissions Aport'		 => 'commapport',
		'Total Hors Taxes'				 => 'commtotal'
        // ,
        // 'Status' => function($result) { // You can do if statement or any action do you want inside this closure
        //     return ($result->balance > 100000) ? 'Rich Man' : 'Normal Guy';
        // }
    ];   
	// ['classText'  'billSumText'   'classSum'  'billSumVal']
    $sumBillArray = [
    					[
    					 'classText'	=> null,
    					 'billSumText'	=> 'Total des Commissions en Hors Taxes',   
    					 'classSum'		=> null,  
    					 'billSumVal'	=>  number_format($TotalComm, 2, '.', ' '),
    					],
    					[
    					 'classText'	=> null,
    					 'billSumText'	=> 'T.V.A 19%',   
    					 'classSum'		=> null,  
    					 'billSumVal'	=>  number_format( ($TotalComm * 0.19), 2, '.', ' '),
    					],
    					[
    					 'classText'	=> null,
    					 'billSumText'	=> 'Montant Total en T.T.C',   
    					 'classSum'		=> null,  
    					 'billSumVal'	=>  number_format(($TotalComm * 1.19), 2, '.', ' '),
    					],
    				];


	$valeurChiffre = $this->valeurChiffreBill(number_format(($TotalComm * 1.19), 2, '.', ''));
	$agentText ="L'Agent Général";
	// separe

	    $method_name = 'displayReport'.$request->type_report;  // celon Type_report : appel à la fuuncton displayReportPDF ou displayReportExcel
	    	return $this->{$method_name}($request, $title, $meta, $queryBuilder, $columns,$sumBillArray, $valeurChiffre, $agentText);
	    	// return $this->displayReport($request);
	    } 


	public function displayReportExcel(Request $request, $title, Array $meta = [], $queryBuilder, $columns, $sumBillArray=[], $textBill='')
		{
			 // Generate Report with flexibility to manipulate column class even manipulate column value (using Carbon, etc).
	    return ExcelReport::of($title, $meta, $queryBuilder, $columns)
	    				->showNumColumn(false) //pour ne pas afficger le N° de la ligne
	                    // ->editColumn('DATE', [ // Change column class or manipulate its data for displaying to report
	                    //                 'class' => 'right'
	                    // 	])
	                    ->editColumns(['P.NETTE','P.TOTALE','AV. ANTERIEURES','AV. DU MOIS','RESTE DUE'], [ // Mass edit column
	                        'class' => 'right bold'
	                    ])
	                    ->showTotal([ // Used to sum all value on specified column on the last table (except using groupBy method). 'point' is a type for displaying total with a thousand separator
	                         	'P.TOTALE' 			=> 'point',// if you want to show dollar sign ($) then use 'Total Balance' => '$'
								'P.NETTE' 			=> 'point',
								'AV. ANTERIEURES' 	=> 'point',
								'AV. DU MOIS' 		=> 'point',
								'RESTE DUE' 		=> 'point',
								'C.P'		=> 'point',
								'TVA19%'	=> 'point',
								'FGA3%'		=> 'point',
								'TG'		=> 'point',
								'TP'		=> 'point',
								'TD'		=> 'point',
	                    ])
	                    // ->limit(20) // Limit record to be showed
	                    ->download('Avance Prime Non Payee '. Carbon::now()->format('Ymd H:i:s'));
	                     //->stream(); // other available method: download('filename') to download pdf / make() that will producing DomPDF / SnappyPdf instance so you could do any other DomPDF / snappyPdf method such as stream() or download()
	}

	public function displayReportPDF(Request $request, $title, Array $meta = [], $queryBuilder, $columns, $sumBillArray=[], $textBill='', $agentText='')
	{


	    // Generate Report with flexibility to manipulate column class even manipulate column value (using Carbon, etc).
	     $s_title ='';
	    $tab = new PdfTopTitle;
	 	$tab= $tab->getReportLiges('billReport')->select(['id','libelle','ordr'])->get();  
	    $title =  view('report.PDFtopTitle' ,compact('title','s_title','tab')) ;
	    return PdfReport::of($title, $meta, $queryBuilder, $columns)
	    				->bill() // facture
	    				->sumBillArray($sumBillArray)
	    				->textBill($textBill)
	    				->agentText($agentText) 
	    				// ->groupBy('dater') // show total group class
	    				// ->editColumn('dater', [
	        //                 'class' => 'width0' // pour ne pas affiché cette colone => width is 0px
	        //            		 ])
	    				
	    				->showMeta(false)
	        			->showNumColumn(true) //pour ne pas afficger le N° de la ligne
	     				//"Code branche" 
						// "Branche d'Assurance"		   	 ,
						// 'Prime NETTE'		 ,
						// 'Commissions Gestion'	 ,
						// 'Commissions Aport'		 ,
						// 'Total Hors Taxes'				 ,
	                    ->editColumns(["Code branche"], [ // Change column class or manipulate its data for displaying to report
	                        'class' => 'center md-row '
	                    ]) 
	                    ->editColumn("Branche d'Assurance", [
	                        'class' => 'police-width center'
	                   		 ])
	                    ->editColumns([ 'Prime NETTE',
										'Commissions Gestion' ,
										'Commissions Aport' ,
										'Total Hors Taxes'], [
	                        'class' => 'lg-row right pr-3'
	                   		 ])
	                    ->setCss([
				                '.police-width' => 'width: 270px !important;',
	                            '.small-row'    => 'width: 60px !important; ',
				                '.md-row'	=> 'width: 100px !important; ',
	                            '.lg-row'   => 'width: 140px !important; ',
	                            '.pr-3'   	=> 'padding-right: 3px !important; ',

				            ])
	                    ->showTotal([ // Used to sum all value on specified column on the last table (except using groupBy method). 'point' is a type for displaying total with a thousand separator
	                            'Prime NETTE'  => 'point',// if you want to show dollar sign ($) then use 'Total Balance' => '$'
	                            'Commissions Gestion'=> 'point',
								'Commissions Aport'  => 'point',
								'Total Hors Taxes' 			 => 'point',
	                   		 ])
	                    ->setOrientation('landscape')
	                    // ->setPaper('a3')
	                    // ->limit(20) // Limit record to be showed
	                   // ->download('Primes Impayées ');
	                     ->stream(); // other available method: download('filename') to download pdf / make() that will producing DomPDF / SnappyPdf instance so you could do any other DomPDF / snappyPdf method such as stream() or download()
	}


}
