<?php
/**
 * This file is part of webman.
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the MIT-LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @author    walkor<walkor@workerman.net>
 * @copyright walkor<walkor@workerman.net>
 * @link      http://www.workerman.net/
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */

use Webman\Route;


// config
Route::any('/config/system/{id:\d+}', [app\controller\Config\ConfigSystem::class, 'index']);
Route::any('/config/user/{id:\d+}', [app\controller\Config\ConfigUser::class, 'index']);
Route::any('/config/order/{id:\d+}', [app\controller\Config\ConfigOrder::class, 'index']);
Route::any('/config/sms/{id:\d+}', [app\controller\Config\ConfigSms::class, 'index']);
Route::any('/config/aliyun/{id:\d+}', [app\controller\Config\ConfigAliyun::class, 'index']);
Route::any('/config/tencent/{id:\d+}', [app\controller\Config\ConfigTencent::class, 'index']);
Route::any('/config/wechat/{id:\d+}', [app\controller\Config\ConfigWechat::class, 'index']);
Route::any('/config/qiniu/{id:\d+}', [app\controller\Config\ConfigQiniu::class, 'index']);
Route::any('/config/sande/{id:\d+}', [app\controller\Config\ConfigSande::class, 'index']);


Route::any('/config/order/mod/{id:\d+}', [app\controller\Config\ConfigOrder::class, 'mod']);
Route::any('/config/aliyun/mod/{id:\d+}', [app\controller\Config\ConfigAliyun::class, 'mod']);
Route::any('/config/sms/mod/{id:\d+}', [app\controller\Config\ConfigSms::class, 'mod']);
Route::any('/config/system/mod/{id:\d+}', [app\controller\Config\ConfigSystem::class, 'mod']);
Route::any('/config/tencent/mod/{id:\d+}', [app\controller\Config\ConfigTencent::class, 'mod']);
Route::any('/config/user/mod/{id:\d+}', [app\controller\Config\ConfigUser::class, 'mod']);
Route::any('/config/qiniu/mod/{id:\d+}', [app\controller\Config\ConfigQiniu::class, 'mod']);
Route::any('/config/sande/mod/{id:\d+}', [app\controller\Config\ConfigSande::class, 'mod']);

Route::any('/config/system/field', [app\controller\Config\ConfigSystem::class, 'field']);
Route::any('/config/user/field', [app\controller\Config\ConfigUser::class, 'field']);
Route::any('/config/order/field', [app\controller\Config\ConfigOrder::class, 'field']);
Route::any('/config/tencent/field', [app\controller\Config\ConfigTencent::class, 'field']);
Route::any('/config/qiniu/field', [app\controller\Config\ConfigQiniu::class, 'field']);

// record
Route::any('/record/sms[/{id:\d+}]', [app\controller\Record\RecordSms::class, 'index']);
Route::any('/record/sms/show', [app\controller\Record\RecordSms::class, 'show']);

// wechat
Route::any('/wechat/mod/{id:\d+}', [app\controller\Config\ConfigWechat::class, 'mod']);
// wechat-api
Route::any('/wechat/oauth', [app\controller\Api\Wechat\Wechat::class, 'oauth']);
Route::any('/wechat/order', [app\controller\Api\Wechat\Wechat::class, 'order']);
Route::any('/wechat/sign', [app\controller\Api\Wechat\Wechat::class, 'sign']);

// city
Route::any('/city', [app\controller\City\City::class, 'index']);
Route::any('/city/{id:\d+}', [app\controller\City\City::class, 'index']);
Route::any('/city/show', [app\controller\City\City::class, 'show']);
Route::any('/city/map', [app\controller\City\City::class, 'map']);
Route::any('/city/all', [app\controller\City\City::class, 'all']);
Route::any('/city/list', [app\controller\City\City::class, 'list']);
Route::any('/city/parent/{pid:\d+}', [app\controller\City\City::class, 'parent']);
Route::any('/city/child', [app\controller\City\City::class, 'child']);
Route::any('/city/sort', [app\controller\City\City::class, 'sort']);
Route::any('/city/add', [app\controller\City\City::class, 'add']);
Route::any('/city/mod', [app\controller\City\City::class, 'mod']);
Route::any('/city/save', [app\controller\City\City::class, 'save']);
Route::any('/city/del', [app\controller\City\City::class, 'del']);
Route::any('/city/remove', [app\controller\City\City::class, 'remove']);

// module
Route::any('/module', [app\controller\Module\Module::class, 'index']);
Route::any('/module/{id:\d+}', [app\controller\Module\Module::class, 'index']);
Route::any('/module/show', [app\controller\Module\Module::class, 'show']);
Route::any('/module/map', [app\controller\Module\Module::class, 'map']);
Route::any('/module/all', [app\controller\Module\Module::class, 'all']);
Route::any('/module/list', [app\controller\Module\Module::class, 'list']);
Route::any('/module/child', [app\controller\Module\Module::class, 'child']);
Route::any('/module/sort', [app\controller\Module\Module::class, 'sort']);
Route::any('/module/add', [app\controller\Module\Module::class, 'add']);
Route::any('/module/mod', [app\controller\Module\Module::class, 'mod']);
Route::any('/module/save', [app\controller\Module\Module::class, 'save']);
Route::any('/module/del', [app\controller\Module\Module::class, 'del']);
Route::any('/module/remove', [app\controller\Module\Module::class, 'remove']);

