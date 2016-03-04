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
            Brand::deleteAll();
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

        function testDeleteStore()
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
            $test_store->deleteStore();

            //Assert
            $result = Store::getAll();
            $this->assertEquals([$test_store2], $result);
        }

        function testFindStoreById()
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
            $result = Store::findStoreById($test_store->getId());

            //Assert
            $this->assertEquals($test_store, $result);
        }

        function testUpdateStore()
        {
            //Arrange
            $name = "Shoe Emporium";
            $id = null;
            $test_store = new Store($name, $id);
            $test_store->save();

            $new_name = "Emporium of Shoes";


            //Act
            $test_store->updateStore($new_name);

            //Assert
            $result = $test_store->getName();
            $this->assertEquals("Emporium of Shoes", $result);
        }

        function testAddBrand()
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
            $test_store->addBrand($test_brand);

            //Assert
            $result = $test_store->getBrands();
            $this->assertEquals([$test_brand], $result);
        }

        function testGetBrands()
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
            $test_store->addBrand($test_brand);
            $test_store->addBrand($test_brand2);

            //Assert
            $result = $test_store->getBrands();
            $this->assertEquals([$test_brand, $test_brand2], $result);
        }

    }
?>
