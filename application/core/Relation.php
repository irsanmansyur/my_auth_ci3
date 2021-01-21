<?php


namespace MyModel\core;

class Relation extends \MY_Model
{
  protected $_table = null;

  public function __construct($tabel)
  {
    $this->_table = $tabel;
    parent::__construct();
  }
}