// handle
Route::any('/handle', [app\controller\Module\Handle::class, 'index']);
Route::any('/handle/{id:\d+}', [app\controller\Module\Handle::class, 'index']);
Route::any('/handle/show', [app\controller\Module\Handle::class, 'show']);
Route::any('/handle/map', [app\controller\Module\Handle::class, 'map']);
Route::any('/handle/all', [app\controller\Module\Handle::class, 'all']);
Route::any('/handle/list', [app\controller\Module\Handle::class, 'list']);
Route::any('/handle/child', [app\controller\Module\Handle::class, 'child']);
Route::any('/handle/sort', [app\controller\Module\Handle::class, 'sort']);
Route::any('/handle/add', [app\controller\Module\Handle::class, 'add']);
Route::any('/handle/mod', [app\controller\Module\Handle::class, 'mod']);
Route::any('/handle/save', [app\controller\Module\Handle::class, 'save']);
Route::any('/handle/del', [app\controller\Module\Handle::class, 'del']);
Route::any('/handle/remove', [app\controller\Module\Handle::class, 'remove']);

// charset
Route::any('/charset', [app\controller\Module\Charset::class, 'index']);
Route::any('/charset/{id:\d+}', [app\controller\Module\Charset::class, 'index']);
Route::any('/charset/show', [app\controller\Module\Charset::class, 'show']);
Route::any('/charset/map', [app\controller\Module\Charset::class, 'map']);
Route::any('/charset/all', [app\controller\Module\Charset::class, 'all']);
Route::any('/charset/list', [app\controller\Module\Charset::class, 'list']);
Route::any('/charset/child', [app\controller\Module\Charset::class, 'child']);
Route::any('/charset/sort', [app\controller\Module\Charset::class, 'sort']);
Route::any('/charset/add', [app\controller\Module\Charset::class, 'add']);
Route::any('/charset/mod', [app\controller\Module\Charset::class, 'mod']);
Route::any('/charset/save', [app\controller\Module\Charset::class, 'save']);
Route::any('/charset/del', [app\controller\Module\Charset::class, 'del']);
Route::any('/charset/remove', [app\controller\Module\Charset::class, 'remove']);

// collate
Route::any('/collate', [app\controller\Module\Collate::class, 'index']);
Route::any('/collate/{id:\d+}', [app\controller\Module\Collate::class, 'index']);
Route::any('/collate/show', [app\controller\Module\Collate::class, 'show']);
Route::any('/collate/map', [app\controller\Module\Collate::class, 'map']);
Route::any('/collate/all', [app\controller\Module\Collate::class, 'all']);
Route::any('/collate/list', [app\controller\Module\Collate::class, 'list']);
Route::any('/collate/child', [app\controller\Module\Collate::class, 'child']);
Route::any('/collate/sort', [app\controller\Module\Collate::class, 'sort']);
Route::any('/collate/add', [app\controller\Module\Collate::class, 'add']);
Route::any('/collate/mod', [app\controller\Module\Collate::class, 'mod']);
Route::any('/collate/save', [app\controller\Module\Collate::class, 'save']);
Route::any('/collate/del', [app\controller\Module\Collate::class, 'del']);
Route::any('/collate/remove', [app\controller\Module\Collate::class, 'remove']);

// engine
Route::any('/engine', [app\controller\Module\Engine::class, 'index']);
Route::any('/engine/{id:\d+}', [app\controller\Module\Engine::class, 'index']);
Route::any('/engine/show', [app\controller\Module\Engine::class, 'show']);
Route::any('/engine/map', [app\controller\Module\Engine::class, 'map']);
Route::any('/engine/all', [app\controller\Module\Engine::class, 'all']);
Route::any('/engine/list', [app\controller\Module\Engine::class, 'list']);
Route::any('/engine/child', [app\controller\Module\Engine::class, 'child']);
Route::any('/engine/sort', [app\controller\Module\Engine::class, 'sort']);
Route::any('/engine/add', [app\controller\Module\Engine::class, 'add']);
Route::any('/engine/mod', [app\controller\Module\Engine::class, 'mod']);
Route::any('/engine/save', [app\controller\Module\Engine::class, 'save']);
Route::any('/engine/del', [app\controller\Module\Engine::class, 'del']);
Route::any('/engine/remove', [app\controller\Module\Engine::class, 'remove']);


// user
// Route::any('/user', [app\controller\User\User::class, 'index']);
Route::any('/user[/{id:\d+}]', [app\controller\User\User::class, 'index']);
Route::any('/reg', [app\controller\User\Reg::class, 'index']);
Route::any('/login', [app\controller\User\Login::class, 'index']);
Route::any('/user/auth', [app\controller\User\User::class, 'auth']);
Route::any('/user/secure', [app\controller\User\User::class, 'secure']);
Route::any('/user/parent/{id}', [app\controller\User\User::class, 'parent']);
Route::any('/user/child/{id}', [app\controller\User\User::class, 'child']);
Route::any('/user/show', [app\controller\User\User::class, 'show']);
Route::any('/user/contact[/{id:\d+}]', [app\controller\User\User::class, 'contact']);
Route::any('/user/invite', [app\controller\User\User::class, 'invite']);
Route::any('/user/inviter', [app\controller\User\User::class, 'inviter']);
Route::any('/user/check', [app\controller\User\User::class, 'check']);
Route::any('/user/priority', [app\controller\User\User::class, 'priority']);
Route::any('/user/map', [app\controller\User\User::class, 'map']);
Route::any('/user/all', [app\controller\User\User::class, 'all']);
Route::any('/user/list', [app\controller\User\User::class, 'list']);
Route::any('/user/test', [app\controller\User\User::class, 'test']);
Route::any('/user/add', [app\controller\User\User::class, 'add']);
Route::any('/user/mod', [app\controller\User\User::class, 'mod']);
Route::any('/user/forget', [app\controller\User\User::class, 'forget']);
Route::any('/user/pass', [app\controller\User\User::class, 'pass']);
Route::any('/user/modpwd', [app\controller\User\User::class, 'modpwd']);
Route::any('/user/modinfo', [app\controller\User\User::class, 'modinfo']);
Route::any('/user/charge', [app\controller\User\User::class, 'charge']);
Route::any('/user/lock', [app\controller\User\User::class, 'lock']);
Route::any('/user/unlock/{id:\d+}', [app\controller\User\User::class, 'unlock']);
Route::any('/user/save', [app\controller\User\User::class, 'save']);
Route::any('/user/del', [app\controller\User\User::class, 'del']);
Route::any('/user/remove', [app\controller\User\User::class, 'remove']);
Route::any('/user/export', [app\controller\User\User::class, 'export']);

