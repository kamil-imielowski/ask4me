<?php include_once dirname(__FILE__).'/top.html.php';?>

<tr>				
    <td style="padding: 30px 20px 40px 20px; text-align:center; font-size:14px;">			
        <p style="text-align:center;">
            <h2 style="text-transform:uppercase; font-family:Arial, Helvetica, sans-serif; font-size:24px; font-weight:bold;"><?php $translate->getString('confirmNewEmail') ?></h2>
        </p>

        <br>    

        <a href="<?php echo siteURL()?>/register.php?action=confirm-new-email&code=<?php echo $code ?>&id=<?php echo $this->id ?>" target="_blank" style="text-align: center; padding:15px 25px; background-color:#a41215; text-transform:uppercase; color:#fff;text-decoration:none;font-weight:bold;"><?php $translate->getString('confirm') ?></a>

        <br>
        <br>
        <br>
    
    </td>			
</tr>		

<?php include_once dirname(__FILE__).'/footer.html.php';?>