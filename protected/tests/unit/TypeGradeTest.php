<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Admin
 * Date: 12/19/13
 * Time: 1:10 PM
 * To change this template use File | Settings | File Templates.
 */

class TypeGradeTest extends CTestCase{
    public function testConnection() {
        $this->assertTrue(true);
        $this->assertNotNull(Yii::app()->db->connectionString);
    }

    public function testTypeTypes() {
        $options = Type::model()->getOptions();
        $this->assertTrue(is_array($options));
        $this->assertEquals(3+1, count($options));  // should be DB number + 1 (due to 'select' option)
    }

    public function testGradeTypes() {
        $options = Grade::model()->getOptions();
        $this->assertTrue(is_array($options));
        $this->assertEquals(8+1, count($options)); // should be DB number + 1 (due to 'select' option)
    }
    public function testJobTypes() {
        $options = Job::model()->getOptions();
        $this->assertTrue(is_array($options));
        $this->assertEquals(3+1, count($options)); // should be DB number + 1 (due to 'select' option)
    }
}
