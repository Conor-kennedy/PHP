<?php
    include_once "dbconfig.php";
?>

<!DOCTYPE html>

<html>

<head>
    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style_a3.css">
 
    <title>Home</title>
    
    
<style>
    

    
    #formcenter {
        margin-left: 40%;
        margin-right: 40%;
        margin-bottom: 10px;
        text-align: center;
        background-color: aqua;
        border-style: dashed;
        padding-top: 10px;
        margin-top: 10px;
        padding-bottom: 10px;
    }
    
    .stringentered {
        text-align: center;
        font-size: 25px;
        font-weight: bold;
    }

</style>   
    
</head>

<body>
    
<div> 
    
<?php include "nav.php"; ?>
    
</div>

<div id="formleft"></div>
    
<div id="formcenter">  
    
<form method="post" action="index1.php">
    
<div>
    <p>Filter by Product Line</p> 

    <select name="productlines" style="display: table-row;">
                   <option>All Options</option>
                   <option value="Motorcycles">Motorcycles</option>
                   <option value="Classic Cars">Classic Cars</option>
                   <option value="Trucks and Buses">Trucks and Buses</option>
                   <option value="Vintage Cars">Vintage Cars</option>
                   <option value="Planes">Planes</option>
                   <option value="Ships">Ships</option>
                   <option value="Trains">Trains</option>
                   
    </select> 
    </div>

    <div>
    <div><p>Sort by Quantity:</p></div>
        
    <div id="mostsection"><input onclick="myFunction()" id="buttonmost" type="checkbox" name="buttonmost"><label for="buttonmost">Most in Stock</label></div>
    
    <div id="leastsection"><input onclick="myFunct()" id="buttonleast" type=checkbox name="buttonleast"><label for="buttonleast">Least in Stock</label></div>
    </div>
    

<div>

    <p>Enter Stock Amount</p><input type="text" name="stockamount">
    
</div>  
    
<div>
    <br>
    <input type="submit">
    
</div>
</form>
    
</div>  

<div id="formright"></div>

<?php
    
    if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
                }

$sql = "SELECT productCode, productName, productLine, productDescription, quantityInStock, MSRP FROM products WHERE (productLine='Planes' OR productLine ='Classic Cars')";
$result = mysqli_query($conn, $sql);

?>
  <!--  <table>
        <tr>
            <th>Name</th>
            <th>Code</th>
            <th>Description</th>
            <th>Quantity</th>
            <th>MSRP</th>
        
        </tr>
      //  <?php while($row = mysqli_fetch_array($result)){ ?>
            <tr>
            //    <td><?php echo $row["productName"]; ?></td>
            //    <td><?php echo $row["productCode"]; ?></td>
            //    <td><?php echo $row["productDescription"]; ?></td>
            //    <td><?php echo $row["quantityInStock"]; ?></td>
             //   <td><?php echo $row["MSRP"]; ?></td>
            </tr>

     //   <?php } ?>
        
 
</table> !-->

    <div class="stringentered">
    
    <?php
    
    if(!empty($_POST["stockamount"]) && (!is_numeric($_POST["stockamount"]))) {
        echo "This entry does not make sense!";
    }
    else {}
        
    
    ?>
        
    </div>
    
<?php
    
    if(!empty($_POST["stockamount"])){
        $stockamount = $_POST["stockamount"];
            
        
    }
    else {
        $stockamount = 1000000000;
    }
    
    
    
    if (!empty($_POST["buttonleast"])){
        $stockorder = "ASC";
        
    }
    else {
        $stockorder = "DESC";
        
    }
    
    if (!(isset($_POST["productlines"]))) {
        $linetype = "(productLine='Planes' OR productLine ='Classic Cars' OR productLine ='Motorcycles' OR productLine ='Trucks and Buses' OR productLine ='Ships' OR productLine ='Trains' OR productLine ='Vintage Cars')";
    } 
    
    elseif (!empty($_POST["productlines"]) AND $_POST["productlines"] == "All Options"){
        $linetype = "(productLine='Planes' OR productLine ='Classic Cars' OR productLine ='Motorcycles' OR productLine ='Trucks and Buses' OR productLine ='Ships' OR productLine ='Trains' OR productLine ='Vintage Cars')";
         
    }
    
    else {
        $type = $_POST["productlines"];
        $linetype = "productLine = '$type'";
        
    }
    
   
    
   
$sql3 = "SELECT productCode, productName, productLine, productDescription, quantityInStock, MSRP FROM products WHERE $linetype AND quantityInStock < $stockamount ORDER BY quantityInStock $stockorder";
$result3 = mysqli_query($conn, $sql3);

  
?>
<div>
    <table>
        <tr>
            <th>Name</th>
            <th>Code</th>
            <th>Description</th>
            <th>Quantity</th>
            <th>MSRP</th>
        </tr>
        
        <?php while($row = mysqli_fetch_array($result3)){ ?>
        
            <tr>
                <td><?php echo $row["productName"]; ?></td>
                <td><?php echo $row["productCode"]; ?></td>
                <td><?php echo $row["productDescription"]; ?></td>
                <td><?php echo $row["quantityInStock"]; ?></td>
                <td><?php echo $row["MSRP"]; ?></td>
            </tr>

        <?php } ?>
        
    </table>
       
</div>

    
<br>   

    
<div>  
    
    <?php include "footer.php"; ?> 
    
</div>      
    
    
    
    
    
<script>
    
   function myFunct() {
       var yy = document.getElementById("buttonleast");
       var xx = document.getElementById("mostsection");
       if (yy.checked == true) {
           xx.style.display = "none";
       } else {
           xx.style.display = "block";
       }
       
   }
    
    
   function myFunction() {
       var y = document.getElementById("buttonmost");
       var x = document.getElementById("leastsection");
       if (y.checked == true) {
           x.style.display = "none";
       } else {
           x.style.display = "block";
       }
       
   }
    
  
    
</script>
    


</body>



</html>