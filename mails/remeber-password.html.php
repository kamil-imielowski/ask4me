<?php include_once dirname(__FILE__).'/top.html.php';?>

<tr>				
    <td style="padding: 30px 20px 40px 20px; text-align:center; font-size:14px;">			
        <p style="text-align:center;">
            <h2 style="text-transform:uppercase; font-family:Arial, Helvetica, sans-serif; font-size:24px; font-weight:bold;"><?php $translate->getString('resetPasswordEmail') ?></h2>
        </p>

        <br>    

        <a href="<?php echo siteURL()?>/forgotten-password.php?action=setNewPassword&id=<?php echo $user_id ?>&control=<?php echo $controlResetPassword ?>" target="_blank" style="text-align: center; padding:15px 25px; background-color:#a41215; text-transform:uppercase; color:#fff;text-decoration:none;font-weight:bold;"><?php $translate->getString('changePassword') ?></a>

        <br>
        <br>
        <br>
    
    </td>			
</tr>		

<?php include_once dirname(__FILE__).'/footer.html.php';?>