// priority
Route::any('/priority', [app\controller\User\UserPriority::class, 'index']);
Route::any('/priority/{id:\d+}', [app\controller\User\UserPriority::class, 'index']);
Route::any('/priority/show', [app\controller\User\UserPriority::class, 'show']);
Route::any('/priority/map', [app\controller\User\UserPriority::class, 'map']);
Route::any('/priority/batch', [app\controller\User\UserPriority::class, 'batch']);
Route::any('/priority/all', [app\controller\User\UserPriority::class, 'all']);
Route::any('/priority/list', [app\controller\User\UserPriority::class, 'list']);
Route::any('/priority/child', [app\controller\User\UserPriority::class, 'child']);
Route::any('/priority/sort', [app\controller\User\UserPriority::class, 'sort']);
Route::any('/priority/add', [app\controller\User\UserPriority::class, 'add']);
Route::any('/priority/mod', [app\controller\User\UserPriority::class, 'mod']);
Route::any('/priority/save', [app\controller\User\UserPriority::class, 'save']);
Route::any('/priority/del', [app\controller\User\UserPriority::class, 'del']);
Route::any('/priority/remove', [app\controller\User\UserPriority::class, 'remove']);

// role
Route::any('/role', [app\controller\Role\Role::class, 'index']);
Route::any('/role/{id:\d+}', [app\controller\Role\Role::class, 'index']);
Route::any('/role/show', [app\controller\Role\Role::class, 'show']);
Route::any('/role/map', [app\controller\Role\Role::class, 'map']);
Route::any('/role/all', [app\controller\Role\Role::class, 'all']);
Route::any('/role/list', [app\controller\Role\Role::class, 'list']);
Route::any('/role/child', [app\controller\Role\Role::class, 'child']);
Route::any('/role/sort', [app\controller\Role\Role::class, 'sort']);
Route::any('/role/add', [app\controller\Role\Role::class, 'add']);
Route::any('/role/mod', [app\controller\Role\Role::class, 'mod']);
Route::any('/role/save', [app\controller\Role\Role::class, 'save']);
Route::any('/role/del', [app\controller\Role\Role::class, 'del']);
Route::any('/role/remove', [app\controller\Role\Role::class, 'remove']);

// menu
Route::any('/menu', [app\controller\Menu\Menu::class, 'index']);
Route::any('/menu/{id:\d+}', [app\controller\Menu\Menu::class, 'index']);
Route::any('/menu/show', [app\controller\Menu\Menu::class, 'show']);
Route::any('/menu/map', [app\controller\Menu\Menu::class, 'map']);
Route::any('/menu/all', [app\controller\Menu\Menu::class, 'all']);
Route::any('/menu/list', [app\controller\Menu\Menu::class, 'list']);
Route::any('/menu/grant', [app\controller\Menu\Menu::class, 'grant']);
Route::any('/menu/role', [app\controller\Menu\Menu::class, 'role']);
Route::any('/menu/tree', [app\controller\Menu\Menu::class, 'tree']);
Route::any('/menu/child', [app\controller\Menu\Menu::class, 'child']);
Route::any('/menu/sort', [app\controller\Menu\Menu::class, 'sort']);
Route::any('/menu/add', [app\controller\Menu\Menu::class, 'add']);
Route::any('/menu/mod', [app\controller\Menu\Menu::class, 'mod']);
Route::any('/menu/save', [app\controller\Menu\Menu::class, 'save']);
Route::any('/menu/del', [app\controller\Menu\Menu::class, 'del']);
Route::any('/menu/remove', [app\controller\Menu\Menu::class, 'remove']);

// issuer
Route::any('/issuer[/{id:\d+}]', [app\controller\Issuer\Issuer::class, 'index']);
Route::any('/issuer/show', [app\controller\Issuer\Issuer::class, 'show']);
Route::any('/issuer/map', [app\controller\Issuer\Issuer::class, 'map']);
Route::any('/issuer/all', [app\controller\Issuer\Issuer::class, 'all']);
Route::any('/issuer/list', [app\controller\Issuer\Issuer::class, 'list']);
Route::any('/issuer/add', [app\controller\Issuer\Issuer::class, 'add']);
Route::any('/issuer/mod', [app\controller\Issuer\Issuer::class, 'mod']);
Route::any('/issuer/save', [app\controller\Issuer\Issuer::class, 'save']);
Route::any('/issuer/del', [app\controller\Issuer\Issuer::class, 'del']);
Route::any('/issuer/remove', [app\controller\Issuer\Issuer::class, 'remove']);

