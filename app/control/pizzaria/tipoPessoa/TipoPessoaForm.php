<?php
use Adianti\Control\TPage;
use Adianti\Wrapper\BootstrapFormBuilder;
use Adianti\Widget\Form\TEntry;
use Adianti\Control\TAction;
use Adianti\Widget\Container\TVBox;
use Adianti\Widget\Util\TXMLBreadCrumb;
use Adianti\Widget\Dialog\TMessage;
use Adianti\Database\TTransaction;
use Adianti\Widget\Form\TLabel;
/**
 * @Eliezer
 */
class TipoPessoa extends TPage{
    protected $form;
    protected $base = 'db_sistema';
    
    function __construct(){
        parent::__construct();
        parent::setDatabase('db_sistema');
        parent::setActiveRecord('TipoPessoaModel');
        
               
    }
    
}
