<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Base Site URL
|--------------------------------------------------------------------------
|
| URL to your CodeIgniter root. Typically this will be your base URL,
| WITH a trailing slash:
|
|	http://example.com/
|
| WARNING: You MUST set this value!
|
| If it is not set, then CodeIgniter will try guess the protocol and path
| your installation, but due to security concerns the hostname will be set
| to $_SERVER['SERVER_ADDR'] if available, or localhost otherwise.
| The auto-detection mechanism exists only for convenience during
| development and MUST NOT be used in production!
|
| If you need to allow multiple domains, remember that this file is still
| a PHP script and you can easily do that on your own.
|
*/
// $config['base_url'] = '';
$baseUrl = str_replace('\\','/',dirname($_SERVER['SCRIPT_NAME']));
$baseUrl = trim($baseUrl,'/');
$config['base_url'] = empty($baseUrl) ? '/' : "/$baseUrl/";
// $config['base_url'] = 'http://localhost/platform';

/*
|--------------------------------------------------------------------------
| Index File
|--------------------------------------------------------------------------
|
| Typically this will be your index.php file, unless you've renamed it to
| something else. If you are using mod_rewrite to remove the page set this
| variable so that it is blank.
|
*/
$config['index_page'] = 'index.php';

/*
|--------------------------------------------------------------------------
| URI PROTOCOL
|--------------------------------------------------------------------------
|
| This item determines which server global should be used to retrieve the
| URI string.  The default setting of 'REQUEST_URI' works for most servers.
| If your links do not seem to work, try one of the other delicious flavors:
|
| 'REQUEST_URI'    Uses $_SERVER['REQUEST_URI']
| 'QUERY_STRING'   Uses $_SERVER['QUERY_STRING']
| 'PATH_INFO'      Uses $_SERVER['PATH_INFO']
|
| WARNING: If you set this to 'PATH_INFO', URIs will always be URL-decoded!
*/
$config['uri_protocol']	= 'REQUEST_URI';

/*
|--------------------------------------------------------------------------
| URL suffix
|--------------------------------------------------------------------------
|
| This option allows you to add a suffix to all URLs generated by CodeIgniter.
| For more information please see the user guide:
|
| https://codeigniter.com/user_guide/general/urls.html
*/
$config['url_suffix'] = '';

/*
|--------------------------------------------------------------------------
| Default Language
|--------------------------------------------------------------------------
|
| This determines which set of language files should be used. Make sure
| there is an available translation if you intend to use something other
| than english.
|
*/
$config['language']	= 'english';

/*
|--------------------------------------------------------------------------
| Default Character Set
|--------------------------------------------------------------------------
|
| This determines which character set is used by default in various methods
| that require a character set to be provided.
|
| See http://php.net/htmlspecialchars for a list of supported charsets.
|
*/
$config['charset'] = 'UTF-8';

/*
|--------------------------------------------------------------------------
| Enable/Disable System Hooks
|--------------------------------------------------------------------------
|
| If you would like to use the 'hooks' feature you must enable it by
| setting this variable to TRUE (boolean).  See the user guide for details.
|
*/
$config['enable_hooks'] = FALSE;

/*
|--------------------------------------------------------------------------
| Class Extension Prefix
|--------------------------------------------------------------------------
|
| This item allows you to set the filename/classname prefix when extending
| native libraries.  For more information please see the user guide:
|
| https://codeigniter.com/user_guide/general/core_classes.html
| https://codeigniter.com/user_guide/general/creating_libraries.html
|
*/
$config['subclass_prefix'] = 'MY_';

/*
|--------------------------------------------------------------------------
| Composer auto-loading
|--------------------------------------------------------------------------
|
| Enabling this setting will tell CodeIgniter to look for a Composer
| package auto-loader script in application/vendor/autoload.php.
|
|	$config['composer_autoload'] = TRUE;
|
| Or if you have your vendor/ directory located somewhere else, you
| can opt to set a specific path as well:
|
|	$config['composer_autoload'] = '/path/to/vendor/autoload.php';
|
| For more information about Composer, please visit http://getcomposer.org/
|
| Note: This will NOT disable or override the CodeIgniter-specific
|	autoloading (application/config/autoload.php)
*/
$config['composer_autoload'] = FALSE;

