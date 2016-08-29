<?php
  return [
      "db"=>"test",
      "host"=>"localhost",
      "user"=>"root",
      "password"=>"",
      "account_pattern"=>"/^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/",
       "password_pattern"=>"/^[A-Za-z0-9]+$/",
       "name_pattern"=>"/^\w+$/",
       "tel_pattern"=>"/^[0-9]*[1-9][0-9]*$/",
       "id_pattern"=>"/^-?\d+$/",
       "price_pattern"=>"/^-?(?:\d+|\d{1,3}(?:,\d{3})+)?(?:\.\d+)?$/"
  ];