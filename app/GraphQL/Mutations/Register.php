<?php declare(strict_types=1);

namespace App\GraphQL\Mutations;
use App\Models\User;

class Register
{
    /** @param  array{}  $args */
    public function __invoke(null $_, array $args)
    {
        // TODO implement the resolver
        $user = User::create([
            'name' => $args['name'],
            'email' => $args['email'],
            'mobile' => $args['mobile'],
            'password' => $args['password'],
        ]);
        if($user->exists){
            return "Successfully Registered!";
        }
        return "Registration Unsuccessful";
    }
}
