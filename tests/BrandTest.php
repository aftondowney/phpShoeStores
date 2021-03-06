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


    class BrandTest extends PHPUnit_Framework_TestCase
    {

        protected function tearDown()
        {
            Store::deleteAll();
            Brand::deleteAll();
        }

        function testSave()
        {
            //Arrange
            $name = "Naturalizer";
            $id = null;
            $test_brand = new Brand($name, $id);
            $test_brand->save();

            //Act
            $result = Brand::getAll();

            //Assert
            $this->assertEquals($test_brand, $result[0]);
        }

        function testGetAll()
        {
            //Arrange
            $name = "Naturalizer";
            $id = null;
            $test_brand = new Brand($name, $id);
            $test_brand->save();

            $name2 = "Chinese Laundry";
            $test_brand2= new Brand($name2, $id);
            $test_brand2->save();

            //Act
            $result = Brand::getAll();

            //Assert
            $this->assertEquals([$test_brand, $test_brand2], $result);
        }

        function testDeleteAll()
        {
            //Arrange
            $name = "Naturalizer";
            $id = null;
            $test_brand = new Brand($name, $id);
            $test_brand->save();

            $name2 = "Chinese Laundry";
            $test_brand2= new Brand($name2, $id);
            $test_brand2->save();

            //Act
            Brand::deleteAll();

            //Assert
            $result = Brand::getAll();
            $this->assertEquals([], $result);
        }

        function testFindBrandById()
        {
            //Arrange
            $name = "Naturalizer";
            $id = null;
            $test_brand = new Brand($name, $id);
            $test_brand->save();

            $name2 = "Chinese Laundry";
            $test_brand2= new Brand($name2, $id);
            $test_brand2->save();

            //Act
            $result = Brand::findBrandById($test_brand->getId());

            //Assert
            $this->assertEquals($test_brand, $result);
        }

        function testAddStore()
        {
            //Arrange
            $name = "Shoe Emporium";
            $id = null;
            $test_store = new Store($name, $id);
            $test_store->save();

            $name = "Naturalizer";
            $id = null;
            $test_brand = new Brand($name, $id);
            $test_brand->save();

            $name2 = "Chinese Laundry";
            $test_brand2= new Brand($name2, $id);
            $test_brand2->save();

            //Act
            $test_brand->addStore($test_store);

            //Assert
            $result = $test_brand->getStores();
            $this->assertEquals([$test_store], $result);
        }

        function testGetStores()
        {
            //Arrange
            $name = "Shoe Emporium";
            $id = null;
            $test_store = new Store($name, $id);
            $test_store->save();

            $name2 = "Shoes for All";
            $test_store2 = new Store($name2, $id);
            $test_store2->save();

            $name = "Chinese Laundry";
            $test_brand= new Brand($name, $id);
            $test_brand->save();

            //Act
            $test_brand->addStore($test_store);
            $test_brand->addStore($test_store2);

            //Assert
            $result = $test_brand->getStores();
            $this->assertEquals([$test_store, $test_store2], $result);
        }

    }
?>
