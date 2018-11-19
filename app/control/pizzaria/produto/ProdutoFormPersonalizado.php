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
class ProdutoFormPersonalizado extends TPage {

    protected $form;
    protected $base = 'db_sistema';

    function __construct() {
        parent::__construct();

        $this->form = new BootstrapFormBuilder('frmProdu_Personalizado');
        $this->form->setFormTitle('Cadastro de Produto Personalizado');

        $id = new TEntry('id');
        $id->setEditable(false);
        $id->setSize('40%');
        $descricao = new TEntry('descricao');
        $descricao->forceUpperCase();
        $vlrUn = new TEntry('vlrun');
        $vlrUn->setSize('50%');
        $vlrUn->setNumericMask(2, '.', ',');

        $this->form->addFields([new TLabel('Id')], [$id]);
        $this->form->addFields([new TLabel('Descrição')], [$descricao]);
        $this->form->addFields([new TLabel('Valor Unitário')], [$vlrUn]);

        $this->form->addAction('Salvar', new TAction(array($this, 'salvar')), 'fa:floppy-o');
        $this->form->addAction('Novo', new TAction(array($this, 'novo')), 'fa:plus-square green');
        $this->form->addAction('Voltar para listagem', new TAction(array('ProdutoBuscarPersonalizado','buscar')),'fa:table blue');

        $container = new TVBox();
        $container->style = 'width:100%';
        $container->add(new TXMLBreadCrumb('menu.xml', 'ProdutoBuscarPersonalizado'));
        $container->add($this->form);

        parent::add($container);
    }

    public function findID($param) {
        try {
            $key = $param['key'];
            TTransaction::open($this->base);
            $produto = new ProdutoModel($key);
            $this->form->setData($produto);
        } catch (Exception $ex) {
            new TMessage('error', 'Erro :'.$ex->getMessage());
        } finally {
            TTransaction::close();
        }
    }

    public function salvar() {
        try {
            TTransaction::open($this->base);
            $produto = $this->form->getData('ProdutoModel');
            $this->form->validate();
            $produto->store();
            new TMessage('info', 'Salvo com sucesso !');
            $this->form->setData($produto);
        } catch (Exception $ex) {
            TTransaction::rollback();
            new TMessage('error', 'ERROR :' . $ex->getMessage());
        } finally {
            TTransaction::close();
        }
    }

    public function novo() {
        $this->form->clear(true);
    }

}
