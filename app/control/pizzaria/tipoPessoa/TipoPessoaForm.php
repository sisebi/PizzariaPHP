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
use Adianti\Base\TStandardForm;
/**
 * @Eliezer
 */
class TipoPessoaForm extends TStandardForm{
    protected $form;
    protected $base = 'db_sistema';
    
    function __construct(){
        parent::__construct();
        parent::setDatabase($this->base);
        parent::setActiveRecord('TipoPessoaModel');
        
        $this->form = new BootstrapFormBuilder('frmTipo_padrao');
        $this->form->setFormTitle('Tipo Pessoa');
        
        $id = new TEntry('id');
            $id->setSize('40%');
            $id->setEditable(false);
        $nome = new TEntry('nome');
            $nome->forceUpperCase();
        
        $this->form->addFields([new TLabel('Id')],[$id]);
        $this->form->addFields([new TLabel('Nome')],[$nome]);
        
        $this->form->addAction('Salvar', new TAction(array($this,'onSave')), 'fa:floppy-o');
        $this->form->addAction('Novo', new TAction(array($this,'onClear')), 'fa:eraser red');
        $this->form->addAction('Voltar para lista', new TAction(array('TipoPessoaBuscar','onReload')), 'fa:eraser red');
        
        $container = new TVBox();
        $container->style = 'width:100%';
        $container->add(new TXMLBreadCrumb('menu.xml', 'TipoPessoaBuscar'));
        $container->add($this->form);
        
        parent::add($container);
               
    }
    
}
