</div>
        <?php $socialMedia = new classes\SocialMedia\SocialMedia() ?>
        <div class="footer" id="footer">
            <div class="social-media lg-txt center">
                <span class="lg-txt white-txt"><?php echo $translate->getString("followUs"); ?></span>
                <a href="<?php echo $socialMedia->getFacebook() ?>" target="_blank" class="fb"><i class="fa fa-facebook"></i></a>
                <a href="<?php echo $socialMedia->getGooglePLus() ?>" target="_blank" class="gplus"><i class="fa fa-google-plus"></i></a>
                <a href="<?php echo $socialMedia->getInstagram() ?>" target="_blank" class="insta"><i class="fa fa-instagram"></i></a>
                <a href="<?php echo $socialMedia->getTwitter() ?>" target="_blank" class="twitter"><i class="fa fa-twitter"></i></a>
                <a href="<?php echo $socialMedia->getYouTube() ?>" target="_blank" class="youtube"><i class="fa fa-youtube"></i></a>  
            </div>
                
            <div class="links-part">
                <div class="container">
                    <div class="links flex white-txt">
                        <div class="about-links">
                            <h5><?php echo $translate->getString("about"); ?></h5>
                            <ul>
                                <li><a href="/about.php"><?php echo $translate->getString("aboutAskForMe"); ?></a></li>
                                <li><a href="/faq.php">FAQ</a></li>
                                <li><a href="/partnership.php"><?php echo $translate->getString("partnership");?></a></li>
                                <li><a href="/contact.php"><?php echo $translate->getString("contact");?></a></li>
                            </ul>
                        </div>
                         <div class="model-links">
                            <h5><?php echo $translate->getString("models"); ?></h5>
                            <ul>
                                <li><a href="/dashboard-model.php"><?php echo $translate->getString("yourAccount");?></a></li>
                                <li><a href="/dashboard-model.php"><?php echo $translate->getString("getPaid");?></a></li>
                                <li><a href="/dashboard-model.php"><?php echo $translate->getString("membership");?></a></li>
                                <li><a href="/dashboard-model.php"><?php echo $translate->getString("startAnActivity");?></a></li>
                            </ul>
                        </div>
                         <div class="customer-links">
                            <h5><?php echo $translate->getString("customers"); ?></h5>
                            <ul>
                                <li><a href="/dashboard-user.php"><?php echo $translate->getString("yourAccount");?></a></li>
                                <li><a href="/dashboard-user.php"><?php echo $translate->getString("membership");?></a></li>
                                <li><a href="/live-cams.php"><?php echo $translate->getString("liveCams");?></a></li>
                                <li><a href="/escort.php"><?php echo $translate->getString("escort");?></a></li>
                                <li><a href="/store.php"><?php echo $translate->getString("store");?></a></li>
                            </ul>
                        </div>
                         <div class="legal-links">
                            <h5><?php echo $translate->getString("legal"); ?></h5>
                            <ul>
                                <li><a href="/terms-and-conditions.php"><?php echo $translate->getString("termsAndConditions");?></a></li>
                                <li><a href="/user-agreement.php"><?php echo $translate->getString("userAgreement");?></a></li>
                                <li><a href="/privacy-policy.php"><?php echo $translate->getString("privacyPolicy");?></a></li>
                                <li><a href="/copyrights.php"><?php echo $translate->getString("copyrights");?></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="copyright xs-txt lt-txt">
                <div class="container">
                    <p>Copyright by askforme 2017</p>
                </div>
            </div>
        </div>


        <a href="#top" class="totop animated fadeIn smoothscroll"><i class="fa fa-angle-up"></i></a>
        
        
        <script src="/js/globalFunctions.js"></script>
        <script src="/js/selectFx.js"></script><!--selecty w search filters-->
        <script src="/js/main.js"></script>

        <script>
        $(document).ready(function(){
                $('[data-toggle="tooltip"]').tooltip(); 
            });
        </script>

	</body>
</html>