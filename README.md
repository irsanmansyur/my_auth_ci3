# my_auth_ci3
Application managemen menu, user (CMS for Simple WEB)

## Cara Menggunakan
1. Silahkan *clone* atau *download* dari repositori  [http://github.com/tantangin/my_auth_ci3.git](http://github.com/tantangin/my_auth_ci3.git).
2. buatlah sebuah database dan setting di **application/config/database.php** sesuai dengan database yang anda pakai
3. Silahkan import database yang telah disiapkan **my_auth_ci3.sql**
4. Sampai disini harusnya sudah bisa jalan dengan semestinya

## Fitur fitur 
- Helpers
  - is_login()
    return true or false;
  - user()
    return **user object** or null
  - in_role($params)
    $param berisi string atau integer, *contoh* ' in_role("Super Admin) '
    return true or false
- Model
  - hasOne($model,$key)
	
    contoh $user->hasOne("Alamat_model","user_id");
		
    ini akan mengenmbalikan alamat berdasarkan user yg dipilih
  - hasMany($model,$keyFrom)
	
    contoh $menu->hasMany("Submenu_model","menu_id");
		
    ini akan mengenmbalikan Submenu berdasarkan **menu** yg dipilih
    
  - belongsTo($model, $key_from = null)
	
    contoh $submenu->belongsTo("Menu_model","menu_id");
		
    ini akan mengenmbalikan Menu berdasarkan **submenu** yg dipilih
    
  - belongsToMany($model, $key_from = null, $key_to = null, $table_relation = null) // Many To Many
	
    contoh $user->belongsToMany("Role_model","user_id","role_id);
		
    ini akan mengenmbalikan Roles berdasarkan **user** yg dipilih

- Dan Lain Lain

## Jika Kebingunan dalam menggunakannya silahkan hubungi saya di
1. WA [085349540044](https://wa.me/6285349540044?text=Saya%20ingin%20bertanya%20di%20MYAUTHCI3)
2. FB [fb.com/ichank00](https://facebook.com/ichank00)

