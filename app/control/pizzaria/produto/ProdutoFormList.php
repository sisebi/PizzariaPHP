<?php

use Adianti\Base\TStandardFormList;
use Adianti\Wrapper\BootstrapFormBuilder;
use Adianti\Widget\Form\TEntry;
use Adianti\Widget\Form\TLabel;
use Adianti\Control\TAction;
use Adianti\Wrapper\BootstrapDatagridWrapper;
use Adianti\Widget\Wrapper\TQuickGrid;
use Adianti\Widget\Datagrid\TDataGridAction;
use Adianti\Widget\Datagrid\TPageNavigation;
use Adianti\Registry\TSession;

/**
 * @Eliezer
 */
class ProdutoFormList extends TStandardFormList {

    protected $form;
    protected $datagrid;
    protected $pageNavigation;
    
    function __construct() {
        parent::__construct();
        parent::setDatabase('db_sistema');
        parent::setActiveRecord('ProdutoModel');

        $this->form = new BootstrapFormBuilder('form_Produto');
        $this->form->setFormTitle('Produto');

        $id = new TEntry('id');
        $id->setSize('30%');
        $id->setEditable(false);
        $descricao = new TEntry('descricao');
            $descricao->setSize('100%');
            $descricao->forceUpperCase();
        $vlrUn = new TEntry('vlrun');
            $vlrUn->setNumericMask(2, ',', '.', TRUE);
            $vlrUn->setSize('40%');

        $this->form->addFields([new TLabel('Codigo')], [$id]);
        $this->form->addFields([new TLabel('Descrição')], [$descricao]);
        $this->form->addFields([new TLabel('Valor Unitário')], [$vlrUn]);

        $btn = $this->form->addAction('Salvar', new TAction(array($this, 'onSave')), 'fa:floppy-o');
        $btn->class = 'btn btn-sm btn-primary';
        $this->form->addAction('Novo', new TAction(array($this, 'onClear')), 'fa:eraser red');
        $this->form->addAction('Voltar para listagem', new TAction(array('ProdutoBuscar','onReload')),'fa:table blue');

//        parent::setFilterField('descricao');
//        $descricao->setValue(TSession::getValue('ProdutoModel_descricao'));
        
        $col = new TQuickGrid();
        $col->addQuickColumn('Codigo', 'id', 'left', '25%', new TAction(array($this, 'onReload')), array('order', 'id'));
        $col->addQuickColumn('Descrição', 'descricao', 'left', '50%', new TAction(array($this, 'onReload')), array('order', 'descricao'));
        $col->addQuickColumn('Valor Unitário', 'vlrun', 'left', '25%', new TAction(array($this, 'onReload')), array('order', 'vlrun'));
        $col->addQuickAction('Editar', new TDataGridAction(array($this, 'onEdit')), 'id', 'fa:pencil-square-o blue fa-lg');
        $col->addQuickAction('Deletar', new TDataGridAction(array($this, 'onDelete')), 'id', 'fa:trash-o red fa-lg');

        $this->datagrid = new BootstrapDatagridWrapper($col);
        $this->datagrid->style = 'width: 100%';
        $this->datagrid->setHeight(320);

        $this->datagrid->createModel();

        $this->pageNavigation = new TPageNavigation;
        $this->pageNavigation->setAction(new TAction(array($this, 'onReload')));
        $this->pageNavigation->setWidth($this->datagrid->getWidth());

        $panel = new TPanelGroup;
        $panel->add($this->datagrid);
        $panel->addFooter($this->pageNavigation);

        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->add(new TXMLBreadCrumb('menu.xml', 'ProdutoBuscar'));
        $container->add($this->form);
        $container->add($panel);
        
        parent::add($container);
    }
    

}
