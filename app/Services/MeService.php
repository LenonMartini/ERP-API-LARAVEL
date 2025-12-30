<?php


namespace App\Services;

class MeService
{
    public function me(){
        $auth = auth()->user();
        if(!$auth){
           throw new \Exception("User not authenticated", 401);
        }

        return $auth;
    }
    public function rolesPermissions(){
        $auth = auth()->user();
        if(!$auth){
           throw new \Exception("User not authenticated", 401);
        }
        return [
            'roles' => $auth->getRoleNames(),
            'permissions' => auth()->user()->permissionsTree(),
        ];
    }
}
