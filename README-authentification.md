# AUTHENFICATOR SYMFONY

```SHELL
php bin/console make:user
->
-> yes 
->email
->yes
```

## DELETE ROLES

'Private Roles -> delete
SetRoles -> delete
getRole -> delete variable $.'

```SHELL
php bin/console make:auth
-> 1
-> loginFormAuthentificator
1
-> SecurtityController
-> yes
```

```SHELL
php bin/console make:registration-form
-> yes 
-> no
-> yes
```

## Dans le dossier security.yaml décommenter
```SHELL
       access_control:
         - { path: ^/admin, roles: ROLE_ADMIN }
         - { path: ^/profile, roles: ROLE_USER }
```

```SHELL
php bin/console make:entity

->user
->is_admin
-> enter
-> yes 
```

## faire une condition dans user.php pour vérifier le log

```SHELL
public function getRoles.

if ($this->getIsAdmin())
{
    $roles[] = 'ROLES_ADMIN';
}
```

## Dans phpmyadmin edité Is_admin
```SHELL
    Edite -> Is_admin-> mettre la valeur en 1
```

## create a new security voter class
```shell
php bin/console make:voter
```