/*
|--------------------------------------------------------------------------
| Allowed URL Characters
|--------------------------------------------------------------------------
|
| This lets you specify which characters are permitted within your URLs.
| When someone tries to submit a URL with disallowed characters they will
| get a warning message.
|
| As a security measure you are STRONGLY encouraged to restrict URLs to
| as few characters as possible.  By default only these are allowed: a-z 0-9~%.:_-
|
| Leave blank to allow all characters -- but only if you are insane.
|
| The configured value is actually a regular expression character group
| and it will be executed as: ! preg_match('/^[<permitted_uri_chars>]+$/i
|
| DO NOT CHANGE THIS UNLESS YOU FULLY UNDERSTAND THE REPERCUSSIONS!!
|
*/
$config['permitted_uri_chars'] = 'a-z 0-9~%.:_\-';

/*
|--------------------------------------------------------------------------
| Enable Query Strings
|--------------------------------------------------------------------------
|
| By default CodeIgniter uses search-engine friendly segment based URLs:
| example.com/who/what/where/
|
| You can optionally enable standard query string based URLs:
| example.com?who=me&what=something&where=here
|
| Options are: TRUE or FALSE (boolean)
|
| The other items let you set the query string 'words' that will
| invoke your controllers and its functions:
| example.com/index.php?c=controller&m=function
|
| Please note that some of the helpers won't work as expected when
| this feature is enabled, since CodeIgniter is designed primarily to
| use segment based URLs.
|
*/
$config['enable_query_strings'] = FALSE;
$config['controller_trigger'] = 'c';
$config['function_trigger'] = 'm';
$config['directory_trigger'] = 'd';

/*
|--------------------------------------------------------------------------
| Allow $_GET array
|--------------------------------------------------------------------------
|
| By default CodeIgniter enables access to the $_GET array.  If for some
| reason you would like to disable it, set 'allow_get_array' to FALSE.
|
| WARNING: This feature is DEPRECATED and currently available only
|          for backwards compatibility purposes!
|
*/
$config['allow_get_array'] = TRUE;

/*
|--------------------------------------------------------------------------
| Error Logging Threshold
|--------------------------------------------------------------------------
|
| You can enable error logging by setting a threshold over zero. The
| threshold determines what gets logged. Threshold options are:
|
|	0 = Disables logging, Error logging TURNED OFF
|	1 = Error Messages (including PHP errors)
|	2 = Debug Messages
|	3 = Informational Messages
|	4 = All Messages
|
| You can also pass an array with threshold levels to show individual error types
|
| 	array(2) = Debug Messages, without Error Messages
|
| For a live site you'll usually only enable Errors (1) to be logged otherwise
| your log files will fill up very fast.
|
*/
$config['log_threshold'] = 0;

/*
|--------------------------------------------------------------------------
| Error Logging Directory Path
|--------------------------------------------------------------------------
|
| Leave this BLANK unless you would like to set something other than the default
| application/logs/ directory. Use a full server path with trailing slash.
|
*/
$config['log_path'] = '';

/*
|--------------------------------------------------------------------------
| Log File Extension
|--------------------------------------------------------------------------
|
| The default filename extension for log files. The default 'php' allows for
| protecting the log files via basic scripting, when they are to be stored
| under a publicly accessible directory.
|
| Note: Leaving it blank will default to 'php'.
|
*/
$config['log_file_extension'] = '';

/*
|--------------------------------------------------------------------------
| Log File Permissions
|--------------------------------------------------------------------------
|
| The file system permissions to be applied on newly created log files.
|
| IMPORTANT: This MUST be an integer (no quotes) and you MUST use octal
|            integer notation (i.e. 0700, 0644, etc.)
*/
$config['log_file_permissions'] = 0644;

/*
|--------------------------------------------------------------------------
| Date Format for Logs
|--------------------------------------------------------------------------
|
| Each item that is logged has an associated date. You can use PHP date
| codes to set your own date formatting
|
*/
$config['log_date_format'] = 'Y-m-d H:i:s';

