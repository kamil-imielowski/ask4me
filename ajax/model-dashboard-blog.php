<?php 
session_start();
require_once dirname(dirname(__FILE__)).'/displayErrors.php';
require_once dirname(dirname(__FILE__)).'/vendor/autoload.php';

$user = unserialize(base64_decode($_SESSION['user']));
$user->loadBlogs();
$translate = new \classes\Languages\Translate();
?>
<div class="section blog my-blog animated fadeIn">
    <h4 class="dashboard-heading"><?php echo $translate->getString("blog"); ?></h4>
    
    <div class="form">
        
        <div class="part">
            <h6><?php echo $translate->getString("myProducts"); ?></h6>   
            
            <div class="wrapper">
                <?php foreach($user->getBlogs() as $blog){ ?>            
                    <div class="item lt-med-bg white-txt">
                        <div class="photo" style="background:url(<?php echo $blog->getPhoto()->getSRCThumbImage(); ?>) no-repeat center center">
                            <div class="icons">
                                <a onclick="blogEdit(<?php echo $blog->getId() . ",'" . $blog->getTitle() . "'" . ",`" . $blog->getContent() ."`"; ?>)" data-toggle="tooltip" data-placement="left" title="Edit" class="med-prim-bg white-txt"><i class='material-icons'>edit</i></a>
                                <a href="dashboard-model.php?action=deleteBlog&id=<?php echo $blog->getId() ?>"  data-toggle="tooltip" data-placement="left" title="Delete" class="med-prim-bg white-txt"><i class='material-icons'>delete</i></a>
                            </div>
                        </div>
                        <div class="text">
                            <h6><a href="/blog/<?php echo $blog->getId()?>/<?php echo $blog->getURLTitle()?>"><?php echo $blog->getTitle(); ?></a></h6>
                            <p class="xs-txt date"><?php echo $blog->getDateCreated(); ?></p>
                            <p><span><?php echo substr($blog->getContent(), 0, 500) ?>...</span> <a href="/blog/<?php echo $blog->getId()?>/<?php echo $blog->getURLTitle()?>"><strong><span><?php echo $translate->getString("readMore") ?></span></strong></a></p>
                        </div>
                    </div>
                <?php }?>
            </div>
        </div>
        
        <form method="post" enctype="multipart/form-data">
            
            <div class="part">
                <h6><?php echo $translate->getString("addNew"); ?></h6> 
                
                <div class="form-group">
                    <label><?php echo $translate->getString("title"); ?>:</label>
                    <input type="text" name="title" placeholder="<?php echo $translate->getString("blogEntryTitle"); ?>">
                </div>

                <div class="form-group">
                    <label><?php echo $translate->getString("content"); ?></label>
                    <textarea name="content" placeholder="<?php echo $translate->getString("blogEntryContent"); ?>"></textarea>
                </div>

                <div class="form-group">
                    <h6 class="dashboard-heading"><?php echo $translate->getString("blogEntryThumbnail"); ?>:</h6> 
                    <input id="upload-thumbnail" name="img" type="file" class="file" data-show-preview="false" data-show-upload="false" data-show-remove="false" placeholder="Choose a file">
                    <p><span><strong><?php echo $translate->getString("recommendedFormat"); ?>: </strong></span><span>.jpg</span></p>
                    <p><span><strong><?php echo $translate->getString("recommendedSize"); ?>: </strong></span><span>210px x 170px</span></p>
                </div>
                
            </div>

            <button type="submit" class="button med-prim-bg" name="action" value="uploadBlog"><?php echo $translate->getString("addBlogEntry"); ?></button>
        
        </form>
        
    </div>
</div>	

<script type="text/javascript" src="js/fileinput.min.js"></script>
<script>
    function blogEdit(id, title, content){
        $("input[name='title']").val(title);
        $("textarea[name='content']").val(content);
        $("button[name='action']").val('updateBlog');
        $("button[name='action']").html("<?php echo $translate->getString('editBlog'); ?>");
        $("button[name='action']").before("<input type='hidden' name='id_blog' value='" + id + "' >");
    }
</script>