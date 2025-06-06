<?php

namespace App\GraphQL\Queries;

use Webkul\Category\Repositories\CategoryRepository;

class HomeCategoriesQuery
{
    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function __invoke($rootValue, array $args, $context, $info)
    {
        $input = $args['input'] ?? [];
        
        // Build query parameters from input
        $params = [
            'status' => 1,
            'locale' => app()->getLocale(),
        ];

        foreach ($input as $filter) {
            if ($filter['key'] === 'parent_id') {
                $params['parent_id'] = $filter['value'];
            } elseif ($filter['key'] === 'locale') {
                $params['locale'] = $filter['value'];
            } elseif ($filter['key'] === 'status') {
                $params['status'] = $filter['value'];
            }
        }

        return $this->categoryRepository->getAll($params);
    }
}