// bank
Route::any('/bank', [app\controller\Bank\Bank::class, 'index']);
Route::any('/bank/{id:\d+}', [app\controller\Bank\Bank::class, 'index']);
Route::any('/bank/show', [app\controller\Bank\Bank::class, 'show']);
Route::any('/bank/map', [app\controller\Bank\Bank::class, 'map']);
Route::any('/bank/all', [app\controller\Bank\Bank::class, 'all']);
Route::any('/bank/list', [app\controller\Bank\Bank::class, 'list']);
Route::any('/bank/add', [app\controller\Bank\Bank::class, 'add']);
Route::any('/bank/mod', [app\controller\Bank\Bank::class, 'mod']);
Route::any('/bank/save', [app\controller\Bank\Bank::class, 'save']);
Route::any('/bank/del', [app\controller\Bank\Bank::class, 'del']);
Route::any('/bank/remove', [app\controller\Bank\Bank::class, 'remove']);

// unit
Route::any('/unit', [app\controller\Unit\Unit::class, 'index']);
Route::any('/unit/{id:\d+}', [app\controller\Unit\Unit::class, 'index']);
Route::any('/unit/show', [app\controller\Unit\Unit::class, 'show']);
Route::any('/unit/map', [app\controller\Unit\Unit::class, 'map']);
Route::any('/unit/all', [app\controller\Unit\Unit::class, 'all']);
Route::any('/unit/list', [app\controller\Unit\Unit::class, 'list']);
Route::any('/unit/add', [app\controller\Unit\Unit::class, 'add']);
Route::any('/unit/mod', [app\controller\Unit\Unit::class, 'mod']);
Route::any('/unit/save', [app\controller\Unit\Unit::class, 'save']);
Route::any('/unit/del', [app\controller\Unit\Unit::class, 'del']);
Route::any('/unit/remove', [app\controller\Unit\Unit::class, 'remove']);

// news
Route::any('/news[/{id:\d+}]', [app\controller\News\News::class, 'index']);
Route::any('/news/show', [app\controller\News\News::class, 'show']);
Route::any('/news/map', [app\controller\News\News::class, 'map']);
Route::any('/news/all', [app\controller\News\News::class, 'all']);
Route::any('/news/list', [app\controller\News\News::class, 'list']);
Route::any('/news/add', [app\controller\News\News::class, 'add']);
Route::any('/news/mod', [app\controller\News\News::class, 'mod']);
Route::any('/news/save', [app\controller\News\News::class, 'save']);
Route::any('/news/del', [app\controller\News\News::class, 'del']);
Route::any('/news/remove', [app\controller\News\News::class, 'remove']);

// news_cate
Route::any('/news_cate[/{id:\d+}]', [app\controller\News\NewsCate::class, 'index']);
Route::any('/news_cate/show', [app\controller\News\NewsCate::class, 'show']);
Route::any('/news_cate/map', [app\controller\News\NewsCate::class, 'map']);
Route::any('/news_cate/all', [app\controller\News\NewsCate::class, 'all']);
Route::any('/news_cate/list', [app\controller\News\NewsCate::class, 'list']);
Route::any('/news_cate/add', [app\controller\News\NewsCate::class, 'add']);
Route::any('/news_cate/mod', [app\controller\News\NewsCate::class, 'mod']);
Route::any('/news_cate/save', [app\controller\News\NewsCate::class, 'save']);
Route::any('/news_cate/del', [app\controller\News\NewsCate::class, 'del']);
Route::any('/news_cate/remove', [app\controller\News\NewsCate::class, 'remove']);

// activity
Route::any('/activity[/{id:\d+}]', [app\controller\Activity\Activity::class, 'index']);
Route::any('/activity/show', [app\controller\Activity\Activity::class, 'show']);
Route::any('/activity/map', [app\controller\Activity\Activity::class, 'map']);
Route::any('/activity/cate/{cid:\d+}', [app\controller\Activity\Activity::class, 'cate']);
Route::any('/activity/all', [app\controller\Activity\Activity::class, 'all']);
Route::any('/activity/top[/{cid:\d+}]', [app\controller\Activity\Activity::class, 'top']);
Route::any('/activity/list', [app\controller\Activity\Activity::class, 'list']);
Route::any('/activity/add', [app\controller\Activity\Activity::class, 'add']);
Route::any('/activity/mod', [app\controller\Activity\Activity::class, 'mod']);
Route::any('/activity/save', [app\controller\Activity\Activity::class, 'save']);
Route::any('/activity/del', [app\controller\Activity\Activity::class, 'del']);
Route::any('/activity/remove', [app\controller\Activity\Activity::class, 'remove']);

// vote
Route::any('/vote[/{id:\d+}]', [app\controller\Activity\VoteGoods::class, 'index']);
Route::any('/vote/show', [app\controller\Activity\VoteGoods::class, 'show']);
Route::any('/vote/map', [app\controller\Activity\VoteGoods::class, 'map']);
Route::any('/vote/cate/{cid:\d+}', [app\controller\Activity\VoteGoods::class, 'cate']);
Route::any('/vote/all', [app\controller\Activity\VoteGoods::class, 'all']);
Route::any('/vote/list', [app\controller\Activity\VoteGoods::class, 'list']);
Route::any('/vote/add', [app\controller\Activity\VoteGoods::class, 'add']);
Route::any('/vote/mod', [app\controller\Activity\VoteGoods::class, 'mod']);
Route::any('/vote/save', [app\controller\Activity\VoteGoods::class, 'save']);
Route::any('/vote/del', [app\controller\Activity\VoteGoods::class, 'del']);
Route::any('/vote/remove', [app\controller\Activity\VoteGoods::class, 'remove']);

