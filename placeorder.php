<?php
session_start();
include 'connect_database.php';
$total_price=$CASING=$CPU=$GPU=$RAM=$mb=$SSD=$HDD=$ps=$CPU_COOLER=$userid='';
if (isset($_POST['submit-order']))
{
   
        
            $total_price=$_SESSION['total_price'];
            $CASING=$_SESSION['CASING_full_name'];
            $CPU=$_SESSION['CPU_full_name'];
            $GPU=$_SESSION['GPU_full_name'];
            $RAM=$_SESSION['RAM_full_name'];
            $mb=$_SESSION['mb_full_name'];
            $SSD=$_SESSION['SSD_full_name'];
            $HDD=$_SESSION['HDD_full_name'];
            $ps=$_SESSION['PSU_full_name'];
            $CPU_COOLER=$_SESSION['CPU_COOLER_full_name'];
            $userid=$_SESSION['customer'];
            $mode_of_payment=$_POST['payment'];
            $sql="INSERT INTO `product_details`(`userid`, `model_name`,`CPU_id`,`GPU_id`,`RAM_id`,`mb_id`,`SSD_id`,`HDD_id`,`ps_id`,`cooler_id`,`total_price`,`mode_of_payment`) VALUES ('$userid','$CASING','$CPU','$GPU','$RAM','$mb','$SSD','$HDD','$ps','CPU_COOLER','$total_price','$mode_of_payment')";

            
            if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
            echo '<script> window.location.href = "order_success.php";
            alert("Ordered Successfully");
                        </script>';
            } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    

?>