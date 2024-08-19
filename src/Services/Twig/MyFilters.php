<?php

namespace App\Services\Twig;

use Twig\TwigFilter;
use Twig\Extra\Intl\IntlExtension;
use Twig\Extension\AbstractExtension;

class MyFilters extends AbstractExtension{
    public function getFilters(){
        return [
            new TwigFilter('actif', [$this,'getActif'])
        ];
    }


    public function getActif(bool $etat):string 
    {
        if($etat == 1){
            return "Oui";
        }
        else{
            return "Non";
        }
        
    }
}