// record_vote
Route::any('/record/vote[/{id:\d+}]', [app\controller\Activity\RecordVote::class, 'index']);
Route::any('/record/vote/show', [app\controller\Activity\RecordVote::class, 'show']);
Route::any('/record/vote/map', [app\controller\Activity\RecordVote::class, 'map']);
Route::any('/record/vote/cate/{cid:\d+}', [app\controller\Activity\RecordVote::class, 'cate']);
Route::any('/record/vote/all', [app\controller\Activity\RecordVote::class, 'all']);
Route::any('/record/vote/list', [app\controller\Activity\RecordVote::class, 'list']);
Route::any('/record/vote/add', [app\controller\Activity\RecordVote::class, 'add']);
Route::any('/record/vote/mod', [app\controller\Activity\RecordVote::class, 'mod']);
Route::any('/record/vote/save', [app\controller\Activity\RecordVote::class, 'save']);
Route::any('/record/vote/del', [app\controller\Activity\RecordVote::class, 'del']);
Route::any('/record/vote/remove', [app\controller\Activity\RecordVote::class, 'remove']);

// activity_cate
Route::any('/activity_cate[/{id:\d+}]', [app\controller\Activity\ActivityCate::class, 'index']);
Route::any('/activity_cate/show', [app\controller\Activity\ActivityCate::class, 'show']);
Route::any('/activity_cate/map', [app\controller\Activity\ActivityCate::class, 'map']);
Route::any('/activity_cate/all', [app\controller\Activity\ActivityCate::class, 'all']);
Route::any('/activity_cate/list', [app\controller\Activity\ActivityCate::class, 'list']);
Route::any('/activity_cate/add', [app\controller\Activity\ActivityCate::class, 'add']);
Route::any('/activity_cate/mod', [app\controller\Activity\ActivityCate::class, 'mod']);
Route::any('/activity_cate/save', [app\controller\Activity\ActivityCate::class, 'save']);
Route::any('/activity_cate/del', [app\controller\Activity\ActivityCate::class, 'del']);
Route::any('/activity_cate/remove', [app\controller\Activity\ActivityCate::class, 'remove']);

// article
Route::any('/article[/{id:\d+}]', [app\controller\Article\Article::class, 'index']);
Route::any('/article/show', [app\controller\Article\Article::class, 'show']);
Route::any('/article/map', [app\controller\Article\Article::class, 'map']);
Route::any('/article/all', [app\controller\Article\Article::class, 'all']);
Route::any('/article/list', [app\controller\Article\Article::class, 'list']);
Route::any('/article/add', [app\controller\Article\Article::class, 'add']);
Route::any('/article/mod', [app\controller\Article\Article::class, 'mod']);
Route::any('/article/save', [app\controller\Article\Article::class, 'save']);
Route::any('/article/del', [app\controller\Article\Article::class, 'del']);
Route::any('/article/remove', [app\controller\Article\Article::class, 'remove']);

// article_cate
Route::any('/article_cate[/{id:\d+}]', [app\controller\Article\ArticleCate::class, 'index']);
Route::any('/article_cate/show', [app\controller\Article\ArticleCate::class, 'show']);
Route::any('/article_cate/map', [app\controller\Article\ArticleCate::class, 'map']);
Route::any('/article_cate/all', [app\controller\Article\ArticleCate::class, 'all']);
Route::any('/article_cate/list', [app\controller\Article\ArticleCate::class, 'list']);
Route::any('/article_cate/add', [app\controller\Article\ArticleCate::class, 'add']);
Route::any('/article_cate/mod', [app\controller\Article\ArticleCate::class, 'mod']);
Route::any('/article_cate/save', [app\controller\Article\ArticleCate::class, 'save']);
Route::any('/article_cate/del', [app\controller\Article\ArticleCate::class, 'del']);
Route::any('/article_cate/remove', [app\controller\Article\ArticleCate::class, 'remove']);

// Notice
Route::any('/notice[/{id:\d+}]', [app\controller\Notice\Notice::class, 'index']);
Route::any('/notice/show', [app\controller\Notice\Notice::class, 'show']);
Route::any('/notice/map', [app\controller\Notice\Notice::class, 'map']);
Route::any('/notice/all', [app\controller\Notice\Notice::class, 'all']);
Route::any('/notice/list', [app\controller\Notice\Notice::class, 'list']);
Route::any('/notice/add', [app\controller\Notice\Notice::class, 'add']);
Route::any('/notice/mod', [app\controller\Notice\Notice::class, 'mod']);
Route::any('/notice/save', [app\controller\Notice\Notice::class, 'save']);
Route::any('/notice/del', [app\controller\Notice\Notice::class, 'del']);
Route::any('/notice/remove', [app\controller\Notice\Notice::class, 'remove']);

// Message
Route::any('/message[/{id:\d+}]', [app\controller\Message\Message::class, 'index']);
Route::any('/message/show', [app\controller\Message\Message::class, 'show']);
Route::any('/message/map', [app\controller\Message\Message::class, 'map']);
Route::any('/message/all', [app\controller\Message\Message::class, 'all']);
Route::any('/message/list', [app\controller\Message\Message::class, 'list']);
Route::any('/message/add', [app\controller\Message\Message::class, 'add']);
Route::any('/message/mod', [app\controller\Message\Message::class, 'mod']);
Route::any('/message/save', [app\controller\Message\Message::class, 'save']);
Route::any('/message/del', [app\controller\Message\Message::class, 'del']);
Route::any('/message/remove', [app\controller\Message\Message::class, 'remove']);

