<?php
use Adianti\Base\TStandardForm;
use Adianti\Wrapper\BootstrapFormBuilder;
use Adianti\Widget\Form\TEntry;
use Adianti\Widget\Form\TLabel;
use Adianti\Control\TAction;
use Adianti\Widget\Container\TVBox;
use Adianti\Widget\Util\TXMLBreadCrumb;
/**
 *
 * @Eliezer
 */
class ProdutoForm extends TStandardForm{
    protected $form;

    function __construct() {
        parent::__construct();
        parent::setDatabase('db_sistema');
        parent::setActiveRecord('ProdutoModel');
        
        $this->form = new BootstrapFormBuilder('frm_produto');
        $this->form->setFormTitle('Produto');
        
        $id = new TEntry('id');
            $id->setSize('40%');
            $id->setEditable(false);
        $descricao = new TEntry('descricao');
            $descricao->setSize('100%');
            $descricao->forceUpperCase();
            $descricao->isRequired();
        $vlrUn = new TEntry('vlrun');
            $vlrUn->setSize('40%');
            $vlrUn->isRequired();
            $vlrUn->setNumericMask('2', ',', '.',TRUE);
            
        $this->form->addFields([new TLabel('Id')],[$id]);
        $this->form->addFields([new TLabel('Descrição')],[$descricao]);
        $this->form->addFields([new TLabel('Valor Unitário')], [$vlrUn]);
        
        $this->form->addAction('Salvar', new TAction(array($this, 'onSave')),'fa:floppy-o');
        $this->form->addAction('Novo', new TAction(array($this,'onClear')),'fa:eraser red');
        $this->form->addAction('Voltar para listagem', new TAction(array('ProdutoBuscar','onReload')),'fa:table blue');
        
        $container = new TVBox();
        $container->style = 'width:100%';
        $container->add(new TXMLBreadCrumb('menu.xml', 'ProdutoBuscar'));
        $container->add($this->form);
        
        parent::add($container);
        
    }

    
    
}
