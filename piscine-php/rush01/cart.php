<div class="cart">
  Vos produits :
  <br>
  <?php
    $k = 0;
    foreach ($_SESSION['cart'] as $product)
    {
      $k++;
      print("<div>" . $product['pd_name']);
      echo "  " . $product['quantities'] . "</div>";
    }
    echo "<br>";
    if ($k == 0)
    {
        echo "Panier vide";
    }
    else{
        print_r ("TOTAL : " . $_SESSION['cart']['total'] . " BTC");
        echo "  <br>
          <br>
          </form>
             Valider votre panier
             <form action='checkout.php' name='checkout' method='post' class='validate'>
               <div  class='submit_button'>
                   <input type='submit' name='submit' value='OK'>
               </div>
           </form>
         </div>";
    }
    ?>
<br><br>
