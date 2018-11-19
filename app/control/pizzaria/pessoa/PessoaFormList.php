<?php
use Adianti\Base\TStandardFormList;
/**
 * @Eliezer
 */
class PessoaFormList extends TStandardFormList{
    protected $form;     // registration form
    protected $datagrid; // listing
    protected $pageNavigation;
    protected $loaded;
    
    function __construct() {
        parent::__construct();
        parent::setDatabase('db_sistema_erp');
        parent::setActiveRecord('PessoaModel');
        
        $author_id         = new TDBSeekButton('author_id', 'library', $this->form->getName(), 'Author', 'name', 'author_id', 'author_name');
    }

    
    
}
