<?php

// Routes
use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\Product;

// example home route
$app->get('/[{name}]', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");
    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});

$app->group('/api', function () use ($app) {
    $app->group('/v1', function () use ($app) {

        /**
         * Route GET /api/v1/products
         */
        $app->get('/products', function ($request, $response) {
            $products = Product::all();

            // logging within the controller
            $this->logger->info($request->getUri() . " route");

            return $response->withJson([
                'code' => 200,
                'total_results' => $products->count(),
                'data' => $products
            ]);
        });

        /**
         * Route GET /api/v1/products/{id}
         */
        $app->get('/products/{id}', function ($request, $response, $args) {
            $product = Product::find($args['id']);

            if ($product) {
                return $response->withJson([
                    'code' => 200,
                    'data' => $product
                ], 200);
            }

            return $response->withJson([
                'code' => '404',
                'message' => 'no product found'
            ], 404);
        });

        /**
         * Route POST /api/v1/product
         */
        $app->post('/product', function ($request, $response) {
            try {
                $this->logger->info("Creating a new product", ['data' => $request->getParsedBody()]);
                $product = (new Product)->addProduct($request);
                var_dump($product);
                if ($product) {
                    return $response->withJson([
                        'code' => 201,
                        'message' => 'New product added successfully.',
                        'data' => $product
                    ], 201);
                }

                return $response->withJson([
                    'code' => 400,
                    'message' => 'There were some problems with the data provided.',
                ], 400);
            } catch (\Exception $e) {
            }
        });

        /**
         * Route PUT /api/v1/product/{id}
         */
        $app->put('/product/{id}', function ($request, $response, $args) {
            try {
                $this->logger->info("Updating an existing product", ['id' => $args['id']]);

                $product = (new Product)->updateUpdate($request, $args);

                if ($product) {
                    return $response->withJson([
                        'code' => 200,
                        'message' => 'Product has been updated successfully.',
                        'data' => $product
                    ], 200);
                }

                return $response->withJson([
                    'code' => 400,
                    'message' => 'There were some problems while updating the record.',
                ], 400);
            } catch (\Exception $e) {
            }
        });

        /**
         * Route DELETE /api/v1/products/{id}
         */

        $app->delete('/products/{id}', function ($request, $response, $args) {
            $this->logger->info("Deleting product", ['id' => $args['id']]);

            $product = Product::find($args['id']);

            if ($product) {
                $product->delete();

                return $response->withJson([
                    'code' => 200,
                    'message' => 'Product has been deleted successfully.'
                ], 200);
            }

            return $response->withJson([
                'code' => '404',
                'message' => 'no product found'
            ], 404);
        });
    });
});
