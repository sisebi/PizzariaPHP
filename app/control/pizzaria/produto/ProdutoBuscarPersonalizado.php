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
use Adianti\Wrapper\BootstrapDatagridWrapper;
use Adianti\Widget\Wrapper\TQuickGrid;
use Adianti\Widget\Datagrid\TPageNavigation;
/**
 * @Eliezer
 */
class ProdutoBuscarPersonalizado extends TPage{
    protected $form;
    protected $base = 'db_sistema';
    protected $datagrid;
    protected $pageNavigation;
            
    function __construct() {
        parent::__construct();
        
        $this->form = new BootstrapFormBuilder('frmProdutoBuscarPersonalizado');
        $this->form->setFormTitle('Buscar Produto Personalizado');
        
        $descricao = new TEntry('descricao');
//        $descricao->setValue(TSession::getValue('ProdutoModel_descricao'));
        
        $this->form->addFields([new TLabel('Descrição')],[$descricao]);
        
        $this->form->addAction('Buscar', new TAction(array($this,'buscar')),'fa:search');
        $this->form->addAction('Novo', new TAction(array('ProdutoFormPersonalizado','novo')),'fa:plus-square green');
        
        
        $grid = new TQuickGrid();
        $grid->addQuickColumn('Codigo', 'id', 'left', '25%', new TAction(array($this,'buscar')),array('order','id'));
        $grid->addQuickColumn('Descricão', 'descricao', 'left', '50%', new TAction(array($this,'buscar')),array('order','descricao'));
        $grid->addQuickColumn('Valor Unitário', 'vlrun', 'right', '25%', new TAction(array($this,'buscar')),array('order','vlrun'));
        $grid->addQuickAction('Editar', new TDataGridAction(array('ProdutoFormPersonalizado', 'findID')), 'id', 'fa:pencil-square-o blue fa-lg');
        $grid->addQuickAction('Deletar', new TDataGridAction(array($this, 'deletar')), 'id', 'fa:trash-o red fa-lg');
//        $grid->del($object);
        
        $this->datagrid = new BootstrapDatagridWrapper($grid);
        
        $this->datagrid->createModel();
        
        $this->pageNavigation = new TPageNavigation();
        $this->pageNavigation->setAction(new TAction(array($this, 'buscar')));
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
      
    
    public function deletar($param){
        try {
            $key = $param['key'];
            TTransaction::open($this->base);
            $produto = new ProdutoModel($key);
            $produto->delete();
            new TMessage('info', 'Deletado com sucesso !');            
        } catch (Exception $ex) {
            TTransaction::rollback();
            new TMessage('error', 'Erro :'.$ex->getMessage());
        } finally{
            TTransaction::close();
            $this->buscar($param);   
        }    
    }
    
    public function buscar($param) {
        try {
            TTransaction::open($this->base);
            $values = $this->form->getData();
            $criterio = new TCriteria();
            $criterio->add(new TFilter('descricao', 'like', $values->descricao.'%'));
            $limitPg = 10;
            if ($this->order)
            {
                $criterio->setProperty('order', $this->order);
                $criterio->setProperty('direction', $this->direction);
            }
            //Controla o parametro de Paginação 
            $criterio->setProperty('limit', $limitPg);
            //Recarrega parametro para filtro...
            $criterio->setProperties($param);
            
            $repositorio = new TRepository('ProdutoModel');
            $listaPessoa = $repositorio->load($criterio);
            $this->form->setData($values);
            
            $this->datagrid->clear();
            if ($listaPessoa)
            {
                foreach ($listaPessoa as $object)
                {
                    $this->datagrid->addItem($object);
                }
            }
            $criterio->resetProperties();
            $contador= $repositorio->count($criterio);
            
            if (isset($this->pageNavigation))
            {
                $this->pageNavigation->setProperties($param); 
                $this->pageNavigation->setCount($contador); // conta quantas linhas tem
                $this->pageNavigation->setLimit($limitPg); // limite de linhas conforme contador
            }
        } catch (Exception $ex) {
            new TMessage('error', 'Erro :'.$ex->getMessage());
        } finally {
            TTransaction::close();
        }
    }

        
    
}
