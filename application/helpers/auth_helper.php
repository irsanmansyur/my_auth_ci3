<?php

if (!function_exists('is_login')) {
  function is_login()
  {
    $ci = get_instance();
    if (isset($ci->is_login))
      return $ci->is_login;
    if (!$ci->session->userdata('user_login')) {
      $ci->is_login = false;
      $ci->is_user = null;
      return false;
    }

    $user_login = $ci->session->userdata('user_login');
    $token = $ci->session->userdata('user_token');


    $user = $ci->user->where('email', $user_login)
      ->where('remember_token', $token)
      ->first();

    if (!$user) {
      $ci->is_login = false;
      $ci->is_user = null;
      return false;
    }
    $ci->is_login = true;
    $ci->is_user = $user;
    return true;
  }
}

if (function_usable('is_login')) {
  function user()
  {
    $ci = get_instance();
    if (!is_login())
      return $ci->is_user;
    if (isset($ci->is_user))
      return $ci->is_user;
    return $ci->user;
  }
}

if (!function_exists('in_role')) {
  function in_role($roles, bool  $b = false)
  {
    $ci = get_instance();

    if (!is_login() || !$ci->is_user)
      return false;
    $user = user();

    $model =   $user->roles();

    if (is_string($roles) || is_integer($roles))
      $roles = [$roles];

    $model->group_start("AND");
    $model->where_in("role_id", $roles);
    $model->or_where_in("roles.name", $roles);
    $model->group_end();

    $find = $model->first();


    return  $find  ? true : false;
  }
}
if (!function_exists('can')) {
  function can($permission, ...$arg)
  {
    $ci = get_instance();

    if (!is_login() || !$ci->is_user)
      return false;

    $user = user();

    $menus =   $user->menus();

    if (is_string($permission) || is_integer($permission))
      $permission = [$permission];
    $permission =  array_merge($permission, $arg);


    $menus->where_in("name", $permission);

    $find = $menus->first();

    return  $find  ? true : false;
  }
}
