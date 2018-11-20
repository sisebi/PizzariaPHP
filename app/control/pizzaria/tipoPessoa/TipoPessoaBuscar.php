<?php
use Adianti\Base\TStandardList;
use Adianti\Widget\Form\TEntry;
use Adianti\Wrapper\BootstrapFormBuilder;
use Adianti\Widget\Form\TLabel;
use Adianti\Registry\TSession;
use Adianti\Control\TAction;
use Adianti\Wrapper\BootstrapDatagridWrapper;
use Adianti\Widget\Wrapper\TQuickGrid;
use Adianti\Widget\Container\TPanelGroup;
/**
 * @Eliezer
 */
class TipoPessoaBuscar extends TStandardList{
    protected $form;
    protected $base = 'db_sistema';
    protected $datagrid;
            
    function __construct() {
        parent::__construct();
        parent::setDatabase($this->base);
        parent::setActiveRecord('TipoPessoaModel');
        parent::setFilterField('nome');
        
        $this->form = new BootstrapFormBuilder('frmTipoPessoa_buscar');
        $this->form->setFormTitle('Buscar Tipo Pessoa');
        
        $nome = new TEntry('nome');
            $nome->forceUpperCase();
            
        $this->form->addFields([new TLabel('Descrição')],[$nome]);  
        
        $this->form->addAction('Buscar', new TAction(array($this,'onSearch')),'fa:search');
        $this->form->addAction('Novo', new TAction(array('TipoPessoaForm','onEdit')),'fa:plus-square green');
        

        $grid = new TQuickGrid();
        $grid->addQuickColumn('Codigo', 'id', 'left', '25%', new TAction(array($this,'onReload')), array('order','id'));
        $grid->addQuickColumn('Nome', 'nome', 'left','75%' , new TAction(array($this,'onReload')), array('order','nome'));
        
        $grid->addQuickAction('Editar', new TDataGridAction(array('TipoPessoaForm','onEdit')), 'id', 'fa:pencil-square-o blue fa-lg');
        $grid->addQuickAction('Deletar', new TDataGridAction(array($this,'onDelete')), 'id','fa:trash-o red fa-lg');
        
        $grid->createModel();
        
        $this->datagrid = new BootstrapDatagridWrapper($grid);
        
        $this->pageNavigation = new TPageNavigation;
        $this->pageNavigation->setAction(new TAction(array($this, 'onReload')));
        $this->pageNavigation->setWidth($this->datagrid->getWidth());
        
        $panel = new TPanelGroup();
        $panel->add($this->datagrid);
        $panel->addFooter($this->pageNavigation);
        
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        $container->add($this->form);
        $container->add($panel);
        
        parent::add($container);
    }

}
