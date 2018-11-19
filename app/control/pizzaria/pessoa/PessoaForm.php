<?php
use Adianti\Base\TStandardForm;
use Adianti\Wrapper\BootstrapFormBuilder;
use Adianti\Widget\Form\TEntry;
use Adianti\Widget\Form\TCombo;
/**
 * @Eliezer
 */
class PessoaForm extends TStandardForm{
    protected $form;
    
    function __construct() {
        parent::__construct();
        parent::setDatabase('db_sistema_erp');
        parent::setActiveRecord('PessoaModel');
        
        $this->form = new BootstrapFormBuilder('frm_pessoa');
        $this->form->setFormTitle('Cadastro de Pessoa');
        
        $id = new TEntry('id');
        $nome = new TEntry('nome');
        $cpf = new TEntry('cpf');
        $rg = new TEntry('rg');
//        $tipo = new Adianti\Widget\Form\TCombo($name)
    }

    
}
