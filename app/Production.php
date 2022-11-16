<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\CalculPolice;
    
class Production extends Model
{
   use CalculPolice;

    protected $table = 'gdf_prod';

    // return table Name 
    public static function getTableName()
    {
        return with(new static)->table;
    }


    protected $fillable = ['POL_QTC','POL_BRN', 'POL_CLS', 'POL_EFFET', 'POL_EXPIRATION', 'POL_SOUSCRIPTION', 'POL_REF', 'POL_NUM', 'POL_NUM_AA', 'POL_INS_NAME', 'POL_PRIME_TOTAL', 'POL_PRIME_NETTE', 'POL_PRIME_TVA', 'POL_PRIME_REDUCTION', 'POL_CP', 'POL_FGA','POL_TP', 'POL_MAJORATION', 'POL_TG', 'POL_TD', 'POL_IMPORT_ID','commGestion','commApport','commMHT','commTVA','commTotal'];

	public function recalculPrimeTtlTva($value='')
	{
		return ['calcul_TVA' => $this->RecalculTvaProd_Class_PN_CP( $this->POL_CLS,
																	$this->POL_PRIME_NETTE,
																	$this->POL_CP,
																	$this->POL_PRIME_TVA),
				'calcul_PrimeTotal' => $this->RecalculPrimeTtlProd_Class_PN_CP_Tva($this->POL_CLS,
																	$this->POL_PRIME_NETTE,
																	$this->POL_CP,
																	$this->POL_PRIME_TVA,
																	$this->POL_FGA+$this->POL_TG+$this->POL_TD+$this->POL_FGA ,
																	$this->POL_PRIME_TOTAL)];
	}
    
}
