<div class="container">
    <div class="row"  style="margin: 50px 0px 0px 0px">
        <h2 class="page-header">Lista de pedidos</h2>
    </div>
    <table class="table table-bordered table-hover">
        <thead>
            <tr> 
                <th>N° Orden</th> 
                <th>N° Tabla</th>
                <th>Proveer</th>
                <th>Estado</th>
                <th>Agregar nueva comida</th>
            </tr>
        </thead>
        <tbody>
            <?php 

                $remarks = isset($_GET['rem']) ? $_GET['rem'] : "" ;
                $query = "SELECT * FROM 'tblorders' o , 'tblusers' u WHERE  o.'USERID' = u.'USERID' AND STATUS='Pending' AND u.'FULLNAME'='".$_SESSION['WAITER_FULLNAME']."'  GROUP BY ORDERNO ORDER BY ORDERID ASC ";
                $mydb->setQuery($query);
                $cur = $mydb->loadResultList();

                foreach ($cur as $result) { 
                    echo '<tr>'; 
                    echo '<td><a href="index.php?view=menu&orderno='.$result->ORDERNO.'&tableno='.$result->TABLENO.'&rem='.$result->REMARKS.'" >'.$result->ORDERNO.'</a></td>'; 
                    echo '<td align="center">'.$result->TABLENO.'</td>';
                    echo '<td>'.$result->FULLNAME.'</td>';
                    echo '<td>'.$result->REMARKS.'</td>';
                    echo  '<td><a href="addmeal.php?view=addmeal&orderno='.$result->ORDERNO.'&tableno='.$result->TABLENO.'&rem='.$result->REMARKS.'" data-toggle="lightbox" class="btn btn-xs btn-primary " data-title="<b>Add Meal</b>">Add Meal</a></td>'; 
                    echo '</tr>';
                    
                } 
            ?> 
        </tbody>
    </table>
</div>

