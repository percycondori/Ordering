<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<title>
    <?php
      $sql = "SELECT * FROM `tbltitle` WHERE TItleID=1";
                 $mydb->setQuery($sql);
                $viewTitle = $mydb->loadSingleResult();
                echo $viewTitle->Title;
    ?>
</title>
 
 <!-- Bootstrap Core CSS -->
    <link href="<?php echo web_root; ?>admin/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?php echo web_root; ?>admin/css/sb-admin.css" rel="stylesheet">


    <link href="<?php echo web_root; ?>admin/css/dataTables.bootstrap.css" rel="stylesheet" type="text/css">

    <link href="<?php echo web_root; ?>admin/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css"> 

      <link href="<?php echo web_root; ?>css/bootstrap-timepicker.min.css" rel="stylesheet" type="text/css"> 

    <!-- Custom Fonts -->
    <link href="<?php echo web_root; ?>admin/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"> 

    <!-- light box -->
    <link href="<?php echo web_root; ?>admin/css/ekko-lightbox.css" rel="stylesheet">

    <!-- <link href="<?php echo web_root; ?>css/screen.css" rel="stylesheet"> -->
    <link href="<?php echo web_root; ?>css/jquery.treetable.css" rel="stylesheet">
        <link href="<?php echo web_root; ?>css/jquery.treetable.theme.default.css" rel="stylesheet">


    <!-- <link rel="icon" href="<?php echo web_root; ?>favicon-1.ico" type="image/x-icon"> -->

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]--> 


</head>

  <?php
   //admin_confirm_logged_in();
  if (!isset($_SESSION['ADMIN_USERID'])){
      redirect(web_root."admin/login.php");
     } 
     
  $todaysales = 0;
  $query = "SELECT SUM(TOTALPAYMENT) AS 'SALES' FROM `tblpayments`  
             WHERE  DATE(TRANSDATE) =CURDATE()";
        $mydb->setQuery($query);
        $cur = $mydb->loadSingleResult();
        $todaysales = $cur->SALES;
 

   $query = "SELECT * FROM `tblorders`  
             WHERE  STATUS='Pending' GROUP BY ORDERNO ";
        $mydb->setQuery($query);
        $cur = $mydb->executeQuery();

        $maxrow = $mydb->num_rows($cur);

                $sql = "SELECT * FROM `tbltitle` WHERE TItleID=1";
                 $mydb->setQuery($sql);
                $viewTitle = $mydb->loadSingleResult(); 
?>

<style type="text/css">
  .nav{
    font-size: 16px;
  }
</style>
      
<body>
<div id="wrapper">
        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Navegación de palanca</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <?php 
                if ($_SESSION['ADMIN_ROLE']=='Administrator') {
                  # code...
             ?>
                <a class="navbar-brand" href="../changetitle.php" style="font-size: 35px;" data-toggle="lightbox" data-title="Change Title"><?php
                echo $viewTitle->Title;;
            ?> </a>
          <?php }else if($_SESSION['ADMIN_ROLE']=='Cashier'){ ?>
                <a class="navbar-brand"><?php
                echo $viewTitle->Title;;
            ?> </a>
        <?php    } ?>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
 
                <!-- account -->
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" style="font-size: 20px;" data-toggle="dropdown"><i class="fa fa-user-o"></i> <?php echo $_SESSION['ADMIN_FULLNAME']; ?> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li style="font-size: 15px;">
                            <a href="<?php echo web_root; ?>admin/logout.php"><i class="fa fa-fw fa-sign-out"></i>Cerrar sesión</a>
                        </li>
                    </ul>
                </li>
                <!-- end account -->
            </ul> 
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->

            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav"> 

