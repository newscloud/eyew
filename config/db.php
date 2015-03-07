<?php

return [
  'class' => 'yii\db\Connection',
  'dsn' => 'mysql:host=localhost;dbname='.$config['mysql_db'],
  'username' => $config['mysql_un'],
  'password' => $config['mysql_pwd'],
  'charset' => 'utf8',
];
