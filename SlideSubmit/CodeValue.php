<?php

/*
 *SlideSubmit 插件
 *ClassName 生成6位随机数 并保存为session 用于提交时候验证
 */
class RandCode 
{
		
	 public function showRandCode()
	 {
      ini_set('session.cookie_path', '/');
      ini_set('session.cookie_lifetime', 0);
	  session_start();
      $randnum=rand(1,9).rand(1,9).rand(1,9).rand(1,9).rand(1,9).rand(1,9).'_SlideSumit';
      $_SESSION['securimage_code_value']=$randnum;
      echo $_SESSION['securimage_code_value'];
    }
	
	public function check($request){		
	  if(!empty($request)){		
			if($_SESSION['securimage_code_value'] != $request){
			  throw new Typecho_Widget_Exception(_t('换个姿势再滑一次吧'));
			}
		}else{
		 throw new Typecho_Widget_Exception(_t('换个姿势再滑一次吧~'));
		}	
		
	}
}
?>