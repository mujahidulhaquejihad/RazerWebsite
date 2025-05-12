<?php
  session_start();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Custom Rigs</title>
    <link rel="stylesheet" href="./styles/custom_rig.css" />
  </head>
  <body>
    <!-- header -->
    <?php 
      include 'navigation.php';
      include 'connect_database.php';//$conn connection
      
      $total=0;
      $CASING=$CPU=$GPU=$RAM=$mb=$SSD=$HDD=$PSU=$CPU_COOLER="";

      if (isset($_POST['submit'])) // fetching values
      {
         if(!empty($_POST['CASING']))
         {
           $CASING=$_POST['CASING'];
         }
         if(!empty($_POST['CPU']))
         {
           $CPU=$_POST['CPU'];
         }
         if(!empty($_POST['GPU']))
         {
           $GPU=$_POST['GPU'];
         }
         if(!empty($_POST['RAM']))
         {
           $RAM=$_POST['RAM'];
         }
         if(!empty($_POST['mb']))
         {
           $mb=$_POST['mb'];
         }
         if(!empty($_POST['SSD']))
         {
           $SSD=$_POST['SSD'];
         }
         if(!empty($_POST['HDD']))
         {
           $HDD=$_POST['HDD'];
         }
         if(!empty($_POST['PSU']))
         {
           $PSU=$_POST['PSU'];
         }
         if(!empty($_POST['CPU_COOLER']))
         {
           $CPU_COOLER=$_POST['CPU_COOLER'];
         }
              
        //  setting $_SESSION['CASING_price'] and $_SESSION['CASING_full_name']
         $new1=(int)$CASING;
         $_SESSION['CASING_price']=$new1;
         $res1=mysqli_query($conn, "select full_name from CASING where price= $new1");
         $data1=mysqli_fetch_assoc($res1);
         $_SESSION['CASING_full_name'] = $data1['full_name'];
         echo $_SESSION['CASING_full_name'];
          
        //  setting $_SESSION['CPU_price'] and $_SESSION['CPU_full_name']
         $new2=(int)$CPU;
         $_SESSION['CPU_price']=$new2;
         $res2=mysqli_query($conn, "select CPU_full_name from CPU where price= $new2");
         $data2=mysqli_fetch_assoc($res2);
         $_SESSION['CPU_full_name'] = $data2['CPU_full_name'];
         
        //  setting $_SESSION['GPU_price'] and $_SESSION['GPU_full_name']
         $new3=(int)$GPU;
         $_SESSION['GPU_price']=$new3;
         $res3=mysqli_query($conn, "select GPU_full_name from GPU where price= $new3");
         $data3=mysqli_fetch_assoc($res3);
         $_SESSION['GPU_full_name'] = $data3['GPU_full_name'];
         
        //  setting $_SESSION['RAM_price'] and $_SESSION['RAM_full_name']
         $new4=(int)$RAM;
         $_SESSION['RAM_price']=$new4;
         $res4=mysqli_query($conn, "select RAM_full_name from RAM where price= $new4");
         $data4=mysqli_fetch_assoc($res4);
         $_SESSION['RAM_full_name'] = $data4['RAM_full_name'];
         
        //  setting $_SESSION['mb_price'] and $_SESSION['mb_full_name']
         $new5=(int)$mb;
         $_SESSION['mb_price']=$new5;
         $res5=mysqli_query($conn, "select mb_full_name from MOTHERBOARD where price= $new5");
         $data5=mysqli_fetch_assoc($res5);
         $_SESSION['mb_full_name'] = $data5['mb_full_name'];
         
        //  setting $_SESSION['SSD_price'] and $_SESSION['SSD_full_name']
         $new6=(int)$SSD;
         $_SESSION['SSD_price']=$new6;
         $res6=mysqli_query($conn, "select SSD_full_name from SSD where price= $new6");
         $data6=mysqli_fetch_assoc($res6);
         $_SESSION['SSD_full_name'] = $data6['SSD_full_name'];
         
        //  setting $_SESSION['HDD_price'] and $_SESSION['HDD_full_name']
         $new7=(int)$HDD;
         $_SESSION['HDD_price']=$new7;
         $res7=mysqli_query($conn, "select HDD_full_name from HDD where price= $new7");
         $data7=mysqli_fetch_assoc($res7);
         $_SESSION['HDD_full_name'] = $data7['HDD_full_name'];
         
        //  setting $_SESSION['PSU_price'] and $_SESSION['PSU_full_name']
         $new8=(int)$PSU;
         $_SESSION['PSU_price']=$new8;
         $res8=mysqli_query($conn, "select ps_full_name from PSU where price= $new8");
         $data8=mysqli_fetch_assoc($res8);
         $_SESSION['PSU_full_name'] = $data8['ps_full_name'];
         
        //  setting $_SESSION['CPU_COOLER_price'] and $_SESSION['CPU_COOLER_full_name']
         $new9=(int)$CPU_COOLER;
         $_SESSION['CPU_COOLER_price']=$new9;
         $res9=mysqli_query($conn, "select cooler_full_name from CPU_COOLER where price= $new9");
         $data9=mysqli_fetch_assoc($res9);
         $_SESSION['CPU_COOLER_full_name'] = $data9['cooler_full_name'];

        //  redirecting
         echo '<script>
                window.location.href = "cart.php";
              </script>';
        }
       

    ?>

    <!-- header end -->

    <!-- main content -->
    <div class="customrig-main">

      <div class="build_image"> <!-- CASING images -->
        <img id='CASING_image' src="images/1.png" alt="৳" style="width: 250px;">
      </div>

      <div class="build_inputs"> <!-- form inputs -->
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
          
          <select required name="CASING" id="CASING_select" onchange="input_entered(this.name);calc_total(this.value);display(this.text)">
            <option disabled selected value='0'>-- Select Your Cabinet --</option>
              <?php
                
                $res=mysqli_query($conn, "select * from CASING");
                while($data=mysqli_fetch_array($res))
                { 
                  echo "<option value='". $data['price'] ."'>" .$data['full_name'] ."</option>";
                  // echo "<option value='". $data['price'] ."'>" .$data['full_name'] ."</option>";
                  
                  
                }
              ?>
            
          </select>
          
          <!-- CPU -->
          <select  name="CPU" id="CPU_select" onchange="input_entered(this.name);calc_total(this.value);"> 
            <option disabled selected value='0'>-- Select Your CPU --</option>
              <?php
                // $sql = "select company from CASING where company='Corsair'";
                $res=mysqli_query($conn, "select * from CPU");
                while($data=mysqli_fetch_array($res))
                { 
                  echo "<option value='". $data['price'] ."'>" .$data['CPU_full_name'] ."</option>";
                  
                }
              ?>
            
          </select>

          <!-- GPU -->
          <select  name="GPU" id="GPU_select" onchange="input_entered(this.name);calc_total(this.value);">
            <option disabled selected value='0'> SELECT YOUR GPU </option>
              <?php
                // $sql = "select company from CASING where company='Corsair'";
                $res=mysqli_query($conn, "select * from GPU");
                while($data=mysqli_fetch_array($res))
                { 
                  echo "<option value='". $data['price'] ."'>" .$data['GPU_full_name'] ."</option>";
                  
                }
              ?>
            
          </select>

          <!-- RAM -->
          <select  name="RAM" id="RAM_select" onchange="input_entered(this.name);calc_total(this.value);">
            <option disabled selected value='0'> SELECT YOUR RAM </option>
              <?php
                // $sql = "select company from CASING where company='Corsair'";
                $res=mysqli_query($conn, "select * from RAM");
                while($data=mysqli_fetch_array($res))
                { 
                  echo "<option value='". $data['price'] ."'>" .$data['RAM_full_name'] ."</option>";
                  
                }
              ?>
            
          </select>

          <!-- MOTHERBOARD -->
          <select  name="mb" id="mb_select" onchange="input_entered(this.name);calc_total(this.value);">
            <option disabled selected value='0'>-- Select Your MOTHERBOARD --</option>
              <?php
                // $sql = "select company from CASING where company='Corsair'";
                $res=mysqli_query($conn, "select * from MOTHERBOARD");
                while($data=mysqli_fetch_array($res))
                { 
                  echo "<option value='". $data['price'] ."'>" .$data['mb_full_name'] ."</option>";
                  
                }
              ?>
            
          </select>

          <!-- SSD -->
          <select  name="SSD" id="SSD_select" onchange="input_entered(this.name);calc_total(this.value);">
            <option disabled selected value='0'>-- Select Your SSD --</option>
              <?php
                // $sql = "select company from CASING where company='Corsair'";
                $res=mysqli_query($conn, "select * from SSD");
                while($data=mysqli_fetch_array($res))
                { 
                  echo "<option value='". $data['price'] ."'>" .$data['SSD_full_name'] ."</option>";
                  
                }
              ?>
            
          </select>

          <!-- HDD -->
          <select  name="HDD" id="HDD_select" onchange="input_entered(this.name);calc_total(this.value);">
            <option disabled selected value='0'>-- Select Your HDD --</option>
              <?php
                // $sql = "select company from CASING where company='Corsair'";
                $res=mysqli_query($conn, "select * from HDD");
                while($data=mysqli_fetch_array($res))
                { 
                  echo "<option value='". $data['price'] ."'>" .$data['HDD_full_name'] ."</option>";
                  
                }
              ?>
            
          </select>

          <!-- POWER SUPPLY -->
          <select  name="PSU" id="psu_select" onchange="input_entered(this.name);calc_total(this.value);">
            <option disabled selected value='0'>-- Select Your Power Supply --</option>
              <?php
                // $sql = "select company from CASING where company='Corsair'";
                $res=mysqli_query($conn, "select * from PSU");
                while($data=mysqli_fetch_array($res))
                { 
                  echo "<option value='". $data['price'] ."'>" .$data['ps_full_name'] ."</option>";
                  
                }
              ?>
            
          </select>

          <!-- CPU_COOLER -->
          <select  name="CPU_COOLER" id="CPU_COOLER_select" onchange="input_entered(this.name);calc_total(this.value);">
            <option disabled selected value='0'>Select Your CPU Cooler </option>
              <?php
                // $sql = "select company from CASING where company='Corsair'";
                $res=mysqli_query($conn, "select * from CPU_COOLER");
                while($data=mysqli_fetch_array($res))
                { 
                  echo "<option value='". $data['price'] ."'>" .$data['cooler_full_name'] ."</option>";
                  
                }
              ?>
            
          </select>
          
          

          <label for="" id="total_label">Total: 0</label>
          
          <button class="button-inp" onclick="reset_selection()" style="margin: 20px;
  padding: 10px;background-color: rgb(51, 1, 109);border:none;color:white;border-radius:15px;font-size:1em;cursor: pointer;">Reset</button>
          <input class="button-inp" type="submit" name="submit" value="Place Order" onclick="submit_redirect()" style="margin: 20px;
  padding: 10px;background-color: rgb(51, 1, 109);border:none;color:white;border-radius:15px;font-size:1em;cursor: pointer;">
        </form>
      </div>
        
    </div>
    
    <!-- main content end -->
    
    <!-- footer -->
    <?php include 'footer.php' ?>

    <script src="./script/custom-rigs.js"></script>
    
  </body>
</html>
