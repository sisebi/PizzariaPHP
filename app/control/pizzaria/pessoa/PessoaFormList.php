<?php
use Adianti\Base\TStandardFormList;
/**
 * @Eliezer
 */
class PessoaFormList extends TStandardFormList{
    protected $form;     
    protected $datagrid; 
    protected $pageNavigation;
    protected $loaded;
    
    function __construct() {
        parent::__construct();
        parent::setDatabase('db_sistema_erp');
        parent::setActiveRecord('PessoaModel');
                
    }

    
    
}
