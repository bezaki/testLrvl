<?php

namespace App\Traits;

use App\tva;
use App\branche;
use App\commission;
use App\ParametreCalcul;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;


trait CalculPolice
{
// collection de TVA (id:1 => 19% et id:2 => 9%)
private $trait_tva; 
// collection de branche(code)et commission (apport et gestion) ['code','taux_apport','taux_gestion']
private $trait_commission;
// tableau de classe(code) à ne pas recalcul TVA 
private $trait_classeNcalcul=[];
private $commission_br;



//""""""""""""""""""""Init """"""""""""""""""""""""""""""
//fonction pour init et get  $trait_classeNcalcul
public function getClasseNcalcul()
    {
    	if(!$this->trait_classeNcalcul){
    		 $this->trait_classeNcalcul = ParametreCalcul::select('code','type')->where('etat',1)
    																				  ->where('option','NoTvaCalcul')
    																				  ->where('type','CL')
    																				  ->get()
    																				  ->pluck('code')
    																				  ->toArray();
    		 return $this->trait_classeNcalcul;

    	}else{
    		return $this->trait_classeNcalcul;
    	}
    }


//fonction pour init et get  $trait_tva
public function getTvas()
    {
    	if(!$this->trait_tva){
    		return $this->trait_tva = tva::select('id','taux')->whereIn('id',[1,2])->get();

    	}else{
    		return $this->trait_tva;
    	}
    }
//fonction pour init et get  $trait_commission
public function getCommissions()
    {
    	if(!$this->trait_commission){

    		return $this->trait_commission =DB::table('branche')
							            ->join('commission', 'branche.id', '=', 'commission.id_branche')
							            ->select('branche.code','taux_apport','taux_gestion')
							            ->get();
    	}else{
    		return $this->trait_commission;
    	}
    }

// fonction return une collection de {'code','taux_apport','taux_gestion'}
// de $branche from $this->trait_commission
// null si $branche n'existe pas
public function getCommissionBranche($branche='')   
	{
		return $this->commission_br = (!$this->commission_br || ($this->commission_br->code != $branche )) ?
                                $this->getCommissions()->first(function($item) use ($branche){
										    return $item->code == $branche;
										}): $this->commission_br;

   					// OR YOU can use the filter method
   					// 		->filter(function($item)use ($branche) {
		   			// 			 return $item->code == $branche;
								// })->first();
	}


//""""""""""""""""""""""""""""""""""""Calcul """"""""""""""""""""""""""""""
//""""""""""""""""""""""""""""""""""""Calcul Commission""""""""""""""""""""""""""""""

//return the Table [ 'comm_apport','comm_gestion'] //number_format($production->commGestion, 2,'.','')
public function calculCommission($prime , $branche)
	{   

	   return  ['comm_apport' =>  (float) number_format( $prime * ($this->getCommissionBranche($branche)?$this->getCommissionBranche($branche)->taux_apport :0), 2,'.','') ,
	   			'comm_gestion'=>  (float) number_format( $prime * ($this->getCommissionBranche($branche)?$this->getCommissionBranche($branche)->taux_gestion : 0), 2,'.','')
	   			];
	}

//return les commissions avec total  commission 
public function calculCommTotal($prime , $branche)
	{  
		$ct = $this->calculCommission($prime , $branche) ;
	   return  array_merge($ct , ['comm_total' => ($ct['comm_apport'] + $ct['comm_gestion']) ] );
	}

public function calculCommTvaTotal($prime , $branche)
{
        $tComm = $this->calculCommTotal($prime , $branche);
        $tComm = array_merge($tComm , ['commTVA'=> $this->calculTvaComm($tComm['comm_total']) ] );
        return array_merge($tComm , ['commTotal'=> $tComm['comm_total']+$tComm['commTVA'] ] );

}



//""""""""""""""""""""""""""""""""""""Calcul TVA et Prime """"""""""""""""""""""""""""""

//return the collection of TVA
public function getTauxTva($tva='')
	{
	   return $this->getTvas()->first(function($item) use ($tva){
										    return $item->id == $tva;
										});
	}
//return the collection of TVA Prod
public function getTvaProd($tva=1)
	{
	   return $this->getTauxTva($tva);
	}
//return the collection of TVA Commission
public function getTvaComm($tva=2)
	{
	   return $this->getTauxTva($tva);
	}

//return the collection of TVA Prod
public function calculTvaProd($prime , $tva=1)
	{  
	   return (double) number_format( $prime * $this->getTvaProd($tva)->taux ,2,'.','') ;
	}
//return the collection of TVA Commission
public function calculTvaComm($prime, $tva=2)
	{  
	   return  (float) number_format( $prime * $this->getTvaComm($tva)->taux ,2,'.','');
	}

//return la prime total prod
public function calculPrimeTotalProd($prime, $tva=1)
	{  
	   return $prime +  $this->calculTvaProd($prime,$tva) ;
	}
//return la prime total commission
public function calculPrimeTotalComm($prime, $tva=2)
	{  
	   return $prime +  $this->calculTvaComm($prime,$tva) ;
	}
//return la prime TVA total prod
public function RecalculTvaProd_Class_PN_CP($calssPolice,$prime,$cp,$primeTVA, $tva=1)
	{  
		if(in_array($calssPolice, $this->getClasseNcalcul() ) ){
			return $primeTVA;
		}else{
	   	return $this->calculTvaProd($prime + $cp, $tva) ;
		}
	}
//return la prime total prod
public function RecalculPrimeTtlProd_Class_PN_CP_Tva($calssPolice,$prime,$cp,$primeTVA,$timbres ,$primeTtl, $tva=1)
	{  
		if(in_array($calssPolice, $this->getClasseNcalcul() ) ){
			return $primeTtl;
		}else{
	   	return $prime+$cp+$timbres+$this->RecalculTvaProd_Class_PN_CP($calssPolice,$prime,$cp,$primeTVA, $tva) ;
		}
	}

//""""""""""""""""""""""""""""""""Branche""""""""""""""""""""""""""""""""""""""
//return the Branche from the Police's reference 
public function brancheFromRef($ref, $char=' ')
	{  
 		$brancheExplode = explode($char,  $ref);
	   return (string) $brancheExplode[2];
	}
}