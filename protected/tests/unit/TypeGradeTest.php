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
        $options = Type::model()->getTypeOptions();
        $this->assertTrue(is_array($options));
        $this->assertEquals(3, count($options));
    }

    public function testGradeTypes() {
        $options = Grade::model()->getTypeOptions();
        $this->assertTrue(is_array($options));
        $this->assertEquals(8, count($options));
    }
}
