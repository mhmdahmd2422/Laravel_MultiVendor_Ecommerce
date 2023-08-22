<?php

// Set Sidebar Item Active

function setActive(array $route){
    foreach ($route as $r){
        if(request()->routeIs($r)){
            return 'active';
        }
    }
}
