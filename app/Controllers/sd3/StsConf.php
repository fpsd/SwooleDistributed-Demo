<?php
/**
 * Created by PhpStorm.
 * User: leexiaohui(oranzh.cc@gmail.com)
 * Date: 2018/7/24
 * Time: 10:06
 */

namespace app\Controllers\sd3;


use app\Controllers\BaseController;
use Sts\Request\V20150401 as Sts;

class StsConf extends BaseController
{
    private $conf;
    protected function initialization($controller_name, $method_name)
    {
        parent::initialization($controller_name, $method_name); // TODO: Change the autogenerated stub
    }

    public function http_perform()
    {
        //TODO oss的配置写到配置文件里面
        if($tmp = $this->redis->get('stsconf')) {
            $this->end(json_decode($tmp,true));
            $this->interrupt();
        }
        $this->getConf();
		// 只允许子用户使用角色
		\DefaultProfile::addEndpoint($this->conf['REGION_ID'], $this->conf['REGION_ID'], "Sts", $this->conf['ENDPOINT']);
		$iClientProfile = \DefaultProfile::getProfile($this->conf['REGION_ID'], $this->conf['AccessKeyID'], $this->conf['AccessKeySecret']);
		$client = new \DefaultAcsClient($iClientProfile);
		// 角色资源描述符，在RAM的控制台的资源详情页上可以获取

		$request = new Sts\AssumeRoleRequest();
		// RoleSessionName即临时身份的会话名称，用于区分不同的临时身份
		// 您可以使用您的客户的ID作为会话名称
		$request->setRoleSessionName($this->conf['RoleName']);
		$request->setRoleArn($this->conf['roleArn']);
		//$request->setPolicy($policy);
		$request->setDurationSeconds(3600);
		$response = $client->getAcsResponse($request);
		$this->redis->set('stsconf',json_encode($response),3600);
		$this->end($response,0,false);
    }

    private function getConf()
    {
        $this->conf = $this->config['oss']['sts'];
    }
}