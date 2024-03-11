<?php declare(strict_types=1);

namespace App\GraphQL\Mutations;
use App\Models\PasswordResetTokens;
use App\Models\User;


class ForgotPassword
{
    /** @param  array{}  $args */
    public function __invoke(null $_, array $args)
    {
        // TODO implement the resolver
        $user = User::where('email',$args['email'])->first();
        $enc = $user->generateTokenString();

        $reset= PasswordResetTokens::create([
            'email' => $args['email'],
            'token' => $enc,
        ]);

        $data = [
            'encryption'=> $enc,
        ];

        return $data;
    }
}
