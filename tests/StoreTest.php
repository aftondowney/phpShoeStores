<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Store.php";
    require_once "src/Brand.php";


    $server = 'mysql:host=localhost;dbname=shoes_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);


    class StoreTest extends PHPUnit_Framework_TestCase
    {

        protected function tearDown()
        {
            Store::deleteAll();
            // Brand::deleteAll();
        }

        function testSave()
        {
            //Arrange
            $name = "Shoe Emporium";
            $id = null;
            $test_store = new Store($name, $id);
            $test_store->save();

            //Act
            $result = Store::getAll();

            //Assert
            $this->assertEquals($test_store, $result[0]);
        }

        function testGetAll()
        {
            //Arrange
            $name = "Shoe Emporium";
            $id = null;
            $test_store = new Store($name, $id);
            $test_store->save();

            $name2 = "Shoes for All";
            $test_store2 = new Store($name2, $id);
            $test_store2->save();

            //Act
            $result = Store::getAll();

            //Assert
            $this->assertEquals([$test_store, $test_store2], $result);
        }

        function testDeleteAll()
        {
            //Arrange
            $name = "Shoe Emporium";
            $id = null;
            $test_store = new Store($name, $id);
            $test_store->save();

            $name2 = "Shoes for All";
            $test_store2 = new Store($name2, $id);
            $test_store2->save();

            //Act
            Store::deleteAll();

            //Assert
            $result = Store::getAll();
            $this->assertEquals([], $result);
        }

    }
?>
