<?php
    if (!isset($_SESSION['ADMIN_USERID'])){
      redirect(web_root."admin/index.php");
     }
if(!$_SESSION['ADMIN_ROLE']=='Administrator'){
  redirect(web_root."admin/index.php");
}
 
?> 
 <form class="form-horizontal span6" action="controller.php?action=add" method="POST" enctype="multipart/form-data">
 <div class="row">
         <div class="col-lg-12">
            <h1 class="page-header">Agregar nueva comida</h1>
          </div>
          <!-- /.col-lg-12 -->
       </div> 

                 <div class="form-group">
                    <div class="col-md-8">
                      <label style="font-size: 20px;" class="col-md-4 control-label" for="MEALS">Comida:</label>
                      <div class="col-md-8">
                        <input class="form-control input-lg" id="MEALS" name="MEALS" placeholder="Descripción de la Comida" type="text" value="" required>
                      </div>
                    </div>
                  </div>  

                  <div class="form-group">
                    <div class="col-md-8">
                      <label style="font-size: 20px;" class="col-md-4 control-label" for="CATEGORYID">categoría:</label>

                      <div class="col-md-8">
                       <select class="form-control input-lg" name="CATEGORYID" id="CATEGORYID">
                          <option value="None">Selecciona una categoría</option>
                          <?php
                            //Statement
                          $mydb->setQuery("SELECT * FROM `tblcategory`");
                          $cur = $mydb->loadResultList();

                        foreach ($cur as $result) {
                          echo  '<option value='.$result->CATEGORYID.' >'.$result->CATEGORY.'</option>';
                          }
                          ?>
          
                        </select> 
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="col-md-8"> 
                       <label style="font-size: 20px;" class="col-md-4 control-label" for="PRICE">Precio:</label>

                      <div class="col-md-8">
                         <input class="form-control input-lg" id="PRICE"  step="any" name="PRICE" placeholder=
                            "s/" type="text" value="" required>
                      </div>
                    </div>
                  </div>

  
                  <div class="form-group">
                    <div class="col-md-8">
                      <label style="font-size: 20px;" class="col-md-4 control-label" style="text-align: right;" for="image">Subir Imagen:</label>
                      <div style="padding-top: 10px;" class="col-md-8">
                      <input style="font-size: 15px;" type="file" name="image" value="" id="image" required/>
                      </div>
                    </div>
                  </div>
            
             <div class="form-group">
                    <div class="col-md-8">
                      <label class="col-md-4 control-label" for="idno"></label>
                      <div class="col-md-8">
                        <button style="width: 100%;font-size: 15px;" class="btn  btn-primary btn-sm" name="save" type="submit" ><span class="fa fa-save fw-fa"></span> Guardar</button>
                      </div>
                    </div>
                  </div>

               
        <div class="form-group">
                <div class="rows">
                  <div class="col-md-6">
                    <label class="col-md-6 control-label" for="otherperson"></label>

                    <div class="col-md-6">
                   
                    </div>
                  </div>

                  <div class="col-md-6" align="right">
                   

                   </div>
                  
              </div>
              </div>
          
        </form>
      

       