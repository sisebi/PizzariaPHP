<?php
use Adianti\Base\TStandardList;
use Adianti\Widget\Form\TEntry;
use Adianti\Wrapper\BootstrapFormBuilder;
use Adianti\Widget\Form\TLabel;
use Adianti\Registry\TSession;
use Adianti\Control\TAction;
use Adianti\Wrapper\BootstrapDatagridWrapper;
use Adianti\Widget\Wrapper\TQuickGrid;
/**
 * @Eliezer
 */
class ProdutoBuscar extends TStandardList{
    protected $form;
    protected $pagina;
    protected $datagrid;
    
    function __construct() {
        parent::__construct();
        parent::setDatabase('db_sistema');
        parent::setActiveRecord('ProdutoModel');
        parent::setFilterField('descricao');

        $this->form = new BootstrapFormBuilder('frm_produto_buscar');
        $this->form->setFormTitle('Buscar Produto');
        
        $descricao = new TEntry('descricao');
            $descricao->setValue(TSession::getValue('ProdutoModel_descricao'));
            $descricao->setSize('100%');
        
        $this->form->addFields([new TLabel('Descrição')],[$descricao]);
        //filtro->onSearch
        $this->form->addAction('Buscar', new TAction(array($this, 'onSearch')),'fa:search');
        $this->form->addAction('Novo', new TAction(array('ProdutoForm','onEdit')),'fa:plus-square green');
        
        
        $this->datagrid = new BootstrapDatagridWrapper(new TQuickGrid());
        $this->datagrid->style = 'width: 100%';
        $this->datagrid->setHeight(320);
        
        $this->datagrid->addQuickColumn('Codigo', 'id', 'right', 100, new TAction(array($this, 'onReload')), array('order', 'id'));
        $this->datagrid->addQuickColumn('Descrição', 'descricao', 'left', NULL, new TAction(array($this, 'onReload')), array('order', 'descricao'));
        $this->datagrid->addQuickColumn('Valor unitário', 'vlrun', 'right', 100, new TAction(array($this, 'onReload')), array('order', 'vlrun'));

        $this->datagrid->addQuickAction('Editar', new TDataGridAction(array('ProdutoForm', 'onEdit')), 'id', 'fa:pencil-square-o blue fa-lg');
        $this->datagrid->addQuickAction('Deletar', new TDataGridAction(array($this, 'onDelete')), 'id', 'fa:trash-o red fa-lg');
        
        $this->datagrid->createModel();
        
        $this->pageNavigation = new TPageNavigation;
        $this->pageNavigation->setAction(new TAction(array($this, 'onReload')));
        $this->pageNavigation->setWidth($this->datagrid->getWidth());
        
        $panel = new TPanelGroup;
        $panel->add($this->datagrid);
        $panel->addFooter($this->pageNavigation);
        
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        $container->add($this->form);
        $container->add($panel);
        
        parent::add($container);
        
    }
    
    public function buscar() {
        try {
            TTransaction::open($this->database);
            $values = $this->form->getData();
            $criterio = new TCriteria();
            $criterio->add(new TFilter('descricao', 'like', $values->descricao.'%'));
            $repositorio = new TRepository('ProdutoModel');
            $listaPessoa = $repositorio->load($criterio);
//            foreach ($listaPessoa as $valor) {
//                echo "NOMES :".$valor->descricao.'</br>';
//            }
            $this->form->setData($values);
            
            $this->datagrid->clear();
            if ($listaPessoa)
            {
                foreach ($listaPessoa as $object)
                {
                    $this->datagrid->addItem($object);
                }
            }
        } catch (Exception $ex) {
            new TMessage('error', 'Erro ao filtar :'.$ex->getMessage());
        } finally {
            TTransaction::close();
        }
    }

}
