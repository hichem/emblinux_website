<?php
	//variables utiles pour la verification si le pseudo , le mot de passe et l'e-mail sont valables 
	include('globals.php');
	
	$verif_user_name=false;
	$verif_pass=false;
	$verif_email=false;
	$affichage_message_erreur=false;
	
	//on enregistre les variables et  On rend inoffensives les balises HTML que le visiteur a pu rentrer
	
	if(isset($_POST['nom']))
	{
		$nom=htmlspecialchars($_POST['nom']);
	}
	else
	{
		$nom='';
	}
	if(isset($_POST['prenom']))
	{
		$prenom=htmlspecialchars($_POST['prenom']);
	}
	else
	{
		$prenom='';
	}
	if(isset($_POST['user_name']))
	{
		$user_name=htmlspecialchars($_POST['user_name']);
	}
	else
	{
	$user_name='';
	}
	if(isset($_POST['email']))
	{
		$email=htmlspecialchars($_POST['email']);
	}
	else
	{
		$email='';
	}
	if(isset($_POST['pass']))
	{
		$pass=htmlspecialchars($_POST['pass']);
	}
	else
	{
		$pass='';
	}
	if(isset($_POST['re_pass']))
	{
		$re_pass=htmlspecialchars($_POST['re_pass']);
	}
	else
	{
	$re_pass='';
	}
	if(isset($_POST['profession']))
	{
		$profession = htmlspecialchars($_POST['profession']);
	}
	else
	{
		$profession='';
	}	
	
	// verification si tous les cases sont remplis 
	if(($nom!="") and ($prenom!="") and ($email!="") and ($re_pass!="") and ($user_name!="") and ($pass!="") )
	{
		//pour verifier que les deux mot de passe  saisis sont identiques 
		if($pass==$re_pass)
		{ 
			$verif_pass=true;
		}
		// connection à la base de données 
		$db_connection = mysql_connect($mysql_server,$mysql_user,$mysql_passwd) or die('Impossible de se connecter au serveur');
		if($db_connection)
		{
			mysql_select_db($mysql_db) or die('Base de données introuvable');
		}
		
		//pour verifier que le pseudo saisi n'existe pas dans la base de données 
		$reponse=mysql_query("select login from users where login='".$user_name."'") or die(mysql_error());
		$donnée=mysql_fetch_array($reponse); 
		if(!$donnée['login'])
		{  
			$verif_user_name=true;
		}
		
		//pour verifier que l'e-mail saisi est de la forme personne@fournisseur.extension
		if (preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $email))
		{
			$verif_email=true;
		}	
		//pour affichier les messages d'erreur s'il existe 
		$affichage_message_erreur=true;
		if(($verif_user_name==true)and ($verif_pass==true) and ($verif_email==true))
		{				
			mysql_query("insert into users values (0,'".$nom."','".$prenom."','".$email."','".$user_name."','".$pass."','user')") or die (mysql_error());
			if($db_connection)
			{
				mysql_close();
			}
			echo "Vos informations ont été envoyées<br/><br/>";
			echo "Pour revenir à la page d'accueil <a href=\"index.php\" alt=\"\">Cliquez ici</a>";
			system("$perm $work_dir/adduser.pl add -u ".$user_name." &");
		}
		elseif ($verif_user_name == false)
		{
			echo 'Ce nom d\'utilisateur est déjà utilisé';
		}
		elseif($verif_pass == false)
		{
			echo 'Le mot de passe que vous avez resaisi n\'est pas correct';
		}
		elseif($verif_email == false)
		{
			echo 'Cette adresse email est déjà utilisée';			
		}

	}
	else
	{	
?>
		<form method="POST" action="index.php?page=register">
			<label>Pseudo :                               </label>
			<input type="text" name="user_name"<?php if($verif_user_name==true) echo 'value="'.$user_name.'"';?>  />
			<?php
			if(($verif_user_name==false)and($affichage_message_erreur==true))
			{
				echo "Nom d'utilisateur non validé";
			}
			?>
			<br />
			<label>Mot de passe :                      </label>  
			<input type="password" name="pass"  />
			<?php
			if(($verif_pass==false)and($affichage_message_erreur==true))
			{
			echo "mot de passe non validé";
			}
			?>
			<br />
			
			<label>Resaisissez votre mot de passe :  </label>
			<input type="password" name="re_pass"/><br />
			<label>Nom :                    </label>
			<input type="text" name="nom" id="nom" value="<?php echo $nom;?>" /><br />
			
			<label>Prénom :                </label>
			<input type="text" name="prenom" id="prenom" value="<?php echo $prenom;?>"  /><br />
			
			<label>E-mail :                  </label>  
			<input type="text" name="email" id="email" value="<?php echo $email;?>"  />
			
			<?php
				if(($verif_email==false)and($affichage_message_erreur==true))
				{
					echo "E-mail non validé";
				}
			?>
			<br />
			<LABEL>Profession :</LABEL>
			<SELECT name="profession">
				<option value="etudiant" <?php if($profession== "etudiant") echo 'selected="selected"';?>>Etudiant</option>
				<option value="ingénieur" <?php if($profession== "ingénieur") echo 'selected="selected"';?>>Ingénieur</option>
				<option value="professeur" <?php if($profession== "professeur") echo 'selected="selected"';?>>Professeur</option>
				<option value="autres" <?php if($profession== "autres") echo 'selected="selected"';?>>Autres</option>
			</SELECT><BR />
			<input type="submit" value="S'enregistrer" />
			<input type="reset" value="Annuler" onclick="window.location='index.php'"/>		
		</form>
<?php
	}	
?>