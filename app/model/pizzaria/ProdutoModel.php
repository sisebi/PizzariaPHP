<?php
use Adianti\Database\TRecord;
/**
 * @Eliezer
 */
class ProdutoModel extends TRecord{
    const TABLENAME = 'tb_produto'; 
    const PRIMARYKEY = 'id';
    const IDPOLICY = 'max';
    
}
