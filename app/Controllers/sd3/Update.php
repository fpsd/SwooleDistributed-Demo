<?php
/**
 * Created by PhpStorm.
 * User: leexiaohui(oranzh.cc@gmail.com)
 * Date: 2018/7/19
 * Time: 17:32
 */

namespace app\Controllers\sd3;


use app\Controllers\BaseController;
use Respect\Validation\Validator as v;

class Update extends BaseController
{

    private $cSd3Update;
    protected function initialization($controller_name, $method_name)
    {
        parent::initialization($controller_name, $method_name); // TODO: Change the autogenerated stub
        $this->cSd3Update = $this->loader->model('commit/sd3/Update',$this);
    }

    public function http_perform()
    {
        if ($this->isGet()) {
            $this->getView();
//            $tpl = $this->loader->view($this->getView(),[]);
//            $this->http_output->end($tpl);
//            $this->interrupt();
        }
        $params = $this->verify();
        $this->context['commit'] = $params;
        $this->cSd3Update->perform();
        $this->end('update successfully');
    }

    private function verify()
    {
        $params = $this->http_input->getAllPost();
        v::arrayVal()->key('id',v::intVal()->min(1))
            ->key('user_name',v::stringType()->length(5,20))
            ->check($params);
        return $params;
    }
}