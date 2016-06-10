/**
 * Created by Drawog on 25/02/2016.
 */

var index =0;

function insertTag() {


    var run = document.getElementById("b1");
    run.onclick= function run(){
        index++;
        var br = document.createElement('p');
        var br2 = document.createElement('p');
        var somme = document.createElement('INPUT');
        var description =document.createElement('TEXTAREA')
        somme.name='recompense'+index;
        somme.setAttribute("type", "number");
        somme.setAttribute('na', 'post');
        somme.setAttribute('maxlength', 5000);
        somme.setAttribute('cols',80);
        somme.setAttribute('rows', 1);
        somme.setAttribute('placeholder',"sommes à atteindre")
        monster.insertBefore(somme,monster.childNodes[0]);
        description.setAttribute("type", "text");
        description.setAttribute('na', 'post');
        description.setAttribute('maxlength', 5000);
        description.setAttribute('cols',80);
        description.setAttribute('rows', 5);
        description.setAttribute('placeholder',"Entrez la description de votre récompense (ex : pour 50€ vous aurrez un t-shirt dédicassé)");
        description.name='description'+index;
        document.getElementById("monster").insertBefore(somme,somme.childNodes[0]);
        document.getElementById("monster").insertBefore(br,somme.childNodes[0]);
        document.getElementById("monster").insertBefore(description,somme.childNodes[0]);
        document.getElementById("monster").insertBefore(br2,somme.childNodes[0]);



    }
}

insertTag();