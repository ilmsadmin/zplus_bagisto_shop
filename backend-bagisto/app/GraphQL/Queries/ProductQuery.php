<?php

namespace App\GraphQL\Queries;

use Webkul\Product\Repositories\ProductRepository;

class ProductQuery
{
    protected $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function __invoke($rootValue, array $args, $context, $info)
    {
        $searchParams = [
            'channel_id' => core()->getCurrentChannel()->id,
            'status' => 1,
            'visible_individually' => 1,
        ];

        if (isset($args['query'])) {
            $searchParams['query'] = $args['query'];
        }

        if (isset($args['sortKey'])) {
            $sortKey = $args['sortKey'];
            $reverse = $args['reverse'] ?? false;
            
            $sortMapping = [
                'CREATED_AT' => 'created_at',
                'UPDATED_AT' => 'updated_at',
                'TITLE' => 'name',
                'PRICE' => 'price',
                'NAME' => 'name',
            ];

            if (isset($sortMapping[$sortKey])) {
                $searchParams['sort'] = $sortMapping[$sortKey];
                $searchParams['order'] = $reverse ? 'desc' : 'asc';
            }
        }

        return $this->productRepository->getAll($searchParams);
    }
}