// Poster
Route::any('/poster[/{id:\d+}]', [app\controller\Poster\Poster::class, 'index']);
Route::any('/poster/show', [app\controller\Poster\Poster::class, 'show']);
Route::any('/poster/map', [app\controller\Poster\Poster::class, 'map']);
Route::any('/poster/all', [app\controller\Poster\Poster::class, 'all']);
Route::any('/poster/list', [app\controller\Poster\Poster::class, 'list']);
Route::any('/poster/add', [app\controller\Poster\Poster::class, 'add']);
Route::any('/poster/mod', [app\controller\Poster\Poster::class, 'mod']);
Route::any('/poster/save', [app\controller\Poster\Poster::class, 'save']);
Route::any('/poster/del', [app\controller\Poster\Poster::class, 'del']);
Route::any('/poster/remove', [app\controller\Poster\Poster::class, 'remove']);

// Currency
// Route::any('/currency', [app\controller\Currency\Currency::class, 'index']);
Route::any('/currency[/{id:\d+}]', [app\controller\Currency\Currency::class, 'index']);
Route::any('/currency/show', [app\controller\Currency\Currency::class, 'show']);
Route::any('/currency/map', [app\controller\Currency\Currency::class, 'map']);
Route::any('/currency/all', [app\controller\Currency\Currency::class, 'all']);
Route::any('/currency/list', [app\controller\Currency\Currency::class, 'list']);
Route::any('/currency/add', [app\controller\Currency\Currency::class, 'add']);
Route::any('/currency/mod', [app\controller\Currency\Currency::class, 'mod']);
Route::any('/currency/save', [app\controller\Currency\Currency::class, 'save']);
Route::any('/currency/del', [app\controller\Currency\Currency::class, 'del']);
Route::any('/currency/remove', [app\controller\Currency\Currency::class, 'remove']);

// goods
Route::any('/goods[/{id:\d+}]', [app\controller\Goods\Goods::class, 'index']);
Route::any('/goods/one/{id:\d+}', [app\controller\Goods\Goods::class, 'one']);
Route::any('/goods/cate/{cid}', [app\controller\Goods\Goods::class, 'cate']);
Route::any('/goods/cates', [app\controller\Goods\Goods::class, 'cates']);
Route::any('/goods/show', [app\controller\Goods\Goods::class, 'show']);
Route::any('/goods/map', [app\controller\Goods\Goods::class, 'map']);
Route::any('/goods/all', [app\controller\Goods\Goods::class, 'all']);
Route::any('/goods/issue', [app\controller\Goods\Goods::class, 'issue']);
Route::any('/goods/hash[/{id:\d+}]', [app\controller\Goods\Goods::class, 'hash']);
Route::any('/goods/sale', [app\controller\Goods\Goods::class, 'sale']);
Route::any('/goods/list', [app\controller\Goods\Goods::class, 'list']);
Route::any('/goods/add', [app\controller\Goods\Goods::class, 'add']);
Route::any('/goods/mod', [app\controller\Goods\Goods::class, 'mod']);
Route::any('/goods/save', [app\controller\Goods\Goods::class, 'save']);
Route::any('/goods/del', [app\controller\Goods\Goods::class, 'del']);
Route::any('/goods/remove', [app\controller\Goods\Goods::class, 'remove']);
Route::any('/goods/airpop', [app\controller\Goods\Goods::class, 'airpop']);

// goods_cate
Route::any('/cate', [app\controller\Goods\GoodsCate::class, 'index']);
Route::any('/cate/{id:\d+}', [app\controller\Goods\GoodsCate::class, 'index']);
Route::any('/cate/show', [app\controller\Goods\GoodsCate::class, 'show']);
Route::any('/cate/map', [app\controller\Goods\GoodsCate::class, 'map']);
Route::any('/cate/all', [app\controller\Goods\GoodsCate::class, 'all']);
Route::any('/cate/list', [app\controller\Goods\GoodsCate::class, 'list']);
Route::any('/cate/add', [app\controller\Goods\GoodsCate::class, 'add']);
Route::any('/cate/mod', [app\controller\Goods\GoodsCate::class, 'mod']);
Route::any('/cate/save', [app\controller\Goods\GoodsCate::class, 'save']);
Route::any('/cate/del', [app\controller\Goods\GoodsCate::class, 'del']);
Route::any('/cate/remove', [app\controller\Goods\GoodsCate::class, 'remove']);
Route::any('/cate/clear', [app\controller\Goods\GoodsCate::class, 'clear']);

// goods_tags
Route::any('/tags', [app\controller\Goods\GoodsTags::class, 'index']);
Route::any('/tags/{id:\d+}', [app\controller\Goods\GoodsTags::class, 'index']);
Route::any('/tags/show', [app\controller\Goods\GoodsTags::class, 'show']);
Route::any('/tags/map', [app\controller\Goods\GoodsTags::class, 'map']);
Route::any('/tags/all', [app\controller\Goods\GoodsTags::class, 'all']);
Route::any('/tags/list', [app\controller\Goods\GoodsTags::class, 'list']);
Route::any('/tags/add', [app\controller\Goods\GoodsTags::class, 'add']);
Route::any('/tags/mod', [app\controller\Goods\GoodsTags::class, 'mod']);
Route::any('/tags/save', [app\controller\Goods\GoodsTags::class, 'save']);
Route::any('/tags/del', [app\controller\Goods\GoodsTags::class, 'del']);
Route::any('/tags/remove', [app\controller\Goods\GoodsTags::class, 'remove']);

