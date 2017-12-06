<?php include_once dirname(__FILE__).'/includes/subheader.html.php';?>
<?php include_once dirname(__FILE__).'/includes/top_menu.html.php';?>

<div class="escort-page content">

    <div class="map section">
        <h2><?php echo $translate->getString("findGirlsCloseToYourLocation") ?></h2>
        <div class="container">
           <div id="visualization"></div>
        </div>
    </div>
    
    <div class="filters section">
        <div class="container">
        
            <form method="post" id="filters">
                <div class="flex">
                    
                    <div class="form-group">
                        <select class="cs-select cs-skin-slide" name="sex">
                            <option disabled><?php echo $translate->getString("gender") ?></option>
                            <option value="all" <?php if(isset($filters)){echo $filters['sex'] == 'all' ? 'selected' : '';} ?>><?php echo $translate->getString("allGenders") ?></option>
                            <option value="1" <?php if(isset($filters)){echo $filters['sex'] == '1' ? 'selected' : '';} ?>><?php echo $translate->getString("woman") ?></option>
                            <option value="2" <?php if(isset($filters)){echo $filters['sex'] == '2' ? 'selected' : '';} ?>><?php echo $translate->getString("man") ?></option>
                            <option value="3" <?php if(isset($filters)){echo $filters['sex'] == '3' ? 'selected' : '';} ?>><?php echo $translate->getString("transgender") ?></option>
                         </select>`
                    </div>
                    
                     <div class="form-group">
                        <select class="cs-select cs-skin-slide" name="partner_preferences">
                            <option value="0" disabled><?php echo $translate->getString("partnerPreferences") ?></option>
                            <option value="all" <?php if(isset($filters)){echo $filters['partner_preferences'] == 'all' ? 'selected' : '';} ?>><?php echo $translate->getString("allPreferences") ?></option>
                            <option value="solo" <?php if(isset($filters)){echo $filters['partner_preferences'] == 'solo' ? 'selected' : '';} ?>><?php echo $translate->getString("solo") ?></option>
                            <option value="girl-girl" <?php if(isset($filters)){echo $filters['partner_preferences'] == 'girl-girl' ? 'selected' : '';} ?>><?php echo $translate->getString("girl-girl") ?></option>
                            <option value="boy-girl" <?php if(isset($filters)){echo $filters['partner_preferences'] == 'boy-girl' ? 'selected' : '';} ?>><?php echo $translate->getString("boy-girl") ?></option>
                            <option value="boy-girl-girl" <?php if(isset($filters)){echo $filters['partner_preferences'] == 'boy-girl-girl' ? 'selected' : '';} ?>><?php echo $translate->getString("boy-girl-girl") ?></option>
                            <option value="boy-boy-girl" <?php if(isset($filters)){echo $filters['partner_preferences'] == 'boy-boy-girl' ? 'selected' : '';} ?>><?php echo $translate->getString("boy-boy-girl") ?></option>
                            <option value="fetish" <?php if(isset($filters)){echo $filters['partner_preferences'] == 'fetish' ? 'selected' : '';} ?>><?php echo $translate->getString("fetish") ?></option>
                            <option value="girl-transgender" <?php if(isset($filters)){echo $filters['partner_preferences'] == 'girl-transgender' ? 'selected' : '';} ?>><?php echo $translate->getString("girl-transgender") ?></option>
                         </select>
                    </div>
                    <!--
                    <div class="form-group">
                        <select class="cs-select cs-skin-slide" name="service_provide">
                            <option value="0" disabled>Services</option>
                            <option value="1">Web</option>
                            <option value="2">In person</option>
                            <option value="3">Both</option>
                         </select>
                    </div>
                    -->
                    <div class="form-group no-margin">
                        <select class="cs-select cs-skin-slide" name="looks_age">
                            <option value="0" disabled><?php echo $translate->getString("age") ?></option>
                            <option value="all" <?php if(isset($filters)){echo $filters['looks_age'] == 'all' ? 'selected' : '';} ?>><?php echo $translate->getString("allAges") ?></option>
                            <option value="18-20" <?php if(isset($filters)){echo $filters['looks_age'] == '18-20' ? 'selected' : '';} ?>>18-20</option>
                            <option value="20-25" <?php if(isset($filters)){echo $filters['looks_age'] == '20-25' ? 'selected' : '';} ?>>20-25</option>
                            <option value="25-30" <?php if(isset($filters)){echo $filters['looks_age'] == '25-30' ? 'selected' : '';} ?>>25-30</option>
                            <option value="30+" <?php if(isset($filters)){echo $filters['looks_age'] == '30+' ? 'selected' : '';} ?>>30+</option>
                            <option value="40+" <?php if(isset($filters)){echo $filters['looks_age'] == '40+' ? 'selected' : '';} ?>>40+</option>
                            <option value="50+" <?php if(isset($filters)){echo $filters['looks_age'] == '50+' ? 'selected' : '';} ?>>50+</option>
                            <option value="60+" <?php if(isset($filters)){echo $filters['looks_age'] == '60+' ? 'selected' : '';} ?>>60+</option>
                            <option value="70+" <?php if(isset($filters)){echo $filters['looks_age'] == '70+' ? 'selected' : '';} ?>>70+</option>
                         </select>
                    </div>
                    
                    <div class="form-group no-margin">
                        <select class="cs-select cs-skin-slide" name="country">
                            <option value="0" disabled><?php echo $translate->getString("country") ?></option>
                            <option value="all" <?php if(isset($filters)){echo $filters['country'] == 'all' ? 'selected' : '';} ?>><?php echo $translate->getString("allCountries") ?></option>
                            <?php foreach($countries as $country): ?>
                                <option value="<?php echo $country->getIsoCode2() ?>" <?php if(isset($filters)){echo $filters['country'] == $country->getIsoCode2() ? 'selected' : '';} ?>><?php echo $country->getName(); ?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                    
                    <div class="form-group no-margin">
                        <select class="cs-select cs-skin-slide" name="language">
                            <option value="0" disabled><?php echo $translate->getString("language") ?></option>
                            <option value="all" <?php if(isset($filters)){echo $filters['language'] == 'all' ? 'selected' : '';} ?>><?php echo $translate->getString("allLanguages") ?></option>
                            <?php foreach($languages as $language): ?>
                                <option value="<?php echo $language->getCode(); ?>" <?php if(isset($filters)){echo $filters['language'] == $language->getCode() ? 'selected' : '';} ?>><?php echo $language->getName(); ?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                    
                    <div class="form-group no-margin">
                        <select class="cs-select cs-skin-slide" name="skin_color">
                            <option value="0" disabled><?php echo $translate->getString("skinColor") ?></option>
                            <option value="all" <?php if(isset($filters)){echo $filters['skin_color'] == 'all' ? 'selected' : '';} ?>><?php echo $translate->getString("allSkinColor") ?></option>
                            <option value="yellow" <?php if(isset($filters)){echo $filters['skin_color'] == 'yellow' ? 'selected' : '';} ?>>Yellow</option>
                            <option value="white" <?php if(isset($filters)){echo $filters['skin_color'] == 'white' ? 'selected' : '';} ?>>White</option>
                         </select>
                    </div>
                    
                    <div class="form-group">
                        <select class="cs-select cs-skin-slide" name="body_build">
                            <option value="0" disabled><?php echo $translate->getString("bodyBuild"); ?></option>
                            <option value="all" <?php if(isset($filters)){echo $filters['body_build'] == 'all' ? 'selected' : '';} ?>><?php echo $translate->getString("bodyBuild_all") ?></option>
                            <option value="bodyBuild_slim" <?php if(isset($filters)){echo $filters['body_build'] == 'bodyBuild_slim' ? 'selected' : '';} ?>><?php echo $translate->getString("bodyBuild_slim") ?></option>
                            <option value="bodyBuild_athletic" <?php if(isset($filters)){echo $filters['body_build'] == 'bodyBuild_athletic' ? 'selected' : '';} ?>><?php echo $translate->getString("bodyBuild_athletic") ?></option>
                            <option value="bodyBuild_healthy" <?php if(isset($filters)){echo $filters['body_build'] == 'bodyBuild_healthy' ? 'selected' : '';} ?>><?php echo $translate->getString("bodyBuild_healthy") ?></option>
                            <option value="bodyBuild_veryHealthy" <?php if(isset($filters)){echo $filters['body_build'] == '"bodyBuild_veryHealthy' ? 'selected' : '';} ?>><?php echo $translate->getString("bodyBuild_veryHealthy") ?></option>
                         </select>
                    </div>
                    
                    <div class="form-group">
                        <select class="cs-select cs-skin-slide" name="eyes_color">
                            <option value="0" disabled><?php echo $translate->getString("eyesColor") ?></option>
                            <option value="all" <?php if(isset($filters)){echo $filters['eyes_color'] == 'all' ? 'selected' : '';} ?>><?php echo $translate->getString("allEyesColor") ?></option>
                            <option value="green" <?php if(isset($filters)){echo $filters['eyes_color'] == 'green' ? 'selected' : '';} ?>>Green</option>
                            <option value="brown" <?php if(isset($filters)){echo $filters['eyes_color'] == 'brown' ? 'selected' : '';} ?>>Brown</option>
                         </select>
                    </div>
                    
                    <div class="form-group">
                        <select class="cs-select cs-skin-slide" name="hair_color">
                            <option value="0" disabled><?php echo $translate->getString("hairColor") ?></option>
                            <option value="all" <?php if(isset($filters)){echo $filters['hair_color'] == 'all' ? 'selected' : '';} ?>><?php echo $translate->getString("allHairColors") ?></option>
                            <option value="black" <?php if(isset($filters)){echo $filters['hair_color'] == 'black' ? 'selected' : '';} ?>>Black</option>
                            <option value="brown" <?php if(isset($filters)){echo $filters['hair_color'] == 'brown' ? 'selected' : '';} ?>>Brown</option>
                         </select>
                    </div>

                </div>
                <input type="hidden" name="category" value="<?php echo isset($filters['category']) ? $filters['category'] : 'all'; ?>">
                <input type="hidden" name="action" value="getEscortWithFilters">
                <button class="button med-prim-br empty" type="submit" form="filters"><?php echo $translate->getString("applyFilters") ?></button>
            </form>
        </div>
    </div>
    
    <div class="categories section lt-prim-bg white-txt">
        <div class="container">
            <p>
                <strong><?php echo $translate->getString("categories") ?>:</strong>
                <?php foreach($categories->getCategories() as $category){?>
                    <a h-ref="#" class="category" id-category="<?php echo $category->getId() ?>">#<?php echo $category->getCategoryInfo()->getName() ?></a>
                <?php }?>
            </p>
        </div>
    </div>
    
    <div class="escort section">
        <div class="container">
            <div class="wrapper">

                <?php foreach($escorts as $escort){?>
                <div class="profile">
                    <div class="box">
                        <?php if(isset($user) && $user->getId() !== $escort->getId()){ ?>
                        <div class="icons">
                            <a h-ref="#" class="med-prim-bg white-txt message" login="<?php echo $escort->getLogin() ?>"><i class='material-icons'>mail_outline</i></a>
                            <a h-ref="#" onClick="follow(<?php echo $escort->getId() ?>)" class="med-prim-bg white-txt" data-toggle="tooltip" data-placement="left" title="Follow"><i class='follow material-icons <?php if($user->amIfollower($escort)){echo "unfollow heartbeat";} ?>'></i></a>
                        </div>
                        <?php }?>
                        <a href="/model/<?php echo $escort->getLogin() ?>">
                            <div class="photo" style="background:url(<?php echo $escort->getProfilePicture()->getSRCThumbImage() ?>) no-repeat center center"></div>
                            <div class="med-prim-bg white-txt text">
                                <span><?php echo $escort->getLogin() ?>,</span>
                                <span class="lt-txt"><?php echo $escort->getCountry()->getName() ?></span>
                            </div>
                        </a>
                    </div>
                </div>
                <?php }?>

            </div>
            
            <div class="paginate">
                <a href="#" class="prev"><i class="fa fa-arrow-left"></i><span>Previous page</span></a>
                <a href="#" class="next"><span>Next page</span><i class="fa fa-arrow-right"></i></a>
            </div>
            
        </div>
    </div>
    
</div>
<script src="/js/follow.js"></script>
<script type="text/javascript">
    $(".category").on("click", function(){
        $("input[name='category']").val($(this).attr('id-category'));
        $("form#filters").submit();
    })
</script>
<!-- map script -->
<script src='https://maps.googleapis.com/maps/api/js?key=AIzaSyAQidXR9D4haJSWG39Gz_hB-xdZqmCnEnI' type='text/javascript'></script><script type='text/javascript' src='https://www.gstatic.com/charts/loader.js'></script> 
<script type='text/javascript' src='https://www.google.com/jsapi'></script>
<script type='text/javascript'>
google.charts.load('42', {'packages':['geochart']});
google.charts.setOnLoadCallback(drawVisualization);

function drawVisualization() {var data = new google.visualization.DataTable();
    data.addColumn('string', 'Country');
    data.addColumn('number', 'Value'); 
    data.addColumn({type:'string', role:'tooltip'});var ivalue = new Array();

    var country;
    var i;
    var info;
    <?php foreach($countriesForMap as $i => $country){ ?>
        country = <?php echo "'".$country['iso_code']."'"; ?>;
        info = <?php echo "'".$country['country_name']. " - " . $country['country_count'] . " Users'"; ?>;
        i = <?php echo $i; ?>;
        data.addRows([[{v:country,f:info},i,'']]);
        ivalue[country] = 'escort.php?action=addCountryToFilters&country='+country['iso_code'];
    <?php }?>

    var options = {
    backgroundColor: {fill:'#fff',stroke:'#fff' ,strokeWidth:0 },
    colorAxis:  {minValue: 0, maxValue: 0,  colors: ['#9b0c1d']},
    legend: 'none',    
    datalessRegionColor: '#212121',
    displayMode: 'markers', 
    enableRegionInteractivity: 'true', 
    resolution: 'countries',
    sizeAxis: {minValue: 1, maxValue:1,minSize:7,  maxSize: 7},
    region:'world',
    keepAspectRatio: true,
    tooltip: {textStyle: {color: '#212121'}, trigger:'focus', isHtml: false}   
    };
    var chart = new google.visualization.GeoChart(document.getElementById('visualization'));
    google.visualization.events.addListener(chart, 'select', function() {
      var selection = chart.getSelection();
      if (selection.length == 1) {
      var selectedRow = selection[0].row;
      var selectedRegion = data.getValue(selectedRow, 0);
      if(ivalue[selectedRegion] != '') { addCountryToFilters(ivalue[selectedRegion]); }
      }
    });
    chart.draw(data, options);
 }

 function addCountryToFilters(country){
    $("select[name='country'] option[value="+country+"]").attr('selected','selected');
    $("form#filters").submit();
 }
 </script>
 <!-- end map script -->
<?php include_once dirname(__FILE__).'/includes/footer.html.php';?>