/*
|--------------------------------------------------------------------------
| Error Views Directory Path
|--------------------------------------------------------------------------
|
| Leave this BLANK unless you would like to set something other than the default
| application/views/errors/ directory.  Use a full server path with trailing slash.
|
*/
$config['error_views_path'] = '';

/*
|--------------------------------------------------------------------------
| Cache Directory Path
|--------------------------------------------------------------------------
|
| Leave this BLANK unless you would like to set something other than the default
| application/cache/ directory.  Use a full server path with trailing slash.
|
*/
$config['cache_path'] = '';

/*
|--------------------------------------------------------------------------
| Cache Include Query String
|--------------------------------------------------------------------------
|
| Whether to take the URL query string into consideration when generating
| output cache files. Valid options are:
|
|	FALSE      = Disabled
|	TRUE       = Enabled, take all query parameters into account.
|	             Please be aware that this may result in numerous cache
|	             files generated for the same page over and over again.
|	array('q') = Enabled, but only take into account the specified list
|	             of query parameters.
|
*/
$config['cache_query_string'] = FALSE;

/*
|--------------------------------------------------------------------------
| Encryption Key
|--------------------------------------------------------------------------
|
| If you use the Encryption class, you must set an encryption key.
| See the user guide for more info.
|
| https://codeigniter.com/user_guide/libraries/encryption.html
|
*/
$config['encryption_key'] = '';

/*
|--------------------------------------------------------------------------
| Session Variables
|--------------------------------------------------------------------------
|
| 'sess_driver'
|
|	The storage driver to use: files, database, redis, memcached
|
| 'sess_cookie_name'
|
|	The session cookie name, must contain only [0-9a-z_-] characters
|
| 'sess_expiration'
|
|	The number of SECONDS you want the session to last.
|	Setting to 0 (zero) means expire when the browser is closed.
|
| 'sess_save_path'
|
|	The location to save sessions to, driver dependent.
|
|	For the 'files' driver, it's a path to a writable directory.
|	WARNING: Only absolute paths are supported!
|
|	For the 'database' driver, it's a table name.
|	Please read up the manual for the format with other session drivers.
|
|	IMPORTANT: You are REQUIRED to set a valid save path!
|
| 'sess_match_ip'
|
|	Whether to match the user's IP address when reading the session data.
|
|	WARNING: If you're using the database driver, don't forget to update
|	         your session table's PRIMARY KEY when changing this setting.
|
| 'sess_time_to_update'
|
|	How many seconds between CI regenerating the session ID.
|
| 'sess_regenerate_destroy'
|
|	Whether to destroy session data associated with the old session ID
|	when auto-regenerating the session ID. When set to FALSE, the data
|	will be later deleted by the garbage collector.
|
| Other session cookie settings are shared with the rest of the application,
| except for 'cookie_prefix' and 'cookie_httponly', which are ignored here.
|
*/
$config['sess_driver'] = 'files';
$config['sess_cookie_name'] = 'ci_session';
$config['sess_expiration'] = 7200;
$config['sess_save_path'] = NULL;
$config['sess_match_ip'] = FALSE;
$config['sess_time_to_update'] = 300;
$config['sess_regenerate_destroy'] = FALSE;

/*
|--------------------------------------------------------------------------
| Cookie Related Variables
|--------------------------------------------------------------------------
|
| 'cookie_prefix'   = Set a cookie name prefix if you need to avoid collisions
| 'cookie_domain'   = Set to .your-domain.com for site-wide cookies
| 'cookie_path'     = Typically will be a forward slash
| 'cookie_secure'   = Cookie will only be set if a secure HTTPS connection exists.
| 'cookie_httponly' = Cookie will only be accessible via HTTP(S) (no javascript)
|
| Note: These settings (with the exception of 'cookie_prefix' and
|       'cookie_httponly') will also affect sessions.
|
*/
$config['cookie_prefix']	= '';
$config['cookie_domain']	= '';
$config['cookie_path']		= '/';
$config['cookie_secure']	= FALSE;
$config['cookie_httponly'] 	= FALSE;

/*
|--------------------------------------------------------------------------
| Standardize newlines
|--------------------------------------------------------------------------
|
| Determines whether to standardize newline characters in input data,
| meaning to replace \r\n, \r, \n occurrences with the PHP_EOL value.
|
| WARNING: This feature is DEPRECATED and currently available only
|          for backwards compatibility purposes!
|
*/
$config['standardize_newlines'] = FALSE;