// brand
Route::any('/brand', [app\controller\Brand\Brand::class, 'index']);
Route::any('/brand/{id:\d+}', [app\controller\Brand\Brand::class, 'index']);
Route::any('/brand/show', [app\controller\Brand\Brand::class, 'show']);
Route::any('/brand/map', [app\controller\Brand\Brand::class, 'map']);
Route::any('/brand/all', [app\controller\Brand\Brand::class, 'all']);
Route::any('/brand/list', [app\controller\Brand\Brand::class, 'list']);
Route::any('/brand/add', [app\controller\Brand\Brand::class, 'add']);
Route::any('/brand/mod', [app\controller\Brand\Brand::class, 'mod']);
Route::any('/brand/save', [app\controller\Brand\Brand::class, 'save']);
Route::any('/brand/del', [app\controller\Brand\Brand::class, 'del']);
Route::any('/brand/remove', [app\controller\Brand\Brand::class, 'remove']);

// community
Route::any('/community', [app\controller\Community\Community::class, 'index']);
Route::any('/community/{id:\d+}', [app\controller\Community\Community::class, 'index']);
Route::any('/community/show', [app\controller\Community\Community::class, 'show']);
Route::any('/community/map', [app\controller\Community\Community::class, 'map']);
Route::any('/community/all', [app\controller\Community\Community::class, 'all']);
Route::any('/community/user/{uid:\d}', [app\controller\Community\Community::class, 'user']);
Route::any('/community/list', [app\controller\Community\Community::class, 'list']);
Route::any('/community/add', [app\controller\Community\Community::class, 'add']);
Route::any('/community/mod', [app\controller\Community\Community::class, 'mod']);
Route::any('/community/save', [app\controller\Community\Community::class, 'save']);
Route::any('/community/praise/{id:\d+}', [app\controller\Community\Community::class, 'praise']);
Route::any('/community/reply/{id:\d+}', [app\controller\Community\Community::class, 'reply']);
Route::any('/community/add_praise', [app\controller\Community\Community::class, 'add_praise']);
Route::any('/community/add_reply', [app\controller\Community\Community::class, 'add_reply']);
Route::any('/community/del', [app\controller\Community\Community::class, 'del']);
Route::any('/community/remove', [app\controller\Community\Community::class, 'remove']);

// order
Route::any('/order', [app\controller\Order\Order::class, 'index']);
Route::any('/order/{order:\d+}', [app\controller\Order\Order::class, 'index']);
Route::any('/order/pay', [app\controller\Order\Order::class, 'pay']);
Route::any('/order/notify', [app\controller\Order\Order::class, 'notify']);
Route::any('/order/show', [app\controller\Order\Order::class, 'show']);
Route::any('/order/user', [app\controller\Order\Order::class, 'user']);
Route::any('/order/personal/{uid:\d+}[/{status}]', [app\controller\Order\Order::class, 'personal']);
Route::any('/order/map', [app\controller\Order\Order::class, 'map']);
Route::any('/order/all', [app\controller\Order\Order::class, 'all']);
Route::any('/order/list', [app\controller\Order\Order::class, 'list']);
Route::any('/order/add', [app\controller\Order\Order::class, 'add']);
Route::any('/order/mod', [app\controller\Order\Order::class, 'mod']);
Route::any('/order/open', [app\controller\Order\Order::class, 'open']);
Route::any('/order/cancel', [app\controller\Order\Order::class, 'cancel']);
Route::any('/order/save', [app\controller\Order\Order::class, 'save']);
Route::any('/order/del', [app\controller\Order\Order::class, 'del']);
Route::any('/order/remove', [app\controller\Order\Order::class, 'remove']);
Route::any('/order/send', [app\controller\Order\Order::class, 'send']);
Route::any('/order/sale', [app\controller\Order\Order::class, 'sale']);
Route::any('/order/cancel_sale', [app\controller\Order\Order::class, 'cancel_sale']);
Route::any('/order/refund', [app\controller\Order\Order::class, 'refund']);
Route::any('/order/count/{uid:\d+}', [app\controller\Order\Order::class, 'count']);
Route::any('/order/mchain/{order}', [app\controller\Order\Order::class, 'mchain']);
Route::any('/order/schain/{operation_id}', [app\controller\Order\Order::class, 'schain']);
Route::any('/order/mnotify/{order}', [app\controller\Order\Order::class, 'mnotify']);
Route::any('/order/mlock/{order}', [app\controller\Order\Order::class, 'mlock']);
Route::any('/order/unlock/{order}', [app\controller\Order\Order::class, 'unlock']);
Route::any('/order/airdrop', [app\controller\Order\Order::class, 'airdrop']);
Route::any('/order/test', [app\controller\Order\Order::class, 'test']);
Route::any('/order/transfer', [app\controller\Order\Order::class, 'transfer']);
Route::any('/order/export', [app\controller\Order\Order::class, 'export']);

// sms
Route::any('/sms', [app\controller\Api\Sms\Sms::class, 'index']);
Route::any('/sms/send', [app\controller\Api\Sms\Sms::class, 'send']);

// web
// carousel
// Route::any('/carousel', [app\controller\Web\Carousel::class, 'index']);
Route::any('/carousel[/{id:\d+}]', [app\controller\Web\Carousel::class, 'index']);
Route::any('/carousel/show', [app\controller\Web\Carousel::class, 'show']);
Route::any('/carousel/map', [app\controller\Web\Carousel::class, 'map']);
Route::any('/carousel/all', [app\controller\Web\Carousel::class, 'all']);
Route::any('/carousel/list', [app\controller\Web\Carousel::class, 'list']);
Route::any('/carousel/add', [app\controller\Web\Carousel::class, 'add']);
Route::any('/carousel/mod', [app\controller\Web\Carousel::class, 'mod']);
Route::any('/carousel/save', [app\controller\Web\Carousel::class, 'save']);
Route::any('/carousel/del', [app\controller\Web\Carousel::class, 'del']);
Route::any('/carousel/remove', [app\controller\Web\Carousel::class, 'remove']);

