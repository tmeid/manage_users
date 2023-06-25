<?php 
date_default_timezone_set('Asia/Ho_Chi_Minh');

const __DEFAULT_MODULE = 'home';
const __DEFAULT_ACTION = 'list';

const __MODULES = 'modules';
const __NOT_FOUND = __MODULES .'/errors/404.php';

// db
const _HOST = 'localhost';
const _USER = 'root';
const __PASS = '';
const _DB = 'manage_users';
const _DRIVER = 'mysql';

const __ENV = 'local';

// paginate 
const __PER_PAGE = 5;

// time expire of login token 
// day
const __EXPIRE_TIME = 1;

// queue mail 
const __LIMIT_MAIL = 10;
