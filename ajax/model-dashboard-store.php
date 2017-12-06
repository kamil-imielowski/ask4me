<?php 
session_start();
require_once dirname(dirname(__FILE__)).'/displayErrors.php';
require_once dirname(dirname(__FILE__)).'/vendor/autoload.php';

$user = unserialize(base64_decode($_SESSION['user']));
$products = new \classes\Product\ProductsFactory(null, $user->getLogin());
$translate = new \classes\Languages\Translate();
?>
<div class="section store my-store animated fadeIn">
    <?php if($user->getMembership()->getType() == 2): ?>
    <h4 class="dashboard-heading"><?php echo $translate->getString("store"); ?></h4>
    
    <div class="form">
        
        <div class="part">
            <h6><?php echo $translate->getString("myProducts"); ?></h6>   
            
            <div class="wrapper">
                <?php foreach($products->getUserProducts() as $k){?>
                    <div class="item model-item">
                        <div class="icons">
                            <a data-toggle="tooltip" data-placement="left" title="Edit" class="med-prim-bg white-txt" onclick="editProduct(<?php echo $k->getId() . ",'" . $k->getName() . "', '" . $k->getDescription() . "', "  . $k->getPrice()?>)"><i class='material-icons'>edit</i></a>
                            <a href="dashboard-model.php?action=deleteProduct&id=<?php echo $k->getId()?>"  data-toggle="tooltip" data-placement="left" title="Delete" class="med-prim-bg white-txt"><i class='material-icons'>delete</i></a>
                        </div>
                        <a href="/product/<?php echo $k->getId()?>/<?php echo $k->getURLName()?>">
                            <div class="photo" style="background:url(<?php echo $k->getPhoto()->getSRCThumbImage(); ?>) no-repeat center center"></div>
                        </a>
                        <div class="lt-med-bg white-txt text center">
                            <a href="/product/<?php echo $k->getId()?>/<?php echo $k->getURLName()?>"><p class="title white-txt"><?php echo $k->getName(); ?></p></a>
                            <p class="price xl-txt"><strong><i class="fa fa-diamond"></i><?php echo $k->getPrice(); ?></strong></p>
                        </div>
                    </div>
                <?php }?>
            </div>
        </div>
        
        <form method="POST" enctype="multipart/form-data">
            
            <div class="part">
                <h6><?php echo $translate->getString("addNew"); ?></h6> 
                
                <div class="form-group">
                    <label><?php echo $translate->getString("productName"); ?>:</label>
                    <input type="text" name="name" placeholder="<?php echo $translate->getString("enterProductName"); ?>">
                </div>
                
                <div class="form-group">
                    <label><?php echo $translate->getString("productPriceInTokens"); ?>:</label>
                    <input type="number" name="price" placeholder="<?php echo $translate->getString("enterProductPrice"); ?>">
                </div>

                <div class="form-group">
                    <label><?php echo $translate->getString("productDescription"); ?></label>
                    <textarea name="description" placeholder="<?php echo $translate->getString("enterProductDescription"); ?>"></textarea>
                </div>

                <div class="form-group">
                    <h6 class="dashboard-heading"><?php echo $translate->getString("productThumbnail"); ?>:</h6> 
                    <input id="upload-thumbnail" name="img" type="file" class="file" data-show-preview="false" data-show-upload="false" data-show-remove="false" placeholder="Choose a file">
                    <p><span><strong><?php echo $translate->getString("recommendedFormat"); ?>: </strong></span><span>.jpg</span></p>
                    <p><span><strong><?php echo $translate->getString("recommendedSize"); ?>: </strong></span><span>420px x 290px</span></p>
                </div>
                
                <div class="form-group">
                    <h6 class="dashboard-heading"><?php echo $translate->getString("productFile"); ?>:</h6>
                    <input id="upload-file" name="product_file" type="file" class="file" data-show-preview="false" data-show-upload="false" data-show-remove="false" placeholder="Choose a file">
                </div>
                
            </div>

            <button type="submit" class="button med-prim-bg" name="action" value="uploadProduct"><?php echo $translate->getString("addProduct") ?></button>
        
        </form>
        
    </div>
    <?php else: echo $translate->getString("vipRequired"); endif;?>
</div>	

<script type="text/javascript" src="js/fileinput.min.js"></script>
<script type="text/javascript">
    function editProduct(id, name, description, price){
        $("input[name='name']").val(name);
        $("input[name='price']").val(price);
        $("textarea[name='description']").text(description);
        $("button[name='action']").html("<?php echo $translate->getString('editProduct'); ?>");
        $("button[name='action']").before('<input name="id" type="hidden" value="'+id+'">');

    }
</script>