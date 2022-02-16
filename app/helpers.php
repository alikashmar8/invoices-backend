<?php

function custom_response($is_api_call, $json_data, $compact_data, $view_name,  $status_code)
{
    if ($is_api_call) {
        return response()->json([
            $json_data,
        ], $status_code);
    } else {
        return view($view_name, $compact_data);
    }
}
