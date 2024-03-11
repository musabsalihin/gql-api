<?php declare(strict_types=1);

namespace App\GraphQL\Queries;
use Illuminate\Support\Facades\Auth;


class Logout
{
    /** @param  array{}  $args */
    public function __invoke(null $_, array $args)
    {
        // TODO implement the resolver
        Auth::user()->tokens()->each(function ($token, $key) {
            $token->delete();
        });

        $data = [
            'status' => 'TOKEN_REVOKED',
            'message' => 'Your session has been terminated'
        ];
        return $data;
    }
}
