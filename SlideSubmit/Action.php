<?php

/*
 *SlideSubmit 插件
 *滑动成功时异步提供随机code 并返回给前端
 */

class SlideSubmit_Action extends Typecho_Widget implements Widget_Interface_Do
{
    public function action()
    {
        /** 防止跨站 */
        $referer = $this->request->getReferer();
        if (empty($referer)) {
			throw new Typecho_Widget_Exception(_t('HI,这是非法访问!'));
            exit;
        }
        $refererPart = parse_url($referer);
        $currentPart = parse_url(Helper::options()->siteUrl);
        
        if ($refererPart['host'] != $currentPart['host'] ||
        0 !== strpos($refererPart['path'], $currentPart['path'])) {
			throw new Typecho_Widget_Exception(_t('HI,这是非法访问!'));
            exit;
        }

        require_once 'SlideSubmit/CodeValue.php';
        $randCode = new RandCode();
        $randCode->showRandCode(); //获取随机code并输出
        
    }
	
	
}