/*
|--------------------------------------------------------------------------
| Global XSS Filtering
|--------------------------------------------------------------------------
|
| Determines whether the XSS filter is always active when GET, POST or
| COOKIE data is encountered
|
| WARNING: This feature is DEPRECATED and currently available only
|          for backwards compatibility purposes!
|
*/
$config['global_xss_filtering'] = FALSE;

/*
|--------------------------------------------------------------------------
| Cross Site Request Forgery
|--------------------------------------------------------------------------
| Enables a CSRF cookie token to be set. When set to TRUE, token will be
| checked on a submitted form. If you are accepting user data, it is strongly
| recommended CSRF protection be enabled.
|
| 'csrf_token_name' = The token name
| 'csrf_cookie_name' = The cookie name
| 'csrf_expire' = The number in seconds the token should expire.
| 'csrf_regenerate' = Regenerate token on every submission
| 'csrf_exclude_uris' = Array of URIs which ignore CSRF checks
*/
$config['csrf_protection'] = FALSE;
$config['csrf_token_name'] = 'csrf_test_name';
$config['csrf_cookie_name'] = 'csrf_cookie_name';
$config['csrf_expire'] = 7200;
$config['csrf_regenerate'] = TRUE;
$config['csrf_exclude_uris'] = array();

/*
|--------------------------------------------------------------------------
| Output Compression
|--------------------------------------------------------------------------
|
| Enables Gzip output compression for faster page loads.  When enabled,
| the output class will test whether your server supports Gzip.
| Even if it does, however, not all browsers support compression
| so enable only if you are reasonably sure your visitors can handle it.
|
| Only used if zlib.output_compression is turned off in your php.ini.
| Please do not use it together with httpd-level output compression.
|
| VERY IMPORTANT:  If you are getting a blank page when compression is enabled it
| means you are prematurely outputting something to your browser. It could
| even be a line of whitespace at the end of one of your scripts.  For
| compression to work, nothing can be sent before the output buffer is called
| by the output class.  Do not 'echo' any values with compression enabled.
|
*/
$config['compress_output'] = FALSE;

/*
|--------------------------------------------------------------------------
| Master Time Reference
|--------------------------------------------------------------------------
|
| Options are 'local' or any PHP supported timezone. This preference tells
| the system whether to use your server's local time as the master 'now'
| reference, or convert it to the configured one timezone. See the 'date
| helper' page of the user guide for information regarding date handling.
|
*/
$config['time_reference'] = 'local';

/*
|--------------------------------------------------------------------------
| Rewrite PHP Short Tags
|--------------------------------------------------------------------------
|
| If your PHP installation does not have short tag support enabled CI
| can rewrite the tags on-the-fly, enabling you to utilize that syntax
| in your view files.  Options are TRUE or FALSE (boolean)
|
| Note: You need to have eval() enabled for this to work.
|
*/
$config['rewrite_short_tags'] = FALSE;

