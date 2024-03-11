<?php declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Models\User;
use Hash;
use Illuminate\Validation\ValidationException;

class Login
{
    /** @param  array{}  $args */
    public function __invoke(null $_, array $args)
    {
        // TODO implement the resolver
        $user = User::where('email', $args['email'])->first();
 
        if (! $user || ! Hash::check($args['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }
        $token = $user->createToken($args['device_name'])->plainTextToken;
    
        $data = [
            'token' => $token,
            'user' => $user,
        ];
     
        return $data;
    }
}
