# SlideSubmit
Typecho评论拖动提交插件。

**使用方法**：

在comments.php中找到如下代码：

```
<button type="submit" class="submit"><?php _e('提交评论'); ?></button>
```
删掉该行，增加如下代码：
```
<?php SlideSubmit_Plugin::output();?>
```
PS：如果想同时保留原来的提交按钮，可以不删除，直接在后面新增上面的代码。个人建议删除，因为没什么用，而且影响美观。



来源于老邦博客(https://laobang.net/1468)， 做了一些修改。
