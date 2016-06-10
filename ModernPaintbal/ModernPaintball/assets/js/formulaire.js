/**
 * Created by Drawog on 25/02/2016.
 */



var radioKyck=document.getElementById('radioKyck');
var radioTipee=document.getElementById('radioTipee');
var divKyck = document.getElementById('blockKyck');
var input1=document.createElement('INPUT');
input1.type='date';
input1.name='dateCloture';
input1.value='date de cloturation';
input1.required="";
var input2=document.createElement('INPUT');
input2.type='number';
input2.name='montantAttendu';
input2.value='1';
input2.required="";
var br = document.createElement('p');
var br2 = document.createElement('p');
radioKyck.onclick=function(){

    divKyck.appendChild(input1);
    divKyck.appendChild(br);
    divKyck.appendChild(input2);
    divKyck.appendChild(br2);
};

radioTipee.onclick=function(){
    divKyck.removeChild(input1);
    divKyck.removeChild(input2);
    divKyck.removeChild(br);
    divKyck.removeChild(br2);
};




var form1=document.getElementsByName('form1');
var checkbox = document.getElementsByName('ckb[]');
function chkcontrol(j) {
    var total=0;
    for(var i=0; i < 6; i++){
        if(checkbox[i].checked){
            total =total +1;}
        if(total > 1){
            checkbox[j].checked = false ;
            alert("Veuillez sélectionner un seul genre.");
            return false;
        }
    }
}