/*
|--------------------------------------------------------------------------
| Reverse Proxy IPs
|--------------------------------------------------------------------------
|
| If your server is behind a reverse proxy, you must whitelist the proxy
| IP addresses from which CodeIgniter should trust headers such as
| HTTP_X_FORWARDED_FOR and HTTP_CLIENT_IP in order to properly identify
| the visitor's IP address.
|
| You can use both an array or a comma-separated list of proxy addresses,
| as well as specifying whole subnets. Here are a few examples:
|
| Comma-separated:	'10.0.1.200,192.168.5.0/24'
| Array:		array('10.0.1.200', '192.168.5.0/24')
*/
$config['proxy_ips'] = '';
/*
|--------------------------------------------------------------------------
| 自定义配置项
|--------------------------------------------------------------------------
| 配置翻页功能的每页最大数目
|
|
|
*/
$config['user_per_page'] = 10;
//艾特云平台登录页面url
$config['at_url'] = "http://localhost/atlogin/index.php/";
$config['msg_ip'] = "192.168.18.32";
//定义一些数组
$config['position_type_arr'] = array(array('code'=>'101','name'=>'安防班长'),array('code'=>'102','name'=>'环境班长'),array('code'=>'103','name'=>'电梯维保人员'),array('code'=>'104','name'=>'消防维保人员'),array('code'=>'105','name'=>'其他普通抢单人员'),array('code'=>'201','name'=>'管家'),array('code'=>'202','name'=>'工单管理员'),array('code'=>'301','name'=>'安防主管'),array('code'=>'302','name'=>'环境主管'),array('code'=>'303','name'=>'维修主管'),array('code'=>'999','name'=>'不参与工单处理'));
$config['position_grade_arr'] = array(array('code'=>'101','name'=>'总部职能'),array('code'=>'102','name'=>'总经理'),array('code'=>'103','name'=>'经理'),array('code'=>'104','name'=>'主管'),array('code'=>'105','name'=>'班长'),array('code'=>'106','name'=>'普通员工'));
$config['gender_arr'] = array(array('code'=>'101','name'=>'男'),array('code'=>'102','name'=>'女'));
$config['ethnicity_name_arr'] = array(array('code'=>'101','name'=>'汉族'),array('code'=>'102','name'=>'蒙古族'),array('code'=>'103','name'=>'回族'),array('code'=>'104','name'=>'藏族'),array('code'=>'105','name'=>'维吾尔族'),array('code'=>'106','name'=>'苗族'),array('code'=>'107','name'=>'彝族'),array('code'=>'108','name'=>'壮族'),array('code'=>'109','name'=>'布依族'),array('code'=>'110','name'=>'朝鲜族'),array('code'=>'111','name'=>'满族'),array('code'=>'112','name'=>'侗族'),array('code'=>'113','name'=>'瑶族'),array('code'=>'114','name'=>'白族'),array('code'=>'115','name'=>'土家族'),array('code'=>'116','name'=>'哈尼族'),array('code'=>'117','name'=>'哈萨克族'),array('code'=>'118','name'=>'傣族'),array('code'=>'119','name'=>'黎族'),array('code'=>'120','name'=>'僳僳族'),array('code'=>'121','name'=>'佤族'),array('code'=>'122','name'=>'畲族'),array('code'=>'123','name'=>'高山族'),array('code'=>'124','name'=>'拉祜族'),array('code'=>'125','name'=>'水族'),array('code'=>'126','name'=>'东乡族'),array('code'=>'127','name'=>'纳西族'),array('code'=>'128','name'=>'景颇族'),array('code'=>'129','name'=>'柯尔克孜族'),array('code'=>'130','name'=>'土族'),array('code'=>'131','name'=>'达斡尔族'),array('code'=>'132','name'=>'仫佬族'),array('code'=>'133','name'=>'羌族'),array('code'=>'134','name'=>'布朗族'),array('code'=>'135','name'=>'撒拉族'),array('code'=>'136','name'=>'毛南族'),array('code'=>'137','name'=>'仡佬族'),array('code'=>'138','name'=>'锡伯族'),array('code'=>'139','name'=>'阿昌族'),array('code'=>'140','name'=>'普米族'),array('code'=>'141','name'=>'塔吉克族'),array('code'=>'142','name'=>'怒族'),array('code'=>'143','name'=>'乌孜别克族'),array('code'=>'144','name'=>'俄罗斯族'),array('code'=>'145','name'=>'鄂温克族'),array('code'=>'146','name'=>'德昂族'),array('code'=>'147','name'=>'保安族'),array('code'=>'148','name'=>'裕固族'),array('code'=>'149','name'=>'京族'),array('code'=>'150','name'=>'塔塔尔族'),array('code'=>'151','name'=>'独龙族'),array('code'=>'152','name'=>'鄂伦春族'),array('code'=>'153','name'=>'赫哲族'),array('code'=>'154','name'=>'门巴族'),array('code'=>'155','name'=>'珞巴族'),array('code'=>'156','name'=>'基诺族'),array('code'=>'160','name'=>'其他'));
$config['blood_type_arr'] = array(array('code'=>'101','name'=>'A型'),array('code'=>'102','name'=>'B型'),array('code'=>'103','name'=>'AB型'),array('code'=>'104','name'=>'O型'),array('code'=>'105','name'=>'其他'));
$config['id_type_arr'] = array(array('code'=>'101','name'=>'身份证'),array('code'=>'102','name'=>'境外护照'),array('code'=>'103','name'=>'回乡证'),array('code'=>'104','name'=>'台胞证'),array('code'=>'105','name'=>'军官证/士兵证'));
$config['household_type_arr'] = array(array('code'=>'101','name'=>'户主'),array('code'=>'102','name'=>'家庭成员'),array('code'=>'103','name'=>'访客'),array('code'=>'104','name'=>'租客'));
$config['if_disabled_arr'] = array(array('code'=>'t','name'=>'是'),array('code'=>'f','name'=>'否'));
$config['business_type_arr'] = array(array('code'=>'101','name'=>'商铺产权人'),array('code'=>'102','name'=>'商户负责人'),array('code'=>'103','name'=>'商户服务人员'));
$config['msg_type_arr'] = array(array('code'=>'101','name'=>'社区公告'),array('code'=>'102','name'=>'住户通知'),array('code'=>'103','name'=>'社区新闻'));
$config['cycle_type_arr'] = array(array('code'=>'101','name'=>'每天一次'),array('code'=>'102','name'=>'每周一次'),array('code'=>'103','name'=>'双周一次'),array('code'=>'104','name'=>'每月一次'),array('code'=>'','name'=>'一次性消息'));
$config['msg_push_state'] = array(array('code'=>'0','name'=>'等待推送'),array('code'=>'1','name'=>'正在推送'),array('code'=>'2','name'=>'推送完成'));

