<div class="section requests edit animated fadeIn"><!--strona odnosi się do edycji requestów i activities-->
    <h4 class="dashboard-heading">Edit an activity</h4>
            
    <div class="form">
        
        <form>
            
            <div class="part">
                
                <div class="form-group"><!--mozna zmienić-->
                    <label>Date and time:</label>
                    <div class='input-group date' id='datetimepicker1'>
                        <input type='text' class="form-control" />
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>
                
                <div class="form-group"><!--brak możliwości zmiany-->
                    <label>Type of activity:</label>
                    <div class="select">
                        <select disabled>
                            <option value="private-chat" selected>Private webcam performance with chat only</option>
                            <option value="private-all">Private webcam performance with 2-way audio/video</option>
                            <option value="person">In person</option>
                         </select>
                    </div>
                </div>
                
                <div class="form-group"><!--tylko dla private webcam i in person, brak mozliwości zmiany-->
                    <label>Username:</label>
                    <input type="text" placeholder="Enter username" disabled>
                </div>
                
                <div class="form-group"><!--tylko dla private webcam i in person-->
                    <label>Choose activity:</label>
                    <div class="select">
                        <select>
                            <option value="1">Activity 1</option>
                            <option value="2">Activity 2</option>
                            <option value="3">Activity 3</option>
                         </select>
                    </div>
                </div>

                <div class="form-group"><!--tylko dla private webcam-->
                    <label>Min. duration (in minutes):</label>
                    <input type="text" placeholder="Minimum duration">
                </div>

                <div class="form-group"><!--tylko dla in person, dla activity ktore maja zdefinowana cenę na godzinę a nie za całość-->
                    <label>Duration (in hours):</label>
                    <input type="text" placeholder="Duration">
                </div>
                  
                <div class="form-group"><!--tylko dla private webcam i in person-->
                    <label>Confirm or change the price (in tokens):</label>
                    <input type="text" placeholder="Price" value="99">
                </div>

                <div class="form-group"><!--tylko dla private webcam i in person-->
                    <label>Additional comments:</label>
                    <textarea placeholder="Enter additional information"></textarea>
                </div>

                <div class="form-group checkbox"><!--tylko dla private webcam performance-->
                    <input type="checkbox" id="checkbox3">
                    <label for="checkbox3">
                        Spy cam enabled
                    </label>
                </div>
                
                <div class="part">
                    <!--tylko dla private webcam performance-->
                    <p class="xl-txt"><strong>Price per minute: </strong><span>99 <i class="fa fa-diamond"></i></span></p>

                    <!--tylko dla in person-->
                    <p class="xl-txt"><strong>Total price: </strong><span>999 <i class="fa fa-diamond"></i></span></p>
                </div>
                        
            </div> 
            
            <input type="submit" class="button med-prim-bg" value="Save" />
            
        </form>
    </div>
</div>

<script type="text/javascript" src="js/fileinput.min.js"></script>
<script type="text/javascript">
    $(function () {
        $('#datetimepicker1').datetimepicker();
    });
</script>