// tabbar
Route::any('/tabbar[/{id:\d+}]', [app\controller\Web\Tabbar::class, 'index']);
Route::any('/tabbar/show', [app\controller\Web\Tabbar::class, 'show']);
Route::any('/tabbar/map', [app\controller\Web\Tabbar::class, 'map']);
Route::any('/tabbar/all', [app\controller\Web\Tabbar::class, 'all']);
Route::any('/tabbar/list', [app\controller\Web\Tabbar::class, 'list']);
Route::any('/tabbar/add', [app\controller\Web\Tabbar::class, 'add']);
Route::any('/tabbar/mod', [app\controller\Web\Tabbar::class, 'mod']);
Route::any('/tabbar/save', [app\controller\Web\Tabbar::class, 'save']);
Route::any('/tabbar/del', [app\controller\Web\Tabbar::class, 'del']);
Route::any('/tabbar/remove', [app\controller\Web\Tabbar::class, 'remove']);

// grid
// Route::any('/grid', [app\controller\Web\Carousel::class, 'index']);
Route::any('/grid[/{id:\d+}]', [app\controller\Web\Grid::class, 'index']);
Route::any('/grid/show', [app\controller\Web\Grid::class, 'show']);
Route::any('/grid/map', [app\controller\Web\Grid::class, 'map']);
Route::any('/grid/all', [app\controller\Web\Grid::class, 'all']);
Route::any('/grid/list', [app\controller\Web\Grid::class, 'list']);
Route::any('/grid/parent[/{pid:\d+}]', [app\controller\Web\Grid::class, 'parent']);
Route::any('/grid/add', [app\controller\Web\Grid::class, 'add']);
Route::any('/grid/mod', [app\controller\Web\Grid::class, 'mod']);
Route::any('/grid/save', [app\controller\Web\Grid::class, 'save']);
Route::any('/grid/del', [app\controller\Web\Grid::class, 'del']);
Route::any('/grid/remove', [app\controller\Web\Grid::class, 'remove']);


// upload
Route::any('/upload', [app\controller\Upload\Upload::class, 'index']);


// download
Route::any('/download', [app\controller\Download\Download::class, 'index']);


// api
// api-tencent
Route::any('/tencent', [app\controller\Api\Tencent\Tencent::class, 'index']);
Route::any('/tencent/idcard', [app\controller\Api\Tencent\Tencent::class, 'idcard']);
Route::any('/tencent/health', [app\controller\Api\Tencent\Tencent::class, 'health']);
Route::any('/tencent/travel', [app\controller\Api\Tencent\Tencent::class, 'travel']);
Route::any('/tencent/pay', [app\controller\Api\Tencent\Tencent::class, 'pay']);
// api-aliyun
Route::any('/aliyun', [app\controller\Api\Aliyun\Aliyun::class, 'index']);
Route::any('/aliyun/sms', [app\controller\Api\Aliyun\Aliyun::class, 'sms']);

// api-avata
Route::any('/avata', [app\controller\Api\Avata\Avata::class, 'index']);
Route::any('/avata/create', [app\controller\Api\Avata\Avata::class, 'create']);
Route::any('/avata/batch_create', [app\controller\Api\Avata\Avata::class, 'batch_create']);
Route::any('/avata/account', [app\controller\Api\Avata\Avata::class, 'account']);
Route::any('/avata/account_record', [app\controller\Api\Avata\Avata::class, 'account_record']);
Route::any('/avata/transaction/{operation_id}', [app\controller\Api\Avata\Avata::class, 'transaction']);
Route::any('/avata/create_cate', [app\controller\Api\Avata\Avata::class, 'create_cate']);
Route::any('/avata/get_cate', [app\controller\Api\Avata\Avata::class, 'get_cate']);
Route::any('/avata/issue', [app\controller\Api\Avata\Avata::class, 'issue']);
Route::any('/avata/transfer', [app\controller\Api\Avata\Avata::class, 'transfer']);
Route::any('/avata/edit', [app\controller\Api\Avata\Avata::class, 'edit']);
Route::any('/avata/destroy', [app\controller\Api\Avata\Avata::class, 'destroy']);
Route::any('/avata/get_issue', [app\controller\Api\Avata\Avata::class, 'get_issue']);
Route::any('/avata/detail', [app\controller\Api\Avata\Avata::class, 'detail']);
Route::any('/avata/order', [app\controller\Api\Avata\Avata::class, 'order']);
Route::any('/avata/charges', [app\controller\Api\Avata\Avata::class, 'charges']);
Route::any('/avata/charge[/{order}]', [app\controller\Api\Avata\Avata::class, 'charge']);

// api-sande
Route::any('/sande', [app\controller\Api\Sande\Sande::class, 'index']);
Route::any('/sande/test', [app\controller\Api\Sande\Sande::class, 'test']);
Route::any('/sande/charge', [app\controller\Api\Sande\Sande::class, 'charge']);
Route::any('/sande/payment', [app\controller\Api\Sande\Sande::class, 'payment']);
Route::any('/sande/pay', [app\controller\Api\Sande\Sande::class, 'pay']);
Route::any('/sande/balance', [app\controller\Api\Sande\Sande::class, 'balance']);
Route::any('/sande/ctob', [app\controller\Api\Sande\Sande::class, 'ctob']);
Route::any('/sande/ctoc', [app\controller\Api\Sande\Sande::class, 'ctoc']);
Route::any('/sande/account', [app\controller\Api\Sande\Sande::class, 'account']);
Route::any('/sande/notify', [app\controller\Api\Sande\Sande::class, 'notify']);
Route::any('/sande/success', [app\controller\Api\Sande\Sande::class, 'success']);