<?php if ($_SESSION['ADMIN_ROLE']=='Cashier' || $_SESSION['ADMIN_ROLE']=='Administrator') { ?> 
                    <li class="<?php echo ($_GET['view']== 'POS' || $_GET['view']== 'addmeal') ? "active" : false;?>">
                        <a href="<?php echo web_root; ?>admin/orders/index.php?view=POS"><i class="fa fa-fw fa-th-list"></i> Pedidos <div id="notif" class="label label-danger"><?php echo $maxrow; ?></div></a>
                    </li> 
<?php } ?>
<?php if ($_SESSION['ADMIN_ROLE']=='Administrator'  || $_SESSION['ADMIN_ROLE']=='Cashier') { ?> 
                    <li class="<?php echo (currentpage() == 'table') ? "active" : false;?>">
                        <a href="<?php echo web_root; ?>admin/table/"><i class="fa fa-fw fa-table"></i> Mesas</a>
                    </li>
<?php } ?>
<?php if ($_SESSION['ADMIN_ROLE']=='Administrator'  || $_SESSION['ADMIN_ROLE']=='Cashier') { ?> 
                    <li class="<?php echo (currentpage() == 'meals') ? "active" : false;?>">
                        <a href="<?php echo web_root; ?>admin/meals/"><i class="fa fa-cutlery"></i> Comidas</a>
                    </li>
                    <li class="<?php echo (currentpage() == 'category') ? "active" : false;?>">
                        <a href="<?php echo web_root; ?>admin/category/"><i class="fa fa-align-left"></i> Categorias</a>
                    </li>
<?php } ?>                  
<?php if ($_SESSION['ADMIN_ROLE']=='Administrator' || $_SESSION['ADMIN_ROLE']=='Admin') {?> 
                    <li class="<?php echo (currentpage() == 'user') ? "active" : false;?>">
                        <a href="<?php echo web_root; ?>admin/user/"><i class="fa fa-users"></i> Usuarios</a>
                    </li>
<?php } ?>
<?php if ($_SESSION['ADMIN_ROLE']=='Administrator') { ?>
                    <li class="<?php echo (currentpage() == 'report') ? "active" : false;?>">
                        <a href="<?php echo web_root; ?>admin/report/"><i class="fa fa-bar-chart"></i> Reporte Ventas</a>
                    </li>
<?php } ?>
<?php if ($_SESSION['ADMIN_ROLE']=='Administrator'  || $_SESSION['ADMIN_ROLE']=='Cashier') { ?> 
                    <li>
                      <form target="_blank" action="<?php echo web_root;?>admin/orders/reprint.php" method="POST"> 
                        <label style="margin-left: 30px;color: #fff;margin-top: 5px;"> No. de Pedido</label><br/>
                        <input class="form-control" type="" name="orderno" style="width: 120px; color: black; margin-left: 10px;margin-bottom: 5px; font-weight: bold; font-size: 15px; text-align: center;">
                        <input type="submit" name="Re-print" value="Re-print OR" style="width: 120px;margin-left: 10px; font-size: 15px;" class="btn btn-primary btn-sm">
                      </form>
                    </li> 
<?php } ?>  
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
               <div class="row" > 

                   <?php   check_message();  ?>   

                  <?php require_once $content; ?> 
              </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->


<!-- jQuery --> 
<script src="<?php echo web_root; ?>admin/jquery/jquery.min.js"></script> 
<!-- Bootstrap Core JavaScript -->
<script src="<?php echo web_root; ?>admin/js/bootstrap.min.js"></script>

<script src="<?php echo web_root; ?>admin/js/jquery.dataTables.min.js"></script>
<script src="<?php echo web_root; ?>admin/js/dataTables.bootstrap.min.js"></script>

<script type="text/javascript" src="<?php echo web_root; ?>admin/js/bootstrap-datepicker.js" charset="UTF-8"></script>
<script type="text/javascript" src="<?php echo web_root; ?>admin/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script type="text/javascript" src="<?php echo web_root; ?>admin/js/bootstrap-datetimepicker.uk.js" charset="UTF-8"></script>

<script type="text/javascript" src="<?php echo web_root; ?>js/bootstrap-timepicker.min.js" charset="UTF-8"></script>

<script type="text/javascript" src="<?php echo web_root; ?>admin/js/janobe.js" charset="UTF-8"></script> 

<script src="<?php echo web_root; ?>admin/js/ekko-lightbox.js"></script>
<script src="<?php echo web_root; ?>admin/js/lightboxfunction.js"></script> 

<script src="<?php echo web_root; ?>js/jquery.treetable.js" type="text/javascript"></script>
 

<script type="text/javascript">
   $('.timepicker1').timepicker();
$(".mytbl").treetable({ expandable: true });
$(".mytblprint").treetable();
</script>

 <!-- event hanler of new order -->
<script type="text/javascript">

$("#expandAllTasks").on("click", function(){
  // alert("yes")
  // e.preventDefault();
  $('.mytbl').treetable('expandAll');
});
    

$("#expandable").on("click", function(){ 
  // e.preventDefault(); 
 $(".mytbl").treetable('collapseAll');
});
    
     $(document).on("click",".addcartadmin",function(){
       var id = $(this).data("id");
       // alert(id)
       $.ajax({
        type : "POST",
        url : "addtocart.php",
        dataType : "text",
        data :{MEALID:id},
        success : function(data) {
          // alert(data);
           $("#cart").html(data);
           $("#addnotif").hide();
           $("#addnotif").show()
           $("#addnotif").html("Meal added to Cart"); 
           setInterval(function(){
           $("#addnotif").hide();  
        },3000)

        }

       });
     });

     $(document).on("click",".removecartadmin",function(){
        var id = $(this).data("id");
        // alert(id)
        $.ajax({
        type : "POST",
        url : "deletecart.php",
        dataType : "text",
        data :{MEALID:id},
        success : function(data) {
           $("#cart").html(data);
           $("#addnotif").hide();
           $("#addnotif").show()
           $("#addnotif").html("Meal removed in the cart"); 
           setInterval(function(){
           $("#addnotif").hide();  
        },3000)

        }

       });
     });
     // end of event handler of new order
     // ***********************************************************
