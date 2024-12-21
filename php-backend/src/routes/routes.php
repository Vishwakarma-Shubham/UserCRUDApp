<?php

class Routes {

    private $routes = [
        ['method' => 'GET', 'pattern' => '^api/users$', 'handler' => ['UserController', 'index']],
        ['method' => 'GET', 'pattern' => '^api/users/(\d+)$', 'handler' => ['UserController', 'show']],
        ['method' => 'POST', 'pattern' => '^api/users$', 'handler' => ['UserController', 'store']],
        ['method' => 'PUT', 'pattern' => '^api/users/(\d+)$', 'handler' => ['UserController', 'update']],
        ['method' => '`DELETE`', 'pattern' => '^api/users/(\d+)$', 'handler' => ['UserController', 'destroy']],
    ];


}