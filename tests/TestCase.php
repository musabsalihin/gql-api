<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Nuwave\Lighthouse\Testing\MakesGraphQLRequests;
use Nuwave\Lighthouse\Testing\TestsSubscriptions;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use MakesGraphQLRequests;
    use TestsSubscriptions;

    public function gql($query)
    {
        return $this->postJson('/graphql',[
            'query' => $query,
        ]);
    }
}
