<div class="section age animated fadeIn">
    <h4 class="dashboard-heading">Adult age confirmation</h4>
    
    <div class="form">
        
        <form>
            
            <div class="legal mCustomScrollbar">
                <p>Lorem ipsum dolor sit amet turpis egestas. Mauris pretium, ipsum vel laoreet nisl sapien et purus vitae velit non eros. Donec non ipsum. Praesent magna.</p>

                <p>Phasellus a sapien. Curabitur vitae eros sed nunc sem, accumsan vitae, nibh. Morbi quam ut urna dapibus nisl at laoreet urna fringilla vel, nibh. Suspendisse rutrum in.</p>

                <p>Nulla aliquet congue id, orci. Nullam in faucibus lectus varius vitae, faucibus augue. Sed sollicitudin arcu. In hac habitasse platea dictumst. Maecenas arcu luctus et massa. Ut wisi vel nibh. Cras magna diam, suscipit urna.</p>

                <p>Curae, Donec vitae felis. Nullam at consequat et, neque. Etiam condimentum convallis. Fusce posuere cubilia Curae, Nulla iaculis quis, velit. Cum sociis natoque penatibus et malesuada eros, rhoncus nunc. Praesent quis tortor. Maecenas.</p>

                <p>Nam in leo non dui. Cras vitae convallis eu, ullamcorper quam. Cum sociis natoque penatibus et ultrices adipiscing elit. Sed ac risus. Sed fringilla enim, malesuada neque vitae felis. Donec id nisl. Vestibulum ut lorem. Integer lacinia dignissim, tellus. Donec tempus purus sit amet, felis. Donec nonummy malesuada.</p>

                <p>Cras dictum sed, dui. Cras ac lacus nulla in purus at nulla. Phasellus placerat pulvinar, pede.</p>

                <p>In hac habitasse platea dictumst. Praesent quis lectus est eu orci. Vestibulum consectetuer arcu quis massa. Maecenas semper auctor. Maecenas arcu faucibus ligula. Cras vitae mi. Suspendisse et interdum malesuada. Nullam sed quam et purus sit amet, consectetuer tincidunt congue. Donec vitae lectus orci, sollicitudin fermentum, metus nonummy.</p>

                <p>Cum sociis natoque penatibus et ultrices velit suscipit mauris. Nullam magna ac nulla. Pellentesque suscipit luctus. Sed tempus ut, ligula. Sed sit amet sapien dui quis nibh. Ut eu pulvinar ut, gravida tempor.</p>

                <p>Integer tincidunt eget, pede. Vestibulum rutrum molestie, neque quis tortor. Etiam lobortis mauris dui sodales quam. Pellentesque commodo a, volutpat elit, interdum velit non risus. Cras.</p>

                <p>Quisque vehicula erat. Fusce purus in quam quam in accumsan orci. Sed ipsum dolor sit amet magna. Curabitur scelerisque eu, ullamcorper.</p>

                <p>Aenean posuere eu, facilisis dignissim dolor lacus, congue dolor. Integer leo at sapien. Proin posuere. Vestibulum eget nunc eu magna lectus, pellentesque sed.</p>

                <p>Cum sociis natoque penatibus et massa. Donec pharetra pede. Cras turpis egestas. Praesent elit eu pulvinar enim.</p>
            </div>
            
            <div class="form-group checkbox">
                <input type="checkbox" id="checkbox1">
                <label for="checkbox1">
                    lorem ipsum dolor sit amet
                </label>
            </div>
            
            <div class="form-group">
                <label>Name:</label>
                <input type="text" placeholder="Name">
            </div>
            
            <div class="form-group">
                <label>Last name:</label>
                <input type="text" placeholder="Last name">
            </div>
            
            <div class="form-group">
                <label>Date of birth:</label>
                <div class='input-group date' id='datetimepicker10'>
                    <input type='text' class="form-control" />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>
            
            <div class="form-group">
                <label>Upload an id:</label>
                <input id="upload-avatar" type="file" class="file" data-show-preview="false" data-show-upload="false" data-show-remove="false" placeholder="Choose a file">
            </div>

            <a href="#" class="med-prim-br empty button">Previous step</a>
            <a href="profile-created.php" class="med-prim-bg button">Finish profile creation</a>
        
        </form>
        
    </div>
</div>	

<script type="text/javascript" src="js/fileinput.min.js"></script>
<script src="js/jquery.mCustomScrollbar.concat.min.js"></script>

<script type="text/javascript">
    $(function () {
        $('#datetimepicker10').datetimepicker({
            viewMode: 'years',
            format: 'DD/MM/YYYY'
        });
    });
</script>