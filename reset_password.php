<?php
	$email = $_POST['email'];
	
	if($email == "")
	{
?>
	<DIV id="">
		<FORM method="POST" action="index.php?page=reset_password">
			<LABEL>Donnez votre adresse E-mail pour qu'on vous envoie le mot de passe</LABEL><BR />
			<INPUT type="text" name="email" size="20"><BR />
			<INPUT type="submit" size="10" value="Envoyer">
			<INPUT type="reset" size="10" value="Annuler" onclick="window.location='index.php'">
		</FORM>
	</DIV>
<?php
	}
	else
	{
		// searching for the user's password and send him an e-mail		
		if(mail('boussettahichem@yahoo.fr','Restauration de mot de passe', 'Votre mot de passe est le suivant'))
		{
			print('An e-mail containing the password has been sent to you.');
		}
		else
		{
			print('Un problème est survenu lors de l\'envoi du mail'); 
		}
	}
?>