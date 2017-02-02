#!/bin/bash

heure=$(date +%Y-%m-%d-%H:%M)

#Demande à l utilisateur de saisir l'adresse ip du switch
echo "Tapez l'adresse ip du switch sur lequel se connecter :"
read adresseSwitch


#Demande son login
echo "identifiant :"
read login

#Demande son mdp
echo "mot de passe :"
read -s mdp

#Demande s il souhaite la creation d un vlan
echo "Voulez vous creer un vlan ?(y/n)"
read vlan

if [ $vlan = y ]
then
	echo "Nom du vlan :"	#Demande le nom du vlan
	read nomVlan

	echo "Numero du vlan :"	#Demande le numero du vlan
	read numVlan
	../script/scriptCreaVlan.sh $adresseSwitch $login $mdp $numVlan $nomVlan

else

	echo "Voulez vous supprimer un vlan ? (y/n)"	#Demande s il veut supprimer un vlan
	read suppVlan


		if [ $suppVlan = y ]	#Si oui, alors demande quel vlan
		then
			echo "Quel vlan (numero) ?"
			read numVlanSupp

			/home/user/Documents/suppVlan.sh $adresseSwitch $login $mdp $numVlanSupp

		else

			echo "Affichage des vlans dans le fichier :" vlan$heure
			/home/user/Documents/scriptExpect.sh $adresseSwitch $login $mdp > vlan$heure

		fi
fi

exit
