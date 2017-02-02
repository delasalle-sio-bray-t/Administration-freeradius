#!/usr/bin/expect

## Attention de bien modifier le shebang et de mettre expect
## Définition des variables

## En cas de problème le programme est arrêté au bout de 120 secondes
set timeout 120

## Récupération de l’adresse IP, login et mot de passe dans des variables
set Machine [lindex $argv 0]
set Username [lindex $argv 1]
set Password [lindex $argv 2]
spawn ssh $Username@$Machine
sleep 1
spawn telnet $Machine

## pause entre chaque saisie, obligatoire pour le bon fonctionnement du script
sleep 1
expect {
"Username:" {send "$Username\n"}
}
expect {
"Password:" {send "$Password\n"}
}
sleep 1
## Commande envoyée au routeur dont on veut récupérer le contenu
send "terminal length 0\n"
sleep 1
send "show vlan id 2-1000 | exclude enet | Type | -\n"
sleep 1
## Déconnexion du routeur
send "exit"
send "\r"

interact

exit

