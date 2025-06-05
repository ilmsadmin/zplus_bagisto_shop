<?php

namespace App\GraphQL\Queries;

use Webkul\Core\Repositories\CountryRepository;

class CountriesQuery
{
    protected $countryRepository;

    public function __construct(CountryRepository $countryRepository)
    {
        $this->countryRepository = $countryRepository;
    }

    public function __invoke($rootValue, array $args, $context, $info)
    {
        return $this->countryRepository->all();
    }
}