<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

/**
 * 滑动提交评论插件 
 * @package SlideSubmit
 * @author 老邦
 * @version 1.0
 * @link http://laobang.net
 */
class SlideSubmit_Plugin implements Typecho_Plugin_Interface
{
	/**
	 * 激活插件方法,如果激活失败,直接抛出异常
	 *
	 * @access public
	 * @return string
	 * @throws Typecho_Plugin_Exception
	 */
	public static function activate()
	{
		Typecho_Plugin::factory('Widget_Archive')->header = array('SlideSubmit_Plugin', 'header');
		Typecho_Plugin::factory('Widget_Feedback')->comment= array('SlideSubmit_Plugin', 'filter');
		Helper::addAction('slidesubmit', 'SlideSubmit_Action');
	}
   
	/**
	 * 禁用插件方法,如果禁用失败,直接抛出异常
	 *
	 * @static
	 * @access public
	 * @return void
	 * @throws Typecho_Plugin_Exception
	 */
	public static function deactivate()
	{
		
	}
   
	/**
	 * 获取插件配置面板
	 *
	 * @access public
	 * @param Typecho_Widget_Helper_Form $form 配置面板
	 * @return void
	 */
	public static function config(Typecho_Widget_Helper_Form $form)
	{
		$slideButtColor = new Typecho_Widget_Helper_Form_Element_Text(
      'slideButtColor',null, '#1a5ea9', '滑动按钮颜色', '滑动按钮颜色输入，如：#1a5ea9.<br/><br/>');
	    $form->addInput($slideButtColor);
		
		$slideBgColor = new Typecho_Widget_Helper_Form_Element_Text(
      'slideBgColor',null, '#FFF9E8', '滑动背景颜色', '滑动背景颜色输入，如：#FFF9E8.<br/><br/>');
	    $form->addInput($slideBgColor);
		
		$slideSussColor = new Typecho_Widget_Helper_Form_Element_Text(
      'slideSussColor',null, '#E5EE9F', '滑动成功后背景颜色', '滑动成功后背景颜色输入，如：#E5EE9F.<br/><br/>');
	    $form->addInput($slideSussColor);
    }

	 /**
     * 个人用户的配置面板
     * 
     * @access public
     * @param Typecho_Widget_Helper_Form $form
     * @return void
     */
    public static function personalConfig(Typecho_Widget_Helper_Form $form) {
        
    }
	


    /**
     * 输出头部js和css
     *
     * @access public
     * @param unknown $header
     * @return unknown
     */
    public static function header() {
		$SlideObj = Helper::options()->plugin('SlideSubmit');
        $currentPath = Helper::options()->pluginUrl . '/SlideSubmit/';       
		echo '<link rel="stylesheet" type="text/css" href="' . $currentPath . 'css/jquery.slideunlock.css" />' . "\n";
		echo '<script type="text/javascript" src="' . $currentPath . 'js/jquery.min.js"></script>' . "\n";
		echo '<script type="text/javascript" src="' . $currentPath . 'js/jquery.slideunlock.min.js"></script>' . "\n";
		echo  <<<EOF
		
		   <!--SlideSubmit插件主题设置-->		   
		   <style>
		   #slide{background-color: {$SlideObj->slideBgColor};}
		   #slider.success{ background-color: {$SlideObj->slideSussColor};}
		   #label{background:  {$SlideObj->slideButtColor};}
		   </style>		
EOF;
    }
	
	/**
     * 验证滑动 
     * @return ,,
     */
    public static function filter($comment) {
		session_start();
		$randnum =$_REQUEST['randnum'];
		
		require_once 'SlideSubmit/CodeValue.php';
		
        $randCode = new RandCode();
        $randCode->check($randnum);
		
		return $comment;
	}	
	
	 public static function output()
    {
    $currentPath = Helper::options()->pluginUrl . '/SlideSubmit/';  
      ?>
      <!--SlideSubmit html-->	
	 <input type="hidden" value="" name="randnum" id="randnum"/>
	 <div id="slide-wrapper">
	    <div id="slider">
		 <span id="label"></span>
		 <span id="lableTip"></span>
	    </div>
     </div>
 <!--SlideSubmit javasript-->	    
<script type="text/javascript">
$(function () {
	var slider = new SliderUnlock("#slider", {}, function(){
		if($("#author").length){if(!$("#author").val()){alert("留下你的大名吧！");$("#author").focus();this.reset();return false;}}
		if($("#mail").length){if(!$("#mail").val()){alert("邮箱能方便我们联系哦!");$("#mail").focus();this.reset();return false;}}		
		if(!$("#textarea").val()){alert("说点什么吧，我知道你有很多想说的!");$("#textarea").focus();this.reset();}
		else{
			$.ajax({
			url:'<?php echo Typecho_Common::url('/action/slidesubmit', '');?>',
			type:'POST',
			data:'',
			dataType:"html",
			beforeSend: function(){		
				
			},
			error: function(){
				alert("换个姿势再滑一次吧");
                slider.reset();
			},
			success: function(o){
				if(o!=''){
					$("#randnum").val(o);
				
					$("#comment-form").submit();
					slider.reset();
					
				}else{
				 alert("换个姿势再滑一次吧");
                 slider.reset();
				}
				
			}
		   });
		}
	}, function(){
		
	});
	slider.init();
})
</script>	  
	  <?php
    }
	
	
}