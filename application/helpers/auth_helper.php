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
        $ci->db->where('email', $user_login);
        $ci->db->where('remember_token', $token);

        $user = $ci->db->get('users')->row();
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
        $user = $ci->is_user;
        $ci->db->select("rules.*")->from("rules")
            ->join("access_role_user", 'access_role_user.role_id=rules.id')
            ->where("access_role_user.user_id", $user->id);
        $rules = $ci->db->get();

        $ci->db->select("menus.id,menus.name as menu_name,menus.icon as menu_icon ,menus.url as menu_url,submenus.name as submenu_name,submenus.icon as submenu_icon ,submenus.url as submenu_url")->from("menus")
            ->join("access_menu_role", 'access_menu_role.menu_id=menus.id')
            ->join("submenus", "submenus.menu_id=menus.id")->join("access_submenu_role", 'access_submenu_role.submenu_id=submenus.id', "left")->group_by("submenus.id")->order_by("submenus.name", 'asc');

        foreach ($rules->result() as $key => $role) {
            if ($key == 0)
                $ci->db->where([
                    "access_menu_role.role_id" => $role->id,
                    'submenus.is_access' => 'public'
                ]);
            else
                $ci->db->or_where([
                    "access_menu_role.role_id" => $role->id,
                    'submenus.is_access' => 'public'
                ]);
        }
        $ci->db->or_where("access_submenu_role.role_id", $role->id);

        $menusSQL = $ci->db->get();
        $menus =  [];
        foreach ($menusSQL->result() as $key => $menu) {
            if (!isset($menus[$menu->id])) {
                $menus[$menu->id] = (object) [
                    "menu" => $menu->menu_name,
                    "submenu" =>  [$menu],
                ];
            } else
                $menus[$menu->id]->submenu[] =  $menu;
        }



        $user->rules = $rules;

        $user->menus = (object) $menus;
        $ci->is_user = $user;
        return $user;
    }
}

if (!function_exists('in_role')) {
    function in_role($rules, bool  $b = false)
    {
        $ci = get_instance();

        if (!is_login())
            return false;
        $user = $ci->is_user;

        if (is_array($rules)) {
            foreach ($rules as $rule) {
                foreach ($user->rules->result() as $role) {
                    if ($role->id == $rule || $role->name == $rule) {
                        return true;
                    }
                }
            }
        } else
            foreach ($user->rules->result_object() as $role) {
                if ($role->id == $rules || $role->name == $rules) {
                    return true;
                }
            }
        if ($b)
            return false;
        return false;
    }
}