$config['equipment_type_arr'] = array(array('code'=>'101','name'=>'供配电系统'),array('code'=>'102','name'=>'电梯系统'),array('code'=>'103','name'=>'空调系统'),array('code'=>'104','name'=>'给排水系统'),array('code'=>'105','name'=>'消防系统'),array('code'=>'106','name'=>'停车场系统'),array('code'=>'107','name'=>'综合布线系统'),array('code'=>'108','name'=>'门禁对讲系统'),array('code'=>'109','name'=>'视频监控系统'),array('code'=>'110','name'=>'安防系统'),array('code'=>'301','name'=>'中心机'),array('code'=>'302','name'=>'围墙机'),array('code'=>'303','name'=>'单元门口机'),array('code'=>'304','name'=>'别墅门口机'),array('code'=>'305','name'=>'室内机'),array('code'=>'306','name'=>'独立指纹机'),array('code'=>'307','name'=>'魔镜'));

$config['regular_check_arr'] = array(array('code'=>'101','name'=>'不需要巡检'),array('code'=>'102','name'=>'每年一次'),array('code'=>'103','name'=>'每三个月一次'),array('code'=>'104','name'=>'每月一次'),array('code'=>'105','name'=>'每两周一次'),array('code'=>'106','name'=>'每周一次'),array('code'=>'107','name'=>'每三天一次'),array('code'=>'108','name'=>'每天一次'),array('code'=>'109','name'=>'每12小时一次'));
$config['if_se_arr'] = array(array('code'=>'t','name'=>'是'),array('code'=>'f','name'=>'否'));
$config['effective_status_arr'] = array(array('code'=>'t','name'=>'有效'),array('code'=>'f','name'=>'无效'));
$config['annual_check_arr'] = array(array('code'=>'101','name'=>'不需要外审'),array('code'=>'102','name'=>'每年一次'));
$config['if_cycle_arr'] = array(array('code'=>'101','name'=>'一次性立即消息'),array('code'=>'102','name'=>'一次性定时消息'),array('code'=>'103','name'=>'循环消息'));
$config['qr_code_type_arr'] = array(array('code'=>'100','name'=>'设备网络配置'),array('code'=>'101','name'=>'设备'),array('code'=>'102','name'=>'楼宇地点'),array('code'=>'103','name'=>'社区活动'),array('code'=>'104','name'=>'物资'));
$config['equipment_type_sip_arr'] = array(array('code'=>'301','name'=>'c'),array('code'=>'302','name'=>'w'),array('code'=>'303','name'=>'d'),array('code'=>'304','name'=>'v'),array('code'=>'305','name'=>'g'),array('code'=>'306','name'=>'独立指纹机'),array('code'=>'307','name'=>'m'));
$config['brand_arr'] = array(array('code'=>'101','name'=>'德系品牌'),array('code'=>'102','name'=>'奥迪'),array('code'=>'103','name'=>'ALPINA'),array('code'=>'104','name'=>'宝马'),array('code'=>'105	奔驰','name'=>'奔驰'),array('code'=>'106','name'=>'保时捷'),array('code'=>'107','name'=>'宝沃'),array('code'=>'108','name'=>'大众'),array('code'=>'109','name'=>'smart'),array('code'=>'110','name'=>'日韩品牌'),array('code'=>'111','name'=>'本田'),array('code'=>'112','name'=>'丰田'),array('code'=>'113','name'=>'雷克萨斯'),array('code'=>'114','name'=>'铃木'),array('code'=>'115','name'=>'马自达'),array('code'=>'116','name'=>'讴歌'),array('code'=>'117','name'=>'日产'),array('code'=>'118','name'=>'斯巴鲁'),array('code'=>'119','name'=>'三菱'),array('code'=>'120','name'=>'五十铃'),array('code'=>'121','name'=>'英菲尼迪'),array('code'=>'122','name'=>'起亚'),array('code'=>'123','name'=>'双龙'),array('code'=>'124','name'=>'现代'),array('code'=>'125','name'=>'美系品牌'),array('code'=>'126','name'=>'别克'),array('code'=>'127','name'=>'道奇'),array('code'=>'128','name'=>'山姆'),array('code'=>'129','name'=>'Faraday Future'),array('code'=>'130','name'=>'GMC'),array('code'=>'131','name'=>'Jeep'),array('code'=>'132','name'=>'凯迪拉克'),array('code'=>'133','name'=>'克莱斯勒'),array('code'=>'134','name'=>'林肯'),array('code'=>'135','name'=>'宝沃'),array('code'=>'136','name'=>'特斯拉'),array('code'=>'137','name'=>'雪佛兰'),array('code'=>'138','name'=>'欧系其他'),array('code'=>'139','name'=>'标致'),array('code'=>'140','name'=>'DS'),array('code'=>'141','name'=>'雷诺'),array('code'=>'142','name'=>'雪铁龙'),array('code'=>'143','name'=>'阿斯顿•马丁'),array('code'=>'144','name'=>'宾利'),array('code'=>'145','name'=>'捷豹'),array('code'=>'146','name'=>'路虎'),array('code'=>'147','name'=>'劳斯莱斯'),array('code'=>'148','name'=>'MINI'),array('code'=>'149','name'=>'迈凯伦'),array('code'=>'150','name'=>'阿尔法•罗密欧'),array('code'=>'151','name'=>'菲亚特'),array('code'=>'152','name'=>'法拉利'),array('code'=>'153','name'=>'兰博基尼'),array('code'=>'154','name'=>'玛莎拉蒂'),array('code'=>'155','name'=>'依维柯'),array('code'=>'156','name'=>'Polestar'),array('code'=>'157','name'=>'沃尔沃'),array('code'=>'158','name'=>'斯柯达'),array('code'=>'159','name'=>'国产品牌'),array('code'=>'160','name'=>'ARCFOX'),array('code'=>'161','name'=>'宝骏'),array('code'=>'162','name'=>'比亚迪'),array('code'=>'163','name'=>'奔腾'),array('code'=>'164','name'=>'比速'),array('code'=>'165','name'=>'北汽绅宝'),array('code'=>'166','name'=>'北汽幻速'),array('code'=>'167','name'=>'北汽威旺'),array('code'=>'168','name'=>'北汽昌河'),array('code'=>'169','name'=>'北汽制造'),array('code'=>'170','name'=>'北汽道达'),array('code'=>'171','name'=>'北汽新能源'),array('code'=>'172','name'=>'北京'),array('code'=>'173','name'=>'长安'),array('code'=>'174','name'=>'长安欧尚'),array('code'=>'175','name'=>'长安轻型车'),array('code'=>'177','name'=>'长城'),array('code'=>'178','name'=>'东风风度'),array('code'=>'179','name'=>'东风风光'),array('code'=>'180','name'=>'东风风神'),array('code'=>'181','name'=>'东风风行'),array('code'=>'182','name'=>'东风小康'),array('code'=>'183','name'=>'东风'),array('code'=>'184','name'=>'东南'),array('code'=>'185','name'=>'电咖'),array('code'=>'186','name'=>'福迪'),array('code'=>'187','name'=>'福汽启腾'),array('code'=>'188','name'=>'福田'),array('code'=>'189','name'=>'广汽传祺'),array('code'=>'190','name'=>'广汽新能源'),array('code'=>'191','name'=>'观致'),array('code'=>'192','name'=>'国金'),array('code'=>'193','name'=>'哈弗'),array('code'=>'194','name'=>'海马'),array('code'=>'194','name'=>'海马'),array('code'=>'194','name'=>'海马'),array('code'=>'194','name'=>'海马'),array('code'=>'194','name'=>'海马'),array('code'=>'194','name'=>'海马'),array('code'=>'195','name'=>'汉腾'),array('code'=>'196','name'=>'红旗'),array('code'=>'197','name'=>'华泰'),array('code'=>'198','name'=>'黄海'),array('code'=>'199','name'=>'华骐'),array('code'=>'200','name'=>'华颂'),array('code'=>'201','name'=>'吉利'),array('code'=>'202','name'=>'江淮'),array('code'=>'202','name'=>'江淮'),array('code'=>'203','name'=>'捷途'),array('code'=>'204','name'=>'江铃'),array('code'=>'205','name'=>'金杯'),array('code'=>'206','name'=>'金龙'),array('code'=>'207','name'=>'九龙'),array('code'=>'207','name'=>'九龙'),array('code'=>'207','name'=>'九龙'),array('code'=>'208','name'=>'君马'),array('code'=>'209','name'=>'凯翼'),array('code'=>'210','name'=>'开瑞'),array('code'=>'211','name'=>'卡升'),array('code'=>'212','name'=>'卡威'),array('code'=>'213','name'=>'领克'),array('code'=>'214','name'=>'陆风'),array('code'=>'215','name'=>'力帆'),array('code'=>'216','name'=>'猎豹'),array('code'=>'217','name'=>'名爵'),array('code'=>'218','name'=>'纳智捷'),array('code'=>'219','name'=>'奇瑞'),array('code'=>'220','name'=>'启辰'),array('code'=>'221','name'=>'前途'),array('code'=>'222','name'=>'奇点汽车'),array('code'=>'223','name'=>'庆铃'),array('code'=>'223','name'=>'庆铃'),array('code'=>'223','name'=>'庆铃'),array('code'=>'224','name'=>'荣威'),array('code'=>'225','name'=>'SWM斯威'),array('code'=>'226','name'=>'上汽大通'),array('code'=>'227','name'=>'腾势'),array('code'=>'227','name'=>'腾势'),array('code'=>'227','name'=>'腾势'),array('code'=>'227','name'=>'腾势'),array('code'=>'228','name'=>'五菱'),array('code'=>'229','name'=>'WEY'),array('code'=>'230','name'=>'蔚来'),array('code'=>'231','name'=>'潍柴英致'),array('code'=>'232','name'=>'威马汽车'),array('code'=>'233','name'=>'小鹏汽车'),array('code'=>'234','name'=>'星驰'),array('code'=>'235','name'=>'驭胜'),array('code'=>'236','name'=>'野马'),array('code'=>'237','name'=>'一汽'),array('code'=>'237','name'=>'一汽'),array('code'=>'237','name'=>'一汽'),array('code'=>'238','name'=>'裕路'),array('code'=>'239','name'=>'云度'),array('code'=>'240','name'=>'众泰'),array('code'=>'240','name'=>'众泰'),array('code'=>'240','name'=>'众泰'),array('code'=>'241','name'=>'中华'),array('code'=>'242','name'=>'知豆'),array('code'=>'243','name'=>'之诺'),array('code'=>'244','name'=>'中兴'));
$config['material_type_arr'] = array(array('code'=>'101','name'=>'工程物资'),array('code'=>'102','name'=>'安防物资'),array('code'=>'103','name'=>'消防物资'),array('code'=>'104','name'=>'保洁物资'),array('code'=>'105','name'=>'办公物资'));








