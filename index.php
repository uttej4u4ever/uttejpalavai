<?php

//print_r($_SERVER);die();

$sitepad['db_name'] = 'uttejpalavai_sp265';
$sitepad['db_user'] = 'uttejpalavai_sp265';
$sitepad['db_pass'] = 'pBOS[-d758';
$sitepad['db_host'] = 'localhost';
$sitepad['db_table_prefix'] = 'spik_';
$sitepad['charset'] = 'utf8mb4';
$sitepad['collate'] = 'utf8mb4_unicode_ci';
$sitepad['serving_url'] = 'uttejpalavai.com/sp';// URL without protocol but with directory as well
$sitepad['url'] = 'https://uttejpalavai.com/sp';
$sitepad['relativeurl'] = '/sp';
$sitepad['.sitepad'] = '/home/uttejpalavai';
$sitepad['sitepad_plugin_path'] = '/var/softaculous/sitepad';
$sitepad['editor_path'] = '/var/softaculous/sitepad/editor';
$sitepad['path'] = dirname(__FILE__);
$sitepad['AUTH_KEY'] = '28iafx8zwz5coijmss8cvgjzetlghnztyu6yj5qdwcpqixf6fqoymmzdpxnzyjgm';
$sitepad['SECURE_AUTH_KEY'] = 'b5vj42rzvuawmxyazxlggybupmyz237pf4lupnizvlpm2yxsse9zhc91pbzjqqon';
$sitepad['LOGGED_IN_KEY'] = 'mzzgsu6wso3ogs4qtgt6jor7bh0rfpfmohlydp0gct1inibdsgtt1q58bcnzvfwn';
$sitepad['NONCE_KEY'] = 'itu7om3hd0ykmhculijvhlwioe4bwrawgc22vtgwgrvdniry7wo420ecwiimxixm';
$sitepad['AUTH_SALT'] = 'xnctzedyedkjxev2kieowzjtauadomukrzylyvl1ect4c2mwyytkgnpstzlz4gjz';
$sitepad['SECURE_AUTH_SALT'] = 'tr2vs6lrqy5f6przcdv7jivjzmcj5pwmzrrihhqwyp7pypjxwjrtwbvvhngwks2u';
$sitepad['LOGGED_IN_SALT'] = 'udpn1w5i6t8sz9vtyjxw5nkrax1diwbihlfp9izh5qz16hbrfeiwztmlpman2dvy';
$sitepad['NONCE_SALT'] = 'jt0rhvr1w613sicsohr17ubnrlpe0th2taxqftk1rikrqick9ddd8piupld8ldb7';

if(!include_once($sitepad['editor_path'].'/site-inc/bootstrap.php')){
	die('Could not include the bootstrap.php. One of the reasons could be open_basedir restriction !');
}

