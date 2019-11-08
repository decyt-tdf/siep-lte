<?php

function mergeApiParam($default=[],$request=[])
{
    $requestOnlyNotNull = collect($request)->filter(function ($value, $key) {
        return !empty($value);
    });

    return collect($default)->merge($requestOnlyNotNull)->toArray();
}
