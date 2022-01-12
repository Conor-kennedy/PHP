<?php
    include_once "dbconfig.php";
?>

<!DOCTYPE html>

<html>

<head>
    
    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style_a3.css">
 
    <title>Sales Reps</title>
    
<style>

    .nosales {
        text-align: center;
        font-size: 25px;
        font-weight: bold;
    }
    
    h2 {
        text-align: center;
    }
    
    caption {
        font-weight: bold;
        font-size: 20px;
    }
    
    table td {
        text-align: center;
    }
    
    
    
</style>   
 
<script>
    
</script>  
    
</head>

<body>
   
<div> 
    
<?php include "nav.php"; ?>
    
</div>
    
<br>
    
    <h2>Click on an Employee's Number to view data</h2>
    
<?php
    
    if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
                }

$sql = "SELECT employees.lastName, employees.firstName, employees.email, employees.officeCode, employees.reportsTo, employees.officeCode, offices.addressLine1, offices.addressLine2, offices.postalCode, employees.jobTitle, employees.employeeNumber, customers.salesRepEmployeeNumber, offices.officeCode 

FROM employees, offices, customers 

WHERE (offices.officeCode = employees.officeCode) AND ((customers.salesRepEmployeeNumber = employees.employeeNumber) OR (employees.jobTitle ='Sales Rep')) Group by employees.employeeNumber";
$result = mysqli_query($conn, $sql);

?>
    <table>
        <tr>
            <th>Code</th>
            <th>Surname</th>
            <th>Firstname</th>
            <th>Email</th>
            <th>Address</th>
            <th>Reporting To</th>
        
        </tr>
        
        
        <?php while($row = mysqli_fetch_array($result)){ ?>
            <tr>
                <td><form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post"><input type="submit" name="empno" class="empno" id="<?php echo $row['employeeNumber']?>" value="<?php echo $row['employeeNumber']?>"></form></td>
                <td><?php echo $row["lastName"]; ?></td>
                <td><?php echo $row["firstName"]; ?></td>
                <td><?php echo $row["email"]; ?></td>
                <td><?php echo $row["addressLine1"]; ?>, <?php echo $row["addressLine2"]; ?>, <?php echo $row["postalCode"]; ?></td>
                <td><?php echo $row["reportsTo"]; ?></td>
            </tr>

        <?php } ?>
        
 
    </table> 
    
    
    <br>
    
 <!--https://tryphp.w3schools.com/showphp.php?filename=demo_global_post!-->   
    
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // collect value of input field
        $empNumber = $_POST['empno'];
        } else {
        }
   
    ?>
    
    <?php
    
    $sql2 = "SELECT orders.orderNumber, customers.customerName, customers.salesRepEmployeeNumber, customers.customerNumber, customers.addressLine1, customers.creditLimit, orders.customerNumber, payments.amount, payments.customerNumber, customers.addressLine2, customers.postalCode FROM customers, orders, payments WHERE (orders.customerNumber = customers.customerNumber) AND (payments.customerNumber = customers.customerNumber) AND (salesRepEmployeeNumber ='$empNumber') GROUP BY orders.orderNumber, customers.customerName, customers.salesRepEmployeeNumber";
    $result2 = mysqli_query($conn, $sql2);
    
    
    ?> 
    
   <div class="nosales">
    <?php 
    if((mysqli_num_rows($result2) == 0) && (!empty($_POST["empno"])))  {
        echo "This employee has no sales yet";
    }
    else {}
    
     
  
    ?>
    </div> 
    <br>
    
    <table>
        
        
        <?php if(mysqli_num_rows($result2) > 0){
    
        echo "<caption>Orders from Customers</caption>";
    
        echo "<tr>";
            echo "<th>Name</th>";
            echo "<th>Address</th>";
            echo "<th>Credit Limit</th>";
            echo "<th>Order Numbers</th>";
            echo "<th>Payments</th>";
        
        echo "</tr>";
        
        
            while($row = mysqli_fetch_array($result2)){ ?>
            <tr>
                <td><?php echo $row['customerName']; ?></td>
                <td>   
                    <?php echo $row["addressLine1"] ?>, <?php echo $row["postalCode"] ?></td>
                <td><?php echo $row["creditLimit"]; ?></td>
                <td><?php echo $row["orderNumber"]; ?></td>
                <td><?php echo $row["amount"]; ?></td>
            </tr>

        <?php } }
        
        else {} ?> 
        
    
    </table> 

    <br>
      
    
<?php  
    
$sql3 = "SELECT payments.customerNumber, customers.customerName, round(SUM(amount),2) as amount

From

payments join customers on payments.customerNumber = customers.customerNumber

join employees on customers.salesRepEmployeeNumber = employees.employeeNumber where customers.salesRepEmployeeNumber = $empNumber

Group by payments.customerNumber, customers.customerName";
    
    $result3 = mysqli_query($conn, $sql3);

    ?>
  
  <p>dkgfkgnfkgkf</p>
    <div>   
    <table>
        
        <?php if(mysqli_num_rows($result3) > 0){
    
        echo "<caption>Total Payments Received</caption>";
    
        echo "<tr>";
            echo "<th>Name</th>";
            echo "<th>Total Payments</th>";
        echo "</tr>";
        
        
         while($row = mysqli_fetch_array($result3)){ ?>
            <tr>
                <td><?php echo $row['customerName']; ?></td>
                <td><?php echo $row["amount"]; ?></td>
            </tr>

        <?php  }}
        else {echo "dfdgd";} ?> 
        
        
 
    </table> 
    </div>
    
        <br>
   <p>dkgfkgnfkgkf</p>
      <p>dkgfkgnfkgkf</p>
      <p>dkgfkgnfkgkf</p>
      <p>dkgfkgnfkgkf</p>
    
<?php  
    
$sql4 = "SELECT customers.salesRepEmployeeNumber, round(Sum(amount),2) as amount

From

payments join customers on payments.customerNumber = customers.customerNumber

join employees on customers.salesRepEmployeeNumber = employees.employeeNumber where customers.salesRepEmployeeNumber = $empNumber

Group by customers.salesRepEmployeeNumber";

    $result4 = mysqli_query($conn, $sql4);

    ?>
    
      <p>dkgfkgnfkgkf</p>
    <div>
    <table>
        
        <?php if(mysqli_num_rows($result3) > 0){

        
        echo "<th>Total Sales by Rep</th>";
        
         while($row = mysqli_fetch_array($result4)){ ?>
            <tr>
                <td><?php echo $row["amount"]; ?></td>
            </tr>

        <?php }}
        else {}?>

    </table> 

    </div>
     
    <br>


    
    <?php include "footer.php"; ?> 
    

    
  

</body>

</html>