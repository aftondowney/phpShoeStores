<?php

		require_once __DIR__."/../vendor/autoload.php";
		require_once __DIR__."/../src/Store.php";
	 	require_once __DIR__."/../src/Brand.php";

		$app = new Silex\Application();

		$server = 'mysql:host=localhost;dbname=shoes';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    use Symfony\Component\HttpFoundation\Request;
  	Request::enableHttpMethodParameterOverride();

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views'));

		//home
		$app->get("/", function() use ($app) {
				return $app['twig']->render('index.html.twig');
		});

		//view/update/delete routes for stores
		$app->get("/stores", function() use ($app) {
				return $app['twig']->render('stores.html.twig', array('stores' => Store::getAll(), 'form' => false));
		});

		$app->post("/stores", function() use ($app) {
        $name = $_POST['name'];
        $new_store = new Store($name);
        $new_store->save();
        return $app['twig']->render('stores.html.twig', array('stores' => Store::getAll(), 'form' => false));
    });

		$app->get("/store/{id}/edit", function($id) use ($app) {
        $store = Store::findStoreById($id);
        return $app['twig']->render('stores.html.twig', array('store' => $store, 'stores' => Store::getAll(), 'form' => true));
    });

		$app->patch("/stores/updated", function() use ($app) {
        $store_to_edit = Store::findStoreById($_POST['current_storeId']);
        $store_to_edit->updateStore($_POST['name']);
        return $app['twig']->render('stores.html.twig', array('store' => $store_to_edit, 'stores' => Store::getAll(), 'form' => false));
    });

		$app->delete('/store/{id}/delete', function($id) use ($app) {
        $store = Store::findStoreById($id);
        $store->deleteStore();
        return $app['twig']->render('stores.html.twig', array('store' => $store, 'stores' => Store::getAll(), 'form' => false));
    });

		$app->post("/delete_stores", function() use ($app) {
        Store::deleteAll();
        return $app['twig']->render('index.html.twig');
    });

		//routes to view individual store and add brands
		$app->get("/store/{id}", function($id) use ($app) {
        $store = Store::findStoreById($id);
        return $app['twig']->render('store.html.twig', array('store' => $store, 'brands' => $store -> getBrands(), 'all_brands' => Brand::getAll()));
    });

		$app->post("/add_brands", function() use ($app) {
        $store = Store::findStoreById($_POST['store_id']);
        $brand = Brand::findBrandById($_POST['brand_id']);
        $store->addBrand($brand);
        return $app['twig']->render('store.html.twig', array('store' => $store, 'brands' => $store->getBrands(), 'all_brands' => Brand::getAll()));
      });

			//routes to view/add/delete brands
		$app->get("/brands", function() use ($app) {
        return $app['twig']->render('brands.html.twig', array('brands' => Brand::getAll(), 'form' => false));
    });

    $app->post("/brands", function() use ($app) {
        $name = $_POST['name'];
        $new_brand = new Brand($name);
        $new_brand->save();
        return $app['twig']->render('brands.html.twig', array('brands' => Brand::getAll(), 'form' => false));
    });

    $app->get("/brand/{id}", function($id) use ($app) {
        $brand = Brand::findBrandById($id);
        return $app['twig']->render('brand.html.twig', array('brand' => $brand, 'brands' => $brand -> getStores(), 'all_stores' => Store::getAll(), 'stores' => $brand->getStores()));
    });

		$app->post("/add_stores", function() use ($app) {
        $store = Store::findStoreById($_POST['store_id']);
        $brand = Brand::findBrandById($_POST['brand_id']);
        $brand->addStore($store);
        return $app['twig']->render('brand.html.twig', array('brand' => $brand, 'brands' => Brand::getAll(), 'stores' => $brand->getStores(), 'all_stores' => Store::getAll()));
    });

    $app->post("/delete_brands", function() use ($app) {
        Brand::deleteAll();
        return $app['twig']->render('index.html.twig');
    });

		


		return $app;

?>
