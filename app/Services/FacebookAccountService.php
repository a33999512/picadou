<?php

namespace App\Services;
use App\FacebookAccount;
use App\User;
use Laravel\Socialite\Contracts\User as ProviderUser;

class FacebookAccountService
{
    public function createOrGetUser(ProviderUser $providerUser)
    {
        $account = FacebookAccount::whereProvider('facebook')
            ->whereProviderUserId($providerUser->getId())
            ->first();

        if ($account) {
            $account->token = $providerUser->token;
            $account->save();
            $account->user->avatar = $providerUser->getAvatar();
            $account->user->save();     // 每次重新登入就更新一次大頭貼
            return $account->user;
        } else {

            $account = new FacebookAccount([
                'provider_user_id' => $providerUser->getId(),
                'provider' => 'facebook',
                'token' => $providerUser->token,
            ]);

            $user = User::whereEmail($providerUser->getEmail())->first();   // 尋找是否已存在該信箱之帳戶

            if (!$user) {

                $user = User::create([
                    'email' => $providerUser->getEmail(),
                    'name' => $providerUser->getName(),
                    'password' => md5(rand(1,10000)),
                    'avatar' => $providerUser->getAvatar(),
                ]);
            }

            // $account->user->avatar = $providerUser->getAvatar();

            $account->user()->associate($user);
            $account->save();

            return $user;
        }
    }
}
