<?php
  include "./connect.php";
  include "./Model/Products.php";
  include "./Model/Categories.php";
  include "./Model/Users.php";
  session_start();
?>

<?php
	if (isset($_SESSION['isAuthenticated'])) {
		include "./logout.php";
	} else {
		echo ('<a href="http://192.168.99.100:8100/rush00/signin.php"><button>Go to login</button></a>');
		echo ('<a href="http://192.168.99.100:8100/rush00/signup.php"><button>Create account</button></a>');
	}
?>

<?php if ($_SESSION['isAdmin'] === TRUE) { ?>
 <html>
  <head>
   <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <link rel="stylesheet" type=text/css href="public_html/css/style.css">
  </head>
  <body>
    <h2> Gestion des produits </h2>
    <h3> Ajouter un produit </h3>
 		<form action='Controllers/add_product.php' name='add_pd' method='post' class='newproduct'>
 			Nom
      <input type='text' name='pd_name' maxlength="20" pattern="[a-zA-Z0-9]+" size="30" required>
 			<br>
      Prix
      <input type='number' name='pd_price' size="4" required>
      <br>
      Stock
      <input type='number' name='pd_stock' size="3" required>
      <br>
      Pourcentage de réduction
      <input type='number' name='pd_onsale' size="3" required>
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
        <?php for ($i = 200; $i <= 1800; $i = $i + 50) : ?>
        <option value="<?php echo $i; ?>"><?php echo $i. "g"; ?></option>
      <?php endfor; ?>
      </select>
      <br>
      Largeur en cm
      <select name="pd_width">
        <?php for ($i = 20; $i <= 60; $i = $i + 5) : ?>
        <option value="<?php echo $i; ?>"><?php echo $i. "cm"; ?></option>
      <?php endfor; ?>
      </select>
      <br>
      Longueur en cm
      <select name="pd_height">
        <?php for ($i = 10; $i <= 90; $i = $i + 5) : ?>
        <option value="<?php echo $i; ?>"><?php echo $i. "cm"; ?></option>
      <?php endfor; ?>
      </select>
      <br>
      <br>
      Mettre en avant le produit sur la page d'accueil
      <br>
      <input type="radio" name="pd_featured" value=1 checked> Oui<br>
      <input type="radio" name="pd_featured" value=0> Non<br>

      <br>
      <br>
      Entrez l'url de votre image, sinon une image par défaut sera chargée
      <input type="url" name="pd_img">
      <br>
      <br>
      <div  class="submit_button">
 			    <input type='submit' name='submit' value='AJOUTER'>
      </div>
 		 </form>
        <h3> Supprimer un/des produit(s) </h3>
        <form action='Controllers/del_product.php' name='del_pd' method='post' class='newproduct'>
          Sélectionnez les produits à supprimer
          <br>
          <?php
            $products = fetch_products($conn);
            foreach($products as $product) {
              echo '<br>
              <input type="checkbox" name=' . $product['pd_name'] . ' value=' . $product['pd_id'] . '>' . $product['pd_name'] . '';
             }
          ?>
          <br>
          <br>
          <div  class="submit_button">
     			    <input type='submit' name='submit' value='SUPPRIMER'>
          </div>
        </form>
        <h3> Modifier un produit </h3>
        <form action='Controllers/mod_product.php' name='del_pd' method='post' class='newproduct'>
          Sélectionnez le produit à modifier
          <select name="mod_product.php">
            <?php
              $products = fetch_products($conn);
              foreach($products as $product) {
                echo '<br>
                <option value='. $product['pd_name'] .'>' . $product['pd_name']. '</option>';
               }

            ?>
          </select>
            <br>
            <br>
            <div  class="submit_button">
                 <input type='submit' name='submit' value='MODIFIER'>
            </div>
          </select>

       </form>

        <hr>
    <br>
    <h2> Gestion des utilisateurs </h2>
    <h3> Ajouter un utilisateur </h3>
    <form method="post" action="./Controllers/add_login.php" style="width=100px;;margin:auto;border: 5px solid black;">
      Firstname: <input type="text" name="usr_firstname" value="emmanuel" required/><br>
      Lastname: <input type="text" name="usr_lastname" value="macron" required/><br>
      birth date: <input type="date" name="usr_birth_date" value="01/01/1970" required/> (ex: 01/01/1970)<br>
      pwd: <input type="password" name="usr_pwd" value="abc" required><br>
      email: <input type="email" name="usr_email" value="lol@lol.com" required/><br>
      location: <input type="text" name="usr_location" value="groland" required/><br>
      <input type="submit" name="submit" value="OK"/>
    </form>
    <h3> Supprimer un/des utilisateur(s) </h3>
    <form action='Controllers/del_user.php' name='del_usr' method='post' class='newproduct'>
    <?php
      $users = fetch_all_users($conn);
      foreach($users as $user) {
         echo '<br>
         <input type="checkbox" name=' . $user['usr_email'] . ' value=' . $user['usr_id'] . '>' . $user['usr_email'] . '';
        }
      ?>
      <br>
      <br>
      <div  class="submit_button">
           <input type='submit' name='submit' value='SUPPRIMER'>
      </div>
    </form>
    <h2> Gestion des catégories </h2>
    <h3> Ajouter une catégorie </h3>
 		<form action='Controllers/add_cat.php' name='add_cat' method='post' class='newproduct'>
 			Nom de la catégorie
      <br>
      <input type='text' name='cat_name' maxlength="20" pattern="[a-zA-Z0-9]+" size="30" required>
 			<br>
      <div  class="submit_button">
          <input type='submit' name='submit' value='AJOUTER'>
      </div>
 		 </form>
    <h3> Supprimer une catégorie </h3>
    <form action='Controllers/del_cat.php' name='del_cat' method='post' class='newproduct'>
      Sélectionnez les catégories à supprimer
      <br>
      <?php
        $categories = fetch_categories($conn);
        foreach($categories as $category) {
          echo '<br>
          <input type="checkbox" name=' . $category['cat_name'] . ' value=' . $category['cat_id'] . '>' . $category['cat_name'] . '';
         }
      ?>
      <br>
      <br>
      <div  class="submit_button">
          <input type='submit' name='submit' value='SUPPRIMER'>
      </div>
    </form>
</body>
<?php } else {
    include "./signup.php";
} ?>
</html>
