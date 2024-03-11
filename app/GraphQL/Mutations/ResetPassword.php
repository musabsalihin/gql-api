<?php declare(strict_types=1);

namespace App\GraphQL\Mutations;
use App\Models\PasswordResetTokens;
use App\Models\User;

class ResetPassword
{
    /** @param  array{}  $args */
    public function __invoke(null $_, array $args)
    {
        // TODO implement the resolver
        
        $check = PasswordResetTokens::where('email',$args['email'])->where('token',$args['encryption'])->count();

        if($check == 1){
            $user = User::where('email',$args['email']);
            $user->update([
                'password' => $args['password']
            ]);

            PasswordResetTokens::where('email',$args['email'])->delete();            
            $data['status'] = "SUCCESS";
            return $data;
        }
        
        $data['status'] = "FAIL";


        return $data;
    }
}
