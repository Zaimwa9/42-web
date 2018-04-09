<?php
include "../connect.php";
include "../Model/Products.php";
include_once "../Model/Categories.php";
session_start();
foreach($_POST as $key => $input) {
	$_POST[$key] = htmlentities($input);
}
$product['pd_name'] = $_POST['mod_product_php'];
$product = fetch_unique_product($conn, $product);

print($product['pd_weight']);
print_r($product);
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type=text/css href="public_html/css/style.css">
</head>
<body>
 <h2> Modifier un produit </h2>
 <form action='./mod_product_php.php' name='mod_pd' method='post' class='newproduct'>
   Nom
   <input type='text' name='pd_name' value=<?php echo ($product['pd_name']);?> maxlength="20" pattern="[a-zA-Z0-9]+" size="30" required>
   <br>
   Prix
   <input type='number' name='pd_price' value=<?php echo ($product['pd_price']);?> size="4" required>
   <br>
   Stock
   <input type='number' name='pd_stock' value=<?php echo ($product['pd_stock']);?> size="3" required>
   <br>
   Pourcentage de réduction
   <input type='number' name='pd_onsale' value=<?php echo ($product['pd_onsale']);?> size="3" required>
   <br>
   <br>
   La/les catégorie(s) de votre produit
   <br>
   <?php
     $categories = fetch_categories($conn);
     foreach($categories as $category) {
       echo '<br>
       <input type="checkbox" name=' . $category['cat_id'] . 'Fun value=' . $category['cat_id'] . '>' . $category['cat_name'] . '';
      }
   ?>
   <br>
   <br>
   Couleur du produit
   <select name="pd_color">
       <option value=<?php echo ($product['pd_color']);?> selected disabled hidden><?php echo ($product['pd_color']);?> </option>
       <option value="Marron">Marron</option>
       <option value="Bleu">Bleu</option>
       <option value="Rouge">Rouge</option>
       <option value="Jaune">Jaune</option>
       <option value="Noir">Noir</option>
       <option value="Bois">Bois</option>
   </select>
   <br>
   <br>
   Poids en grammes
   <select name="pd_weight">
     <?php
     for ($i = intval($product['pd_weight']); $i <= 1800; $i = $i + 50) : ?>
     <option value="<?php echo $i; ?>"><?php echo $i. "g"; ?></option>
   <?php endfor; ?>
   </select>
   <br>
   Largeur en cm
   <select name="pd_width">
     <?php for ($i = intval($product['pd_width']); $i <= 60; $i = $i + 5) : ?>
     <option value="<?php echo $i; ?>"><?php echo $i. "cm"; ?></option>
   <?php endfor; ?>
   </select>
   <br>
   Longueur en cm
   <select name="pd_height">
     <?php for ($i = intval($product['pd_height']); $i <= 90; $i = $i + 5) : ?>
     <option value="<?php echo $i; ?>"><?php echo $i. "cm"; ?></option>
   <?php endfor; ?>
   </select>
   <br>
   <br>
   Mettre en avant le produit sur la page d'accueil
   <br>
   <?php
    $yes ="";
    $no  ="";
    if ($product['pd_featured'] == 1)
      $yes = "checked";
    else {
      $no = "checked";
    }
      ?>
   <input type="radio" name="pd_featured" value=1 <?php echo $yes;?>> Oui<br>
   <input type="radio" name="pd_featured" value=0 <?php echo $no;?>> Non<br>

   <br>
   <br>
   Entrez l'url de votre image, sinon une image par défaut sera chargée
   <input type="url" name="pd_img" value="<?php echo ($product['pd_img']);?> ">
   <br>
   <br>
   <div  class="submit_button">
       <input type='submit' name='submit' value='MODIFIER'>
   </div>
  </form>
  </body>
  </html>
