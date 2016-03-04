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

		//view/update/delete routes for Store
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



		return $app;

?>