// search for meals event handler
     $(document).on("keyup","#id_search",function(){
        var meal = document.getElementById("id_search").value;

        $.ajax({
          url: "meals.php",
          type : "POST",
          dataType : "text",
          data : {MEAL:meal},
          success : function(data){
            $("#resulttable").html(data);
          }

        });

     });
    // end of search meals event handler
    // 

// senior citizen
$(document).on("click", ".seniorcitizen",function(){


 
  var subtot = document.getElementById("totalamount").value;
  var seniorpercent = document.getElementById("SENIORCITIZEN");
  var overalltot=0;
  var convertval =0;
  var seniorval=0;
  var vat=0;
  var vatable = 0;
  var senioraddno = document.getElementById("SENIORADDNO").value;
  var totsenioraddno=0;


  // alert(senioraddno);

  if (seniorpercent.checked==false) {
    try {
        // alert(subtot)
      document.getElementById("SENIORADDNO").disabled = true
    document.getElementById("SENIORID").disabled = true
      document.getElementById("SENIORADDNO").value = ""
    document.getElementById("SENIORID").value = ""
       var totsub=0;
        totsub = parseFloat(subtot) + parseFloat(0);

        // alert(totsub)
        document.getElementById("overalltotal").value =totsub;
        $("#overalltot").val(totsub.toFixed(2));

     }
    catch(err) {
     alert(err.message);
    } 

}else{
    document.getElementById("SENIORADDNO").disabled = false
    document.getElementById("SENIORID").disabled = false

    
   //  vat = subtot / 1.12;

   //  // alert(vat)

   //  // vatable = subtot - vat;

   //  // alert(vatable);



   // seniorval =vat * .20;

   // // alert(seniorval);

   //  overalltot = vat - seniorval;

   //  document.getElementById("overalltotal").value = overalltot;

   //  document.getElementById("overalltot").value = overalltot.toFixed(2);

}








 //  seniorval = seniorpercent / 100 * subtot;

 //  overalltot = subtot - seniorval;

 // document.getElementById("overalltotal").value = overalltot;

 // document.getElementById("overalltot").value = overalltot;




});


$("#SENIORADDNO").change(function(){
  var subtot = document.getElementById("totalamount").value;
  var seniorpercent = document.getElementById("SENIORCITIZEN");
  var overalltot=0;
  var convertval =0;
  var seniorval=0;
  var vat=0;
  var vatable = 0;
  var senioraddno = document.getElementById("SENIORADDNO").value;
  var totsenioraddno=0;


  if (senioraddno=="") {
    var totsub=0;
        totsub = parseFloat(subtot) + parseFloat(0);

        // alert(totsub)
        document.getElementById("overalltotal").value =totsub;
        $("#overalltot").val(totsub.toFixed(2));
      }else{
         vat = subtot / 1.12;

      // alert(vat)

      // vatable = subtot - vat;

      // alert(vatable); 

      $totsenioraddno = .20 * senioraddno;

      seniorval =vat * $totsenioraddno;

      // alert(seniorval);

      overalltot = vat - seniorval;

      document.getElementById("overalltotal").value = overalltot;

      document.getElementById("overalltot").value = overalltot.toFixed(2);
      }

     
    });


$("#SENIORADDNO").keyup(function(){
  var subtot = document.getElementById("totalamount").value;
  var seniorpercent = document.getElementById("SENIORCITIZEN");
  var overalltot=0;
  var convertval =0;
  var seniorval=0;
  var vat=0;
  var vatable = 0;
  var senioraddno = document.getElementById("SENIORADDNO").value;
  var totsenioraddno=0;


  if (senioraddno=="") {
    var totsub=0;
        totsub = parseFloat(subtot) + parseFloat(0);

        // alert(totsub)
        document.getElementById("overalltotal").value =totsub;
        $("#overalltot").val(totsub.toFixed(2));
      }else{
         vat = subtot / 1.12;

      // alert(vat)

      // vatable = subtot - vat;

      // alert(vatable); 

      $totsenioraddno = .20 * senioraddno;

      seniorval =vat * $totsenioraddno;

      // alert(seniorval);

      overalltot = vat - seniorval;

      document.getElementById("overalltotal").value = overalltot;

      document.getElementById("overalltot").value = overalltot.toFixed(2);
      }

     
    });


 // end for senior citizen
 // ******************************************************************

        </script> 

</body>
</html>