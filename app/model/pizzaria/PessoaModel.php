<?php

use Adianti\Database\TRecord;

/**
 * @Eliezer
 */
class PessoaModel extends TRecord {

    const TABLENAME = 'tb_pessoa';
    const PRIMARYKEY = 'id';
    const IDPOLICY = 'max';

    private $tipo;
    private $listaTipos;

    function __construct() {
        parent::__construct();
        parent::addAttribute('id');
        parent::addAttribute('nome');
        parent::addAttribute('cpf');
        parent::addAttribute('rg');
        parent::addAttribute('datnasc');
        parent::addAttribute('email');
        parent::addAttribute('tipo_id');
        parent::addAttribute('fone');
        parent::addAttribute('celular');
        parent::addAttribute('cep');
        parent::addAttribute('rua');
        parent::addAttribute('nr');
        parent::addAttribute('complemento');
        parent::addAttribute('bairro');
        parent::addAttribute('cidade');
        parent::addAttribute('uf');
    }

    function get_Tipo_nome() {
        if (empty($this->tipo)) {
            $this->tipo = new TipoPessoa($this->tb_tipopessoa_id);
        }
            return $this->tipoPessoa->nome;
    }

    function addTipo(TipoPessoa $tipo) {
        $this->listaTipos[] = $tipo;
    }

}
