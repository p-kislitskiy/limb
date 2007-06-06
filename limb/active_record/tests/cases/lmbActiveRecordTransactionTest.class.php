<?php
/*
 * Limb PHP Framework
 *
 * @link http://limb-project.com
 * @copyright  Copyright &copy; 2004-2007 BIT(http://bit-creative.com)
 * @license    LGPL http://www.gnu.org/copyleft/lesser.html
 */
lmb_require('limb/active_record/src/lmbActiveRecord.class.php');
lmb_require('limb/dbal/src/lmbSimpleDb.class.php');
require_once(dirname(__FILE__) . '/lmbActiveRecordTest.class.php');//need TestOneTableObjectFailing

class lmbActiveRecordTransactionTest extends UnitTestCase
{
  function setUp()
  {
    $this->conn = lmbToolkit :: instance()->getDefaultDbConnection();
    $this->db = new lmbSimpleDb($this->conn);

    $this->_cleanUp();
  }

  function tearDown()
  {
    $this->_cleanUp();
  }

  function _cleanUp()
  {
    $this->db->delete('test_one_table_object');
  }

  function  testSaveInTransaction()
  {
    $this->conn->beginTransaction();

    $obj = new TestOneTableObjectFailing();
    $obj->setContent('hey');

    $this->assertTrue($obj->trySave());

    $this->conn->commitTransaction();

    $this->assertEqual($this->db->count('test_one_table_object'), 1);
  }

  function  testSaveRollbacksTransaction()
  {
    $this->conn->beginTransaction();

    $obj = new TestOneTableObjectFailing();
    $obj->setContent('hey');
    $obj->fail = new Exception('whatever');

    $this->assertFalse($obj->trySave());

    $this->conn->commitTransaction();

    $this->assertEqual($this->db->count('test_one_table_object'), 0);
  }
}
?>