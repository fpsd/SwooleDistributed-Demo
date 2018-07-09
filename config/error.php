<?php
//错误收集上报系统
$config['error']['enable'] = true;
//访问地址，需自己设置ip：port
$config['error']['url'] = "https://www.xiaohui.li/Error";
$config['error']['redis_prefix'] = '@sd-error_';
$config['error']['redis_timeOut'] = '36000';
$config['error']['dingding_enable'] = true;
$config['error']['dingding_url'] = 'https://oapi.dingtalk.com';
//钉钉机器人，需自己申请
$config['error']['dingding_robot'] = '/robot/send?access_token=b477352c14b83a15f3d00e7e5ed1215fce142b7184f9165d6bba2a733e534ead';